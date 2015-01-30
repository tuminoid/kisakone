<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Event queues
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


/* Return event's queue counts by class */
function GetEventQueueCounts($eventId)
{
   $eventId = (int) $eventId;
   $query = format_query("SELECT count(*) as cnt, Classification
      FROM :EventQueue
      WHERE Event = $eventId
      GROUP BY Classification");
   $result = execute_query($query);

   $ret = array();
   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $ret[$row['Classification']] = $row['cnt'];
   }
   mysql_free_result($result);

   return $ret;
}


// This is more or less copypaste from ^^
// FIXME: Redo to a simpler form sometime
function GetEventQueue($eventId, $sortedBy, $search)
{
   $retValue = array();
   $eventId = (int) $eventId;

   $query = "SELECT :User.id AS UserId, Username, Role, UserFirstName, UserLastName, UserEmail,
               :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM, :Player.player_id AS PlayerId,
               pdga PDGANumber, Sex, YEAR(birthdate) YearOfBirth, :Classification.Name AS ClassName,
               :EventQueue.id AS QueueId,
               UNIX_TIMESTAMP(SignupTimestamp) SignupTimestamp, :Classification.id AS ClassId
                  FROM :User
                  INNER JOIN :Player ON :Player.player_id = :User.Player
                  INNER JOIN :EventQueue ON :EventQueue.Player = :Player.player_id AND :EventQueue.Event = ".$eventId ."
                  INNER JOIN :Classification ON :EventQueue.Classification = :Classification.id
                  WHERE %s
                  ORDER BY SignupTimestamp ASC, :EventQueue.id ASC";

   $query = format_query($query, data_ProduceSearchConditions($search, array('FirstName', 'LastName', 'pdga', 'Username', 'birthdate')));
   $result = execute_query($query);

   require_once 'core/player.php';
   require_once 'core/user.php';

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $pdata = array();

         $firstname = data_GetOne( $row['UserFirstName'], $row['pFN']);
         $lastname = data_GetOne( $row['UserLastName'], $row['pLN']);
         $email = data_GetOne($row['UserEmail'], $row['pEM']);

         $pdata['user'] = new User($row['UserId'], $row['Username'], $row['Role'], $firstname, $lastname, $email, $row['PlayerId']);
         $pdata['player'] = new Player($row['PlayerId'], $row['PDGANumber'], $row['Sex'], $row['YearOfBirth'], $firstname, $lastname, $email);
         $pdata['queueId'] = $row['QueueId'];
         $pdata['signupTimestamp'] = $row['SignupTimestamp'];
         $pdata['className'] = $row['ClassName'];
         $pdata['classId'] = $row['ClassId'];
         $retValue[] = $pdata;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


function GetQueueForClass($event, $class)
{
   $classId = (int) $class;
   $eventId = (int) $event;

   $retValue = array();
   $query = format_query("SELECT :Player.id PlayerId, :User.FirstName, :User.LastName, :Player.PDGANumber,
                    :EventQueue.id ParticipationId
                 FROM :User
                 INNER JOIN :Player ON User.id = :Player.User
                 INNER JOIN :Participation ON :EventQueue.Player = :Player.id
                 WHERE :EventQueue.Classification = $classId
                   AND :EventQueue.Event = $eventId");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $retValue[] = $row;
   }
   mysql_free_result($result);

   return $retValue;
}


// Check if we can raise players from queue after someone left
function CheckQueueForPromotions($eventId)
{
   $queuers = GetEventQueue($eventId, '', '');
   foreach ($queuers as $queuer) {
      $playerId = $queuer['player']->id;
      $classId = $queuer['classId'];

      if (CheckSignupQuota($eventId, $playerId, $classId)) {
         $retVal = PromotePlayerFromQueue($eventId, $playerId);
         if (is_a($retVal, 'Error'))
            error_log("Error promoting player $playerId to event $eventId at class $classId");
      }
   }

   return null;
}


// Raise competitor from queue to the event
function PromotePlayerFromQueue($eventId, $playerId)
{
   // Get data from queue
   $query = format_query("SELECT * FROM :EventQueue WHERE Player = $playerId AND Event = $eventId");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      $row = mysql_fetch_assoc($result);

      // Insert into competition
      $query = format_query("INSERT INTO :Participation (Player, Event, Classification, SignupTimestamp) VALUES (%d, %d, %d, FROM_UNIXTIME(%d));",
                         (int) $row['Player'], (int) $row['Event'], (int) $row['Classification'], time());
      $result = execute_query($query);

      if (!$result)
         return Error::Query($query);

      // Remove data from queue
      $query = format_query("DELETE FROM :EventQueue WHERE Player = $playerId AND Event = $eventId");
      $result = execute_query($query);

      if (!$result)
         return Error::Query($query);

      $user = GetPlayerUser($playerId);
      if ($user !== null) {
         require_once 'core/email.php';
         error_log("Sending email to ".print_r($user, true));
         SendEmail(EMAIL_PROMOTED_FROM_QUEUE, $user->id, GetEventDetails($eventId));
      }
      else
         error_log("Cannot send promotion email: user !== null failed, playerId = ".$playerId);
   }
   mysql_free_result($result);

   return null;
}



function UserQueueing($eventid, $userid)
{
   $query = format_query("SELECT :EventQueue.id FROM :EventQueue
                     INNER JOIN :Player ON :EventQueue.Player = :Player.player_id
                     INNER JOIN :User ON :User.Player = :Player.player_id
                     WHERE :User.id = %d AND :EventQueue.Event = %d",
                     $userid, $eventid);
   $result = execute_query($query);

   return (mysql_num_rows($result) > 0);
}
