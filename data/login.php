<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Login functions
 *
 * --
 *
 * This file is part of Kisakone.
 * Kisakone is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kisakone is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Kisakone.  If not, see <http://www.gnu.org/licenses/>.
 * */

require_once 'data/db_init.php';
require_once 'core/login.php';


/**
 * Check user authentication
 *
 * @param string $username username
 * @param string $password plaintext password
 *
 * @return a array of data for creating User ob if $username and $password matched a user in the database
 * @return null if no match was found
 * @return an Error object if there was a connection error
 */
function CheckUserAuthentication($username, $password)
{
    $retValue = null;

    if (empty($username) || empty($password))
        return null;

    $usr = escape_string($username);
    $logindata = GetLoginData($usr);
    if (!$logindata)
        return null;

    $db_hash = $logindata[0];
    $usr_hash = GenerateHash($password, $logindata[1], $logindata[2]);

    if (!strcmp($db_hash, $usr_hash)) {
        $query = format_query("SELECT id, Username, UserEmail, Role, UserFirstname, UserLastname,
                                       :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM, Player
                                       FROM :User
                                       LEFT JOIN :Player ON :User.Player = :Player.player_id
                                       WHERE Username = '$usr'");
        $result = execute_query($query);

        if (mysql_num_rows($result) == 1) {
            $row = mysql_fetch_assoc($result);
            $retValue = array($row['id'],
                              $row['Username'],
                              $row['Role'],
                              data_GetOne($row['UserFirstname'], $row['pFN']),
                              data_GetOne($row['UserLastname'], $row['pLN']),
                              data_GetOne($row['UserEmail'], $row['pEM']),
                              $row['Player']);
        }
        mysql_free_result($result);

        execute_query(format_query("UPDATE :User SET LastLogin = NOW() WHERE Username = '$usr'"));

        return $retValue;
    }

    return null;
}


/**
 * Get user login data, ie. array of (pass, hashtype, salt)
 *
 * @param string $username username
 * @return null on failure
 * @return array of (password, hashtype, salt) on success
 */
function GetLoginData($username)
{
    if (empty($username))
        return null;

    $usr = escape_string($username);
    $query = format_query("SELECT Hash,Salt,Password FROM :User WHERE Username = '%s'", $usr);
    $result = execute_query($query);

    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = array($row['Password'], $row['Hash'], $row['Salt']);
    }
    mysql_free_result($result);

    return $retValue;
}


/**
 * Change users password in database
 *
 * @param int $userid user id
 * @param int $password plaintext password
 *
 * @return null on success
 * @return Error object on failure
 */
function ChangeUserPassword($userid, $password)
{
    $userid = (int) $userid;
    $salt = GenerateSalt();
    $hash = "crypt";
    $password = GenerateHash($password, $hash, $salt);

    $query = format_query("UPDATE :User SET Password = '$password', Hash = '$hash', Salt = '$salt', PasswordChanged = NOW() WHERE id = $userid");
    $result = execute_query($query);

    if (!$result) {
        $err = new Error();
        $err->title = "error_db_query";
        $err->description = translate( "error_db_query_description");
        $err->internalDescription = "Failed SQL UPDATE";
        $err->function = "ChangeUserPassword()";
        $err->IsMajor = true;
        $err->data = "User id: " . $userid;

        return $err;
    }
    mysql_free_result($result);

    return null;
}


/**
 * Returns an MD5 hash calculated from the User properties
 *
 * @param int $userid user id whose token should be calculated
 * @return token
 * @return null if the user was not found
 */
function GetUserSecurityToken($userid)
{
    $token = GetAutoLoginToken($userid);
    if ($token)
        return substr($token, 0, 10);
    return $retValue;
}


/**
 * Gets an MD5 hash of the User properties
 *
 * @param int $userid user id whose hash should be calculated
 * @return token
 * @return null if the user was not found
 */
function GetAutoLoginToken($userid)
{
    if (empty($userid))
        return null;

    $retValue = null;
    $id = (int) $userid;

    $query = format_query("SELECT id,Username,UserEmail,Password FROM :User WHERE id = $id");
    $result = execute_query($query);

    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $text = '';

        foreach ($row as $field)
            $text .= $field;
        $retValue = md5($text);
    }
    mysql_free_result($result);

    return $retValue;
}

