<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for User functions
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


// Returns true if the user is a staff member in any tournament
function UserIsManagerAnywhere($userid)
{
   if (empty($userid))
      return null;

   $retValue = false;
   $userid = (int) $userid;

   $query = format_query("SELECT :User.id FROM :User
                         INNER JOIN :EventManagement ON :User.id = :EventManagement.User
                         WHERE :User.id = $userid
                         AND :EventManagement.Role IN ('TD', 'Official')");
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $retValue = mysql_num_rows($result) == 1;
   mysql_free_result($result);

   return $retValue;
}


// Returns a User object for the user whose email is $email
// Returns null if no user was found
function GetUserIdByEmail($email)
{
   if (empty($email))
      return null;

   $retValue = null;
   $email = escape_string($email);

   $query = format_query("SELECT id FROM :User WHERE UserEmail = '$email'");
   $result = execute_query($query);

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
   $retValue = array();

   $query = "SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname, :User.Player,
                    :Player.lastname pLN, :Player.firstname pFN, :Player.email pEM
             FROM :User
             LEFT JOIN :Player ON :User.Player = :Player.player_id";
   $query .= " WHERE %s ";

   if ($sortOrder)
      $query .= " ORDER BY " . data_CreateSortOrder($sortOrder,
         array('name' => array('UserLastname', 'UserFirstname'), 'UserFirstname', 'UserLastname', 'pdga', 'Username' ));
   else
      $query .= " ORDER BY Username";

   $query = format_query($query,
      data_ProduceSearchConditions($searchQuery,
         array('UserFirstname', 'UserLastname', 'Username', ':Player.lastname', ':Player.firstname')));

   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $temp = new User($row['id'], $row['Username'], $row['Role'],
                          data_GetOne( $row['UserFirstname'], $row['pFN']),
                          data_GetOne( $row['UserLastname'], $row['pLN']),
                          data_GetOne( $row['UserEmail'], $row['pEM']), $row['Player']
                          );
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
   $retValue = array();

   if ($with_pdga_number)
      $searchConditions = data_ProduceSearchConditions($query, array('Username', 'pdga', 'UserFirstname', 'UserLastname'));
   else
      $searchConditions = data_ProduceSearchConditions($query, array('Username', 'UserFirstname', 'UserLastname'));

   $query = format_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname, Player
      FROM :User
      INNER JOIN :Player ON :Player.player_id = :User.Player
      WHERE :User.Player IS NOT NULL AND %s", $searchConditions);

   if ($sortOrder)
      $query .= " ORDER BY " . data_CreateSortOrder($sortOrder, array('name' => array('UserLastname', 'UserFirstname'), 'UserFirstname', 'UserLastname', 'pdga', 'Username' ));
   else
     $query .= " ORDER BY Username";

   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $temp = new User($row['id'], $row['Username'], $row['Role'], $row['UserFirstname'], $row['UserLastname'], $row['UserEmail'], $row['Player']);
         $retValue[] = $temp;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


// Gets a User object by the PDGA number of the associated Player
// Returns null if no user was found
function GetUsersByPdga($pdga)
{
   $pdga = (int) $pdga;
   $retValue = array();

   $query = format_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname,
                           :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM
                         FROM :User
                         INNER JOIN :Player ON :Player.player_id = :User.Player WHERE :Player.pdga = '$pdga'");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $temp = new User($row['id'],
                        $row['Username'],
                        $row['Role'],
                        data_GetOne($row['UserFirstname'], $row['pFN']),
                        data_GetOne($row['UserLastname'], $row['pLN']),
                        data_GetOne($row['UserEmail'], $row['pEM']));
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

   $retValue = null;
   $id = (int) $userid;

   $query = format_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname,
                                    :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM,
                                    :User.Player
                                    FROM :User
                                    LEFT JOIN :Player on :Player.player_id = :User.Player
                                    WHERE id = $id");
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   if (mysql_num_rows($result) == 1) {
      $row = mysql_fetch_assoc($result);
      $retValue = new User($row['id'], $row['Username'], $row['Role'], data_GetOne($row['UserFirstname'], $row['pFN']), data_GetOne($row['UserLastname'], $row['pLN']), data_GetOne($row['UserEmail'], $row['pEM']), $row['Player']);
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

   $retValue = null;
   $uname = escape_string($username);

   $query = format_query("SELECT id FROM :User WHERE Username = '$uname'");
   $result = execute_query($query);

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

   require_once 'core/player.php';

   $retValue = null;
   $id = (int) $userid;
   $query = format_query("SELECT :Player.player_id id, pdga PDGANumber, sex Sex, YEAR(birthdate) YearOfBirth, firstname, lastname, email
                                      FROM :Player INNER JOIN :User ON :User.Player = :Player.player_id
                                      WHERE :User.id = $id");
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   if (mysql_num_rows($result) == 1) {
      $row = mysql_fetch_assoc($result);
      $retValue = new Player($row['id'],
                           $row['PDGANumber'],
                           $row['Sex'],
                           $row['YearOfBirth'],
                           $row['firstname'],
                           $row['lastname'],
                           $row['email']);
   }
   mysql_free_result($result);

   return $retValue;
}


// Edits users user and player information
function EditUserInfo($userid, $email, $firstname, $lastname, $gender, $pdga, $dobyear)
{

   $query = format_query("UPDATE :User SET UserEmail = %s, UserFirstName = %s, UserLastName = %s WHERE id = %d",
                                   esc_or_null($email), esc_or_null(data_fixNameCase($firstname)), esc_or_null(data_fixNameCase($lastname)), (int) $userid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($user_query);

   $u = GetUserDetails($userid);
   $player = $u->GetPlayer();
   if ($player) {
      $playerid = $player->id;

      $query = format_query("UPDATE :Player SET sex = %s, pdga = %s,
                              birthdate = '%s', firstname = %s, lastname = %s,
                              email = %s
                              WHERE player_id = %d",
                                    strtoupper($gender) == 'M' ? "'male'" : "'female'", esc_or_null($pdga, 'int'), (int) $dobyear . '-1-1',
                                    esc_or_null(data_fixNameCase($firstname)), esc_or_null(data_fixNameCase($lastname)), esc_or_null($email),
                                    (int) $playerid);
      $result = execute_query($query);

      if (!$result)
         return Error::Query($plr_query);
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

   if (is_a($user,"User")) {
      $u_username_quoted = $user->username ? escape_string($user->username) : 'NULL';
      $u_email     = escape_string($user->email);
      $u_password  = $user->password;
      $u_hash      = $user->GetHashType();
      $u_salt      = $user->salt ? "'$user->salt'" : 'NULL';
      $u_role      = escape_string($user->role);
      $u_firstname = escape_string(data_fixNameCase($user->firstname));
      $u_lastname  = escape_string(data_fixNameCase($user->lastname));

      // Check that username is not already in use
      if (!GetUserId($user->username)) {
         // Username is unique, proceed to insert into table
         $query = format_query( "INSERT INTO :User (
                                 Username, UserEmail, Password, Role, UserFirstName, UserLastName, Player, Hash, Salt)
                                 VALUES ('%s', '%s', '%s', '%s', '%s', '%s', %s, '%s', %s);",
                           $u_username_quoted, $u_email, $u_password, $u_role, $u_firstname, $u_lastname,
                           esc_or_null($user->player, 'int'), $u_hash, $u_salt);
         $result = execute_query($query);

         if (!$result)
            return Error::Query($query);

         // Get id for the new user
         $u_id = mysql_insert_id();
         $user->SetId( $u_id);
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
         $err->data = "username:" . $u_username .
                      "; role:" . $u_role .
                      "; firstname:" . $u_firstname .
                      "; lastname:" . $u_lastname;
         $retValue = $err;
      }
   }
   else
      return Error::internalError("Wrong class as argument");

   return $retValue;
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


