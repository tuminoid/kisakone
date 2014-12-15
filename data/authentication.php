<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Crypto
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


/**
 * Check user authentication
 *
 * Returns a User object if $username and $password matched a user in the database
 * Returns null if no match was found
 * Returns an Error object if there was a connection error or if the user is banned
 */
function CheckUserAuthentication($username, $password)
{
    if (empty($username) || empty($password))
        return null;

    $dbError = InitializeDatabaseConnection();
    if ($dbError)
        return $dbError;

    $retValue = null;
    $usr = mysql_real_escape_string($username);
    $pw = md5($password);

    $query = data_query("SELECT id, Username, UserEmail, Role, UserFirstname, UserLastname,
                                   :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM, Player
                                   FROM :User
                                   LEFT JOIN :Player ON :User.Player = :Player.player_id
                                   WHERE Username = '%s' AND Password = '%s'", $usr, $pw);

    $result = mysql_query($query);
    if (!$result)
        return Error::Query($query);

    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);

        $retValue = array($row['id'], $row['Username'] , $row['Role'],
                          data_GetOne($row['UserFirstname'], $row['pFN']),
                          data_GetOne($row['UserLastname'], $row['pLN']),
                          data_GetOne($row['UserEmail'], $row['pEM']), $row['Player']);
    }
    mysql_free_result($result);

    return $retValue;
}


/**
 * Check user authentication method
 */
function GetUserAuthenticationMethod($username)
{
    if (empty($username))
        return null;

    $dbError = InitializeDatabaseConnection();
    if ($dbError)
        return $dbError;

    $usr = mysql_real_escape_string($username);
    $query = data_query("SELECT Hash FROM :User WHERE Username = '%s'", $usr);

    $result = mysql_query($query);
    if (!$result)
        return Error::Query($query);

    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = new $row['Hash'];
    }
    mysql_free_result($result);

    return $retValue;
}
