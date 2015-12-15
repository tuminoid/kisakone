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

require_once 'data/db.php';
require_once 'core/player.php';


// Returns true if the user is a staff member in any tournament
function UserIsManagerAnywhere($userid)
{
    $userid = esc_or_null($userid, 'int');

    return db_one("SELECT :User.id
                    FROM :User
                    INNER JOIN :EventManagement ON :User.id = :EventManagement.User
                    WHERE :User.id = $userid AND :EventManagement.Role IN ('TD', 'Official')");
}


// Returns a User object for the user whose email is $email
// Returns null if no user was found
function GetUserIdByEmail($email)
{
    $email = esc_or_null($email, 'string');

    $row = db_one("SELECT id FROM :User WHERE UserEmail = $email AND UserEmail IS NOT NULL");

    return @$row['id'];
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

    $result = db_all("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname, :User.Player,
                                :Player.lastname AS pLN, :Player.firstname AS pFN, :Player.email AS pEM
                            FROM :User
                            LEFT JOIN :Player ON :User.Player = :Player.player_id
                            WHERE $where
                            ORDER BY $sort");

    if (db_is_error($result))
        return array();

    $retValue = array();
    foreach ($result as $row) {
        $retValue[] = new User($row['id'], $row['Username'], $row['Role'],
            data_GetOne($row['UserFirstname'], $row['pFN']),
            data_GetOne($row['UserLastname'], $row['pLN']),
            data_GetOne($row['UserEmail'], $row['pEM']),
            $row['Player']);
    }

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

    $result = db_all("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname, Player
                        FROM :User
                        INNER JOIN :Player ON :Player.player_id = :User.Player
                        WHERE :User.Player IS NOT NULL AND $searchConditions
                        ORDER BY $sort");

    if (db_is_error($result))
        return array();

    $retValue = array();
    foreach ($result as $row) {
        $retValue[] = new User($row['id'], $row['Username'], $row['Role'],
            $row['UserFirstname'], $row['UserLastname'], $row['UserEmail'], $row['Player']);
    }

    return $retValue;
}


// Gets a User object by the id number
// Returns null if no user was found
function GetUserDetails($userid)
{
    $id = esc_or_null($userid, 'int');

    $row = db_one("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname,
                            :Player.firstname AS pFN, :Player.lastname AS pLN, :Player.email AS pEM, :User.Player
                        FROM :User
                        LEFT JOIN :Player on :Player.player_id = :User.Player
                        WHERE id = $id");

    if (db_is_error($row))
        return $row;

    if (empty($row))
        return null;

    return new User($row['id'], $row['Username'], $row['Role'],
            data_GetOne($row['UserFirstname'], $row['pFN']),
            data_GetOne($row['UserLastname'], $row['pLN']),
            data_GetOne($row['UserEmail'], $row['pEM']),
            $row['Player']);
}


// Gets the user id for the username
// Returns null if the user was not found
function GetUserId($username)
{
    $username = esc_or_null($username, 'string');

    $row = db_one("SELECT id FROM :User WHERE Username = $username");

    return @$row['id'];
}


// Gets a Player object for the User by userid or null if the player was not found
function GetUserPlayer($userid)
{
    $id = esc_or_null($userid, 'int');

    $row = db_one("SELECT :Player.player_id AS id, pdga AS PDGANumber, sex AS Sex,
                            YEAR(birthdate) AS YearOfBirth, firstname, lastname, email
                        FROM :Player
                        INNER JOIN :User ON :User.Player = :Player.player_id
                        WHERE :User.id = $id");

    if (db_is_error($row))
        return $result;

    if (empty($row))
        return null;

    return new Player($row['id'], $row['PDGANumber'], $row['Sex'],
                    $row['YearOfBirth'], $row['firstname'], $row['lastname'], $row['email']);
}


// Edits users user and player information
function EditUserInfo($userid, $email, $firstname, $lastname, $gender, $pdga, $dobyear)
{
    $uid = esc_or_null($userid, 'int');
    $email = esc_or_null($email, 'string');
    $firstname = esc_or_null(data_fixNameCase($firstname));
    $lastname = esc_or_null(data_fixNameCase($lastname));

    $result = db_exec("UPDATE :User
                        SET UserEmail = $email, UserFirstName = $firstname, UserLastName = $lastname
                        WHERE id = $uid");

    if (db_is_error($result))
        return $result;

    $u = GetUserDetails($userid);
    $player = $u->GetPlayer();

    if ($player) {
        $playerid = esc_or_null($player->id, 'int');
        $gender = esc_or_null(strtoupper($gender) == 'M' ? "male" : "female");
        $pdga = esc_or_null($pdga, 'int');
        $dobyear = esc_or_null((int) $dobyear . '-1-1');

        return db_exec("UPDATE :Player
                            SET sex = $gender, pdga = $pdga, birthdate = $dobyear,
                                firstname = $firstname, lastname = $lastname, email = $email
                            WHERE player_id = $playerid");
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
        return Error::InternalError("Wrong class as argument");

    $u_username_quoted = esc_or_null($user->username, 'string');
    $u_email = esc_or_null($user->email, 'string');
    $u_password = esc_or_null($user->password, 'string');
    $u_hash = esc_or_null($user->GetHashType(), 'string');
    $u_salt = esc_or_null($user->salt, 'string');
    $u_role = esc_or_null($user->role, 'string');
    $u_firstname = esc_or_null(data_fixNameCase($user->firstname), 'string');
    $u_lastname = esc_or_null(data_fixNameCase($user->lastname), 'string');
    $player = esc_or_null($user->player, 'int');

    if (!GetUserId($user->username)) {
        $u_id = db_exec("INSERT INTO :User (Username, UserEmail, Password, Role, UserFirstName, UserLastName, Player, Hash, Salt)
                             VALUES ($u_username_quoted, $u_email, $u_password, $u_role, $u_firstname,
                                $u_lastname, $player, $u_hash, $u_salt)");

        if (db_is_error($u_id))
            return $u_id;

        $user->SetId($u_id);
        $retValue = $user;
    }
    else {
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
    if (!$userid || !$sflid)
        return null;

    $userid = esc_or_null($userid, 'int');
    $sflid = esc_or_null($sflid, 'int');

    return db_exec("UPDATE :User SET SflId = $sflid WHERE id = $userid");
}


function SaveUserClub($userid, $clubid)
{
    if (!$userid || !$clubid)
        return null;

    $userid = esc_or_null($userid, 'int');
    $clubid = esc_or_null($clubid, 'int');

    return db_exec("UPDATE :User SET Club = $clubid WHERE id = $userid");
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


function GetUserEmailVerification($id = null)
{
    if (!$id)
        return null;

    $id = esc_or_null($id, 'int');

    return db_one("SELECT EmailVerified FROM :User WHERE id = $id AND EmailVerified > (NOW() - INTERVAL 1 YEAR)");
}


function SetUserEmailVerification($id = null, $status = false)
{
    if (!$id)
        return null;

    $id = esc_or_null($id, 'int');
    $status = $status ? "NOW()" : "NULL";

    return db_exec("UPDATE :User SET EmailVerified = $status WHERE id = $id");
}
