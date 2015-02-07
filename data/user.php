<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for User
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
require_once 'core/player.php';


// Returns true if the user is a staff member in any tournament
function UserIsManagerAnywhere($userid)
{
    if (empty($userid))
        return null;

    $userid = (int) $userid;

    $query = format_query("SELECT :User.id
                            FROM :User
                            INNER JOIN :EventManagement ON :User.id = :EventManagement.User
                            WHERE :User.id = $userid AND :EventManagement.Role IN ('TD', 'Official')");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = (mysql_num_rows($result) == 1);
    mysql_free_result($result);

    return $retValue;
}


// Returns a User object for the user whose email is $email
// Returns null if no user was found
function GetUserIdByEmail($email)
{
    if (empty($email))
        return null;

    $email = esc_or_null($email);

    $query = format_query("SELECT id FROM :User WHERE UserEmail = $email");
    $result = execute_query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = $row['id'];
    }
    mysql_free_result($result);

    return $retValue;
}


// Returns an array of User objects
function GetUsers($searchQuery = '', $sortOrder = '')
{
    $sort = "Username";
    if ($sortOrder)
        $sort = data_CreateSortOrder($sortOrder,
            array('name' => array('UserLastname', 'UserFirstname'), 'UserFirstname', 'UserLastname', 'pdga', 'Username'));

    $where = data_ProduceSearchConditions($searchQuery,
        array('UserFirstname', 'UserLastname', 'Username', ':Player.lastname', ':Player.firstname'));

    $query = format_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname, :User.Player,
                                :Player.lastname AS pLN, :Player.firstname AS pFN, :Player.email AS pEM
                            FROM :User
                            LEFT JOIN :Player ON :User.Player = :Player.player_id
                            WHERE $where
                            ORDER BY $sort");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            $temp = new User($row['id'], $row['Username'], $row['Role'],
                data_GetOne($row['UserFirstname'], $row['pFN']),
                data_GetOne($row['UserLastname'], $row['pLN']),
                data_GetOne($row['UserEmail'], $row['pEM']),
                $row['Player']);
            $retValue[] = $temp;
        }
    }
    mysql_free_result($result);

    return $retValue;
}


// Returns an array of User objects for users who are also Players
// (optionally filtered by search conditions provided in $query)
function GetPlayerUsers($query = '', $sortOrder = '', $with_pdga_number = true)
{
    if ($with_pdga_number)
        $searchConditions = data_ProduceSearchConditions($query,
            array('Username', 'pdga', 'UserFirstname', 'UserLastname'));
    else
        $searchConditions = data_ProduceSearchConditions($query,
            array('Username', 'UserFirstname', 'UserLastname'));

    $sort = "Username";
    if ($sortOrder)
        $sort = data_CreateSortOrder($sortOrder,
            array('name' => array('UserLastname', 'UserFirstname'), 'UserFirstname', 'UserLastname', 'pdga', 'Username'));

    $query = format_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname, Player
                            FROM :User
                            INNER JOIN :Player ON :Player.player_id = :User.Player
                            WHERE :User.Player IS NOT NULL AND $searchConditions
                            ORDER BY $sort");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            $temp = new User($row['id'], $row['Username'], $row['Role'],
                $row['UserFirstname'], $row['UserLastname'], $row['UserEmail'], $row['Player']);
            $retValue[] = $temp;
        }
    }
    mysql_free_result($result);

    return $retValue;
}


// Gets a User object by the id number
// Returns null if no user was found
function GetUserDetails($userid)
{
    if (empty($userid))
        return null;

    $id = (int) $userid;

    $query = format_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname,
                                :Player.firstname AS pFN, :Player.lastname AS pLN, :Player.email AS pEM, :User.Player
                            FROM :User
                            LEFT JOIN :Player on :Player.player_id = :User.Player
                            WHERE id = $id");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = new User($row['id'], $row['Username'], $row['Role'],
            data_GetOne($row['UserFirstname'], $row['pFN']),
            data_GetOne($row['UserLastname'], $row['pLN']),
            data_GetOne($row['UserEmail'], $row['pEM']),
            $row['Player']);
    }

    mysql_free_result($result);

    return $retValue;
}


// Gets the user id for the username
// Returns null if the user was not found
function GetUserId($username)
{
    if (empty($username))
        return null;

    $username = esc_or_null($username);

    $query = format_query("SELECT id FROM :User WHERE Username = $username");
    $result = execute_query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = $row['id'];
    }
    mysql_free_result($result);

    return $retValue;
}


// Gets a Player object for the User by userid or null if the player was not found
function GetUserPlayer($userid)
{
    if (empty($userid))
        return null;

    $id = (int) $userid;

    $query = format_query("SELECT :Player.player_id AS id, pdga AS PDGANumber, sex AS Sex,
                                YEAR(birthdate) AS YearOfBirth, firstname, lastname, email
                            FROM :Player
                            INNER JOIN :User ON :User.Player = :Player.player_id
                            WHERE :User.id = $id");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = new Player($row['id'], $row['PDGANumber'], $row['Sex'],
            $row['YearOfBirth'], $row['firstname'], $row['lastname'], $row['email']);
    }
    mysql_free_result($result);

    return $retValue;
}


// Edits users user and player information
function EditUserInfo($userid, $email, $firstname, $lastname, $gender, $pdga, $dobyear)
{
    $userid = (int) $userid;
    $email = esc_or_null($email);
    $firstname = esc_or_null(data_fixNameCase($firstname));
    $lastname = esc_or_null(data_fixNameCase($lastname));

    $query = format_query("UPDATE :User
                            SET UserEmail = $email, UserFirstName = $firstname, UserLastName = $lastname
                            WHERE id = $userid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $u = GetUserDetails($userid);
    $player = $u->GetPlayer();

    if ($player) {
        $playerid = (int) $player->id;
        error_log("gender before=$gender");
        $gender = esc_or_null(strtoupper($gender) == 'M' ? "male" : "female");
        error_log("gender after=$gender");
        $pdga = esc_or_null($pdga, 'int');
        $dobyear = esc_or_null((int) $dobyear . '-1-1');

        $query = format_query("UPDATE :Player
                                SET sex = $gender, pdga = $pdga, birthdate = $dobyear,
                                    firstname = $firstname, lastname = $lastname, email = $email
                                WHERE player_id = $playerid");
        $result = execute_query($query);

        if (!$result)
            return Error::Query($query);
    }
}


/**
 * Function for setting or changing the user data.
 *
 * @param class User $user - single system users personal data
 */
function SetUserDetails($user)
{
    $retValue = null;

    if (!is_a($user, "User"))
        return Error::internalError("Wrong class as argument");

    $u_username_quoted = esc_or_null($user->username);
    $u_email = esc_or_null($user->email);
    $u_password = esc_or_null($user->password);
    $u_hash = esc_or_null($user->GetHashType());
    $u_salt = esc_or_null($user->salt);
    $u_role = esc_or_null($user->role);
    $u_firstname = esc_or_null(data_fixNameCase($user->firstname));
    $u_lastname = esc_or_null(data_fixNameCase($user->lastname));
    $player = esc_or_null($user->player, 'int');

    // Check that username is not already in use
    if (!GetUserId($user->username)) {
        // Username is unique, proceed to insert into table
        $query = format_query("INSERT INTO :User (Username, UserEmail, Password, Role, UserFirstName, UserLastName, Player, Hash, Salt)
                             VALUES ($u_username_quoted, $u_email, $u_password, $u_role, $u_firstname,
                                $u_lastname, $player, $u_hash, $u_salt)");
        $result = execute_query($query);

        if (!$result)
            return Error::Query($query);

        // Get id for the new user
        $u_id = mysql_insert_id();
        $user->SetId($u_id);
        $retValue = $user;
    }
    else {
        // Username already in use, report error
        // TODO: Maybe use some Error::<something>
        $err = new Error();
        $err->title = "error_invalid_argument";
        $err->description = translate("error_invalid_argument_description");
        $err->internalDescription = "Username is already in use";
        $err->function = "SetUserDetails()";
        $err->IsMajor = false;
        $err->data = "username:" . $u_username . "; role:" . $u_role . "; firstname:" . $u_firstname . "; lastname:" . $u_lastname;
        $retValue = $err;
    }

    return $retValue;
}


function SaveUserSflId($userid, $sflid)
{
    $userid = (int) $userid;

    if (!$sflid)
        return;

    $sflid = esc_or_null($sflid, 'int');

    $query = format_query("UPDATE :User SET SflId = $sflid WHERE id = $userid");
    execute_query($query);
}


function SaveUserClub($userid, $clubid)
{
    $userid = (int) $userid;
    $clubid = esc_or_null($clubid, 'int');

    $query = format_query("UPDATE :User SET Club = $clubid WHERE id = $userid");
    execute_query($query);
}


function GetUserEvents($ignored, $eventType = 'all')
{
    $conditions = '';
    if ($eventType == 'participant' || $eventType == 'all')
        $conditions = ':Participation.Player IS NOT NULL';

    if ($eventType == 'manager' || $eventType == 'all') {
        if ($conditions)
            $conditions .= " OR ";
        $conditions = ':EventManagement.Role IS NOT NULL';
    }

    return data_GetEvents($conditions);
}
