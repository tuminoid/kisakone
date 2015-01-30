<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Player
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


// Gets a Player object by id or null if the player was not found
function GetPlayerDetails($playerid)
{
   if (empty($playerid))
      return null;

   $retValue = null;
   $id = (int) $playerid;

   $query = format_query("SELECT player_id id, pdga PDGANumber, sex Sex, YEAR(birthdate) YearOfBirth
        FROM :Player
        WHERE player_id = $id");
   $result = execute_query($query);

   if (mysql_num_rows($result) == 1) {
      $row = mysql_fetch_assoc($result);
      $retValue = new Player($row['id'], $row['PDGANumber'], $row['Sex'], $row['YearOfBirth']);
   }
   mysql_free_result($result);

   return $retValue;
}


// Gets a User object associated with Playerid
function GetPlayerUser($playerid = null)
{
   if ($playerid === null)
      return null;

   $playerid = (int) $playerid;
   $query = format_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname,
                            :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM
                         FROM :User
                         INNER JOIN :Player ON :Player.player_id = :User.Player WHERE :Player.player_id = '$playerid'");
   $result = execute_query($query);

   if (mysql_num_rows($result) === 1) {
      while ($row = mysql_fetch_assoc($result)) {
         $temp = new User($row['id'],
                        $row['Username'],
                        $row['Role'],
                        data_GetOne($row['UserFirstname'], $row['pFN']),
                        data_GetOne($row['UserLastname'], $row['pLN']),
                        data_GetOne($row['UserEmail'], $row['pEM']),
                        $playerid);

         return $temp;
      }
   }
   mysql_free_result($result);

   return null;
}


/**
 * Function for setting the user participation on an event
 *
 * Returns true for success, false for successful queue signup or an Error
 */
function SetPlayerParticipation($playerid, $eventid, $classid, $signup_directly = true)
{
   $retValue = $signup_directly;

   $table = ($signup_directly === true) ? "Participation" : "EventQueue";

   // Inputmapping is already checking player's re-entry, so this is merely a cleanup from queue
   // and double checking that player will not be in competition table twice
   CancelSignup($eventid, $playerid, false);

   $query = format_query("INSERT INTO :$table (Player, Event, Classification) VALUES (%d, %d, %d);",
                         (int) $playerid, (int) $eventid, (int) $classid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   return $retValue;
}


/**
 * Function for setting or changing the player data.
 *
 * @param class Player $player - single system users player data
 */

function SetPlayerDetails($player)
{
    $retValue = null;
    if ( is_a( $player, "Player")) {
        $dbError = InitializeDatabaseConnection();
        if ($dbError) {
           return $dbError;
        }

        $query = format_query( "INSERT INTO :Player (pdga, sex, lastname, firstname, birthdate, email) VALUES (
                            %s, '%s', %s, %s, '%s', %s
                            );",
                          esc_or_null($player->pdga),
                          $player->gender == 'M' ? 'male' : 'female',
                          esc_or_null(data_fixNameCase($player->lastname)),
                          esc_or_null(data_fixNameCase($player->firstname)),
                          (int) $player->birthyear . '-1-1',
                          esc_or_null($player->email));
        $result = execute_query($query);

        if (!$result)
            return Error::Query($query);

        if ($result) {
            $p_id = mysql_insert_id();
            $player->SetId($p_id);
            $retValue = $player;
        }
    }
    else
      return Error::internalError("Wrong class as argument");

   return $retValue;
}


