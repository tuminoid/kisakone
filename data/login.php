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
 * Returns a array of data for creating User ob if $username and $password matched a user in the database
 * Returns null if no match was found
 * Returns an Error object if there was a connection error or if the user is banned
 */
function CheckUserAuthentication($username, $password)
{
    $retValue = null;

    if (empty($username) || empty($password))
        return null;

    $usr = escape_string($username);
    $logindata = get_login_data($usr);
    if (!$logindata) {
        error_log("error: failed to get login data for '$usr'");
        return null;
    }

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

        return $retValue;
    }
    else {
        error_log("login failed");
        error_log("data in db: hash=$db_hash type=$logindata[1] salt=$logindata[2]");
        error_log("user hash=$usr_hash");
    }

    return null;
}


/**
 * Get user login data, ie. array of (pass, hashtype, salt)
 */
function get_login_data($username)
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
