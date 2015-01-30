<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module. Access the database server directly.
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


// Gets an array of Event objects where the conditions match
function data_GetEvents($conditions, $sort_mode = null)
{
   $retValue = array();

   global $event_sort_mode;
   if ($sort_mode !== null) {
      $sort = "`$sort_mode`";
   }
   elseif (!$event_sort_mode) {
     $sort = "`Date`";
   }
   else {
     $sort = data_CreateSortOrder($event_sort_mode, array('Name', 'VenueName' => 'Venue', 'Date', 'LevelName'));
   }

   global $user;
   if ($user && $user->id) {
      $uid = $user->id;

      $player = $user->GetPlayer();
      if (is_a($player, 'Error'))
         return $player;
      $playerid = $player ? $player->id : -1;

      $query = format_query("SELECT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament,
            Level, :Event.Name, UNIX_TIMESTAMP(Date) Date, Duration,
            UNIX_TIMESTAMP(ActivationDate) ActivationDate, UNIX_TIMESTAMP(SignupStart) SignupStart,
            UNIX_TIMESTAMP(SignupEnd) SignupEnd, ResultsLocked,
            :Level.Name LevelName, :EventManagement.Role AS Management, :Participation.Approved,
            :Participation.EventFeePaid, :Participation.Standing
        FROM :Event
        LEFT JOIN :EventManagement ON (:Event.id = :EventManagement.Event AND :EventManagement.User = $uid)
        LEFT JOIN :Participation ON (:Participation.Event = :Event.id AND :Participation.Player = $playerid)
        LEFT JOIN :Level ON :Event.Level = :Level.id
        INNER Join :Venue ON :Venue.id = :Event.Venue
        WHERE $conditions
        ORDER BY %s", $sort);
   }
   else {
      $query = format_query("SELECT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament,
            Level, :Event.Name, UNIX_TIMESTAMP(Date) Date, Duration,
            UNIX_TIMESTAMP(ActivationDate) ActivationDate, UNIX_TIMESTAMP(SignupStart) SignupStart,
            UNIX_TIMESTAMP(SignupEnd) SignupEnd, ResultsLocked,
            :Level.Name LevelName
        FROM :Event
        INNER Join :Venue ON :Venue.id = :Event.Venue
        LEFT JOIN :Level ON :Event.Level = :Level.id
        WHERE $conditions
        ORDER BY %s", $sort);
   }
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $temp = new Event($row);
         $retValue[] = $temp;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


// Gets an Event object by ID or null if the event was not found
function GetEventDetails($eventid)
{
   if (empty($eventid))
      return null;

   $retValue = null;
   $id = (int) $eventid;

   global $user;
   if ($user && $user->id) {
      $uid = $user->id;

      $player = $user->GetPlayer();
      $pid = $player ? $player->id : -1;

      $query = format_query("SELECT DISTINCT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament, AdBanner, :Event.Name, ContactInfo,
                                      UNIX_TIMESTAMP(Date) Date, Duration, PlayerLimit, UNIX_TIMESTAMP(ActivationDate) ActivationDate, UNIX_TIMESTAMP(SignupStart) SignupStart,
                                      UNIX_TIMESTAMP(SignupEnd) SignupEnd, ResultsLocked,
                                      :EventManagement.Role AS Management, :Participation.Approved, :Participation.EventFeePaid, :Participation.Standing, :Level.id LevelId,
                                      :Level.Name Level, :Tournament.id TournamentId, :Tournament.Name Tournament, :Participation.SignupTimestamp
                                      FROM :Event
                                      LEFT JOIN :EventManagement ON (:Event.id = :EventManagement.Event AND :EventManagement.User = $uid)
                                      LEFT JOIN :Participation ON (:Participation.Event = :Event.id AND :Participation.Player = $pid)
                                      LEFT Join :Venue ON :Venue.id = :Event.Venue
                                      LEFT JOIN :Level ON :Level.id = :Event.Level
                                      LEFT JOIN :Tournament ON :Tournament.id = :Event.Tournament
                                      WHERE :Event.id = $id ");
   }
   else {
      $query = format_query("SELECT DISTINCT :Event.id id, :Venue.Name AS Venue, Tournament, AdBanner, :Event.Name, UNIX_TIMESTAMP(Date) Date, Duration, PlayerLimit, UNIX_TIMESTAMP(ActivationDate) ActivationDate, ContactInfo,
                            UNIX_TIMESTAMP(SignupStart) SignupStart, UNIX_TIMESTAMP(SignupEnd) SignupEnd, ResultsLocked, :Level.id LevelId, :Level.Name Level,
                            :Tournament.id TournamentId, :Tournament.Name Tournament
                                      FROM :Event
                                      LEFT JOIN :Level ON :Level.id = :Event.Level
                                      LEFT JOIN :Tournament ON :Tournament.id = :Event.Tournament
                                      LEFT Join :Venue ON :Venue.id = :Event.Venue
                                      WHERE :Event.id = $id ");
   }
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   if (mysql_num_rows($result) == 1) {
      $row = mysql_fetch_assoc($result);
      $retValue = new Event($row);
   }
   mysql_free_result($result);

   return $retValue;
}


/**
 * Function for creating a new event
 *
 * Returns the new event id for success or
 * an Error in case there was an error in creating a new event.
 */
function CreateEvent($name, $venue, $duration, $playerlimit, $contact, $tournament, $level, $start,
                      $signup_start, $signup_end, $classes, $td, $officials, $requireFees)
{
    $retValue = null;

    $query = format_query( "INSERT INTO :Event (Venue, Tournament, Level, Name, Date, Duration, PlayerLimit, SignupStart, SignupEnd, ContactInfo, FeesRequired) VALUES
                     (%d, %d, %d, '%s', FROM_UNIXTIME(%d), %d, %d, FROM_UNIXTIME(%s), FROM_UNIXTIME(%s), '%s', %d)",
                      esc_or_null($venue, 'int'), esc_or_null($tournament, 'int'), esc_or_null($level, 'int'), mysql_real_escape_string($name),
                      (int) $start, (int) $duration, (int) $playerlimit,
                      esc_or_null($signup_start, 'int'), esc_or_null($signup_end,'int'), mysql_escape_string($contact),
                      $requireFees );
    $result = execute_query($query);

    if ($result) {
        $eventid = mysql_insert_id();
        $retValue = $eventid;

        $retValue = SetClasses($eventid, $classes);
        if (!is_a($retValue, 'Error')) {
            $retValue = SetTD($eventid, $td);
            if (!is_a($retValue, 'Error'))
                $retValue = SetOfficials($eventid, $officials);
        }
    }
    else
        return Error::Query($query, 'CreateEvent');

    if (!is_a($retValue, 'Error'))
      $retValue = $eventid;

    return $retValue;
}


// Gets Events by date
function GetEventsByDate($start, $end)
{
   $start = (int) $start;
   $end = (int) $end;
   return  data_GetEvents("Date BETWEEN FROM_UNIXTIME($start) AND FROM_UNIXTIME($end)");
}


// Get all Classifications in an Event
function GetEventClasses($event)
{
   require_once 'core/classification.php';

   $retValue = array();
   $event = (int) $event;
   $query = format_query("SELECT :Classification.id, Name, MinimumAge, MaximumAge, GenderRequirement, Available
                  FROM :Classification, :ClassInEvent
                  WHERE :ClassInEvent.Classification = :Classification.id AND
                        :ClassInEvent.Event = $event
                        ORDER BY Name");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $retValue[] = new Classification($row);
   }
   mysql_free_result($result);

   return $retValue;
}


// Get rounds for an event by event id
function GetEventRounds($event)
{
   require_once 'core/round.php';

   $retValue = array();
   $event = (int) $event;
   $query = format_query("SELECT id, Event, Course, StartType,UNIX_TIMESTAMP(StartTime) StartTime,
                         `Interval`, ValidResults, GroupsFinished FROM :Round WHERE Event = $event ORDER BY StartTime");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      $index = 1;
      while ($row = mysql_fetch_assoc($result)) {
         $newRound =  new Round($row['id'], $row['Event'], $row['StartType'], $row['StartTime'], $row['Interval'], $row['ValidResults'], 0, $row['Course'], $row['GroupsFinished']);
         $newRound->roundnumber = $index++;
         $retValue[] = $newRound;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


// Get event officials for an event
function GetEventOfficials($event)
{
   require_once 'core/event_official.php';

   $retValue = array();
   $event = (int) $event;
   $query = format_query("SELECT :User.id as UserId, Username, UserEmail, :EventManagement.Role, UserFirstname, UserLastname, Event ,
                                    :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM, Player
                                    FROM :EventManagement, :User
                                    LEFT JOIN :Player ON :User.Player = :Player.player_id
                                    WHERE :EventManagement.User = :User.id AND :EventManagement.Event = $event
                                    ORDER BY :EventManagement.Role DESC, Username ASC");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $tempuser = new User($row['UserId'],
                              $row['Username'],
                              $row['Role'],
                              data_GetOne( $row['UserFirstname'], $row['pFN']),
                              data_GetOne($row['UserLastname'], $row['pLN']),
                              data_GetOne($row['UserEmail'], $row['pEM']),
                              $row['Player']);

         $retValue[] = new EventOfficial($row['UserId'], $row['Event'], $tempuser, $row['Role']);
      }
   }
   mysql_free_result($result);

   return $retValue;
}


// Edit event information
function EditEvent($eventid, $name, $venuename, $duration, $playerlimit, $contact, $tournament, $level, $start, $signup_start, $signup_end, $state, $requireFees)
 {
   $venueid = GetVenueId($venuename);

   $activation = ($state == 'active' || $state =='done') ? time() : 'NULL';
   $locking = ($state =='done') ? time() : 'NULL';
   $query = format_query("UPDATE `:Event` SET `Venue` = %d, `Tournament` = %s, Level = %d, `Name` = '%s', `Date` = FROM_UNIXTIME(%d),
                    `Duration` = %d, `PlayerLimit` = %d, `SignupStart` = FROM_UNIXTIME(%s), `SignupEnd` = FROM_UNIXTIME(%s),
                    ActivationDate = FROM_UNIXTIME( %s), ResultsLocked = FROM_UNIXTIME(%s), ContactInfo = '%s', FeesRequired = %d
                    WHERE id = %d",
                            $venueid,
                            esc_or_null($tournament, 'int'), $level, mysql_real_escape_string($name), (int) $start,
                            (int) $duration, (int) $playerlimit,
                            esc_or_null($signup_start,'int'), esc_or_null($signup_end,'int'), $activation,
                            $locking,
                            mysql_real_escape_string($contact),  $requireFees , (int) $eventid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   mysql_free_result($result);
}


/**
 * Function for setting the tournament director for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the TD.
 */
function SetTD($eventid, $td)
{
   $retValue = Null;

   if (isset($eventid) and isset($td)) {
      $eventid  = (int) $eventid;
      $query = format_query("DELETE FROM :EventManagement WHERE Event = $eventid AND Role = 'td'");
      execute_query($query);

      $query = format_query( "INSERT INTO :EventManagement (User, Event, Role) VALUES (%d, %d, '%s');",
                          (int) $td, (int) $eventid, 'td');
      $result = execute_query($query);

      if (!$result)
         return Error::Query($query);
   }
   else
      return Error::internalError("Event id or td argument is not set.");

   return $retValue;
}


/**
 * Function for setting the officials for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the official.
 */
function SetOfficials($eventid, $officials)
{
   $eventid = (int) $eventid;
   $retValue = null;

   if (isset($eventid)) {
      $query = format_query("DELETE FROM :EventManagement WHERE Event = %d AND Role = 'official'", $eventid);
      execute_query($query);

      foreach ($officials as $official) {
         $query = format_query("INSERT INTO :EventManagement (User, Event, Role) VALUES (%d, %d, '%s');",
                           (int) $official, (int) $eventid, 'official');
         $result = execute_query($query);

         if (!$result)
            return Error::Query($query);
      }
   }
   else
      return Error::internalError("Event id argument is not set.");

   return $retValue;
}


// Cancels a players signup for an event
function CancelSignup($eventId, $playerId, $check_promotion = true)
{
    // Delete from event and queue
    $query = format_query("DELETE FROM :Participation WHERE Player = $playerId AND Event = $eventId");
    execute_query($query);

    $query = format_query("DELETE FROM :EventQueue WHERE Player = $playerId AND Event = $eventId");
    execute_query($query);

    if ($check_promotion === false)
      return null;

    // Check if we can lift someone into competition
    return CheckQueueForPromotions($eventId);
}


function GetEventsByYear($year)
{
   $year = (int) $year;
   $start = mktime(0,0,0,1,1,$year);
   $end = mktime(0,0,0,12,31,$year);

   return GetEventsByDate($start, $end) ;
}


function GetEventYears()
{
   $retValue = array();
   $query = format_query("SELECT DISTINCT(YEAR(Date)) AS year FROM :Event ORDER BY YEAR(Date) ASC");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $retValue[] = $row['year'];
   }
   mysql_free_result($result);

   return $retValue;
}


/* Return event's participant counts by class */
function GetEventParticipantCounts($eventId)
{
   $eventId = (int) $eventId;
   $query = format_query("SELECT count(*) as cnt, Classification
      FROM :Participation
      WHERE Event = $eventId
      GROUP BY Classification");
   $result = execute_query($query);

   $ret = array();
   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $ret[$row['Classification']] = $row['cnt'];
   }

   return $ret;
}


function GetEventParticipants($eventId, $sortedBy, $search)
{
   $retValue = array();
   $eventId = (int) $eventId;
   $sortOrder = data_CreateSortOrder($sortedBy, array('name' => array('LastName', 'FirstName'), 'class' => 'ClassName', 'LastName' => true, 'FirstName' => true, 'birthyear' => 'YEAR(birthdate)', 'pdga', 'gender' => 'sex', 'Username'));

   if (is_a($sortOrder, 'Error'))
      return $sortOrder;
   if ($sortOrder == 1)
      $sortOrder = " LastName, FirstName";

   $query = "SELECT :User.id AS UserId, Username, Role, UserFirstName, UserLastName, UserEmail, :Player.firstname pFN, :Player.lastname pLN,
                                :Player.email pEM,
                               :Player.player_id AS PlayerId, pdga PDGANumber, Sex, YEAR(birthdate) YearOfBirth, :Classification.Name AS ClassName,
                               :Participation.id AS ParticipationID, UNIX_TIMESTAMP(EventFeePaid) EventFeePaid,
                               UNIX_TIMESTAMP(SignupTimestamp) SignupTimestamp, :Classification.id AS ClassId
                  FROM :User
                  INNER JOIN :Player ON :Player.player_id = :User.Player
                  INNER JOIN :Participation ON :Participation.Player = :Player.player_id AND :Participation.Event = ".$eventId ."
                  INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                  WHERE %s
                  ORDER BY $sortOrder";

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

         $pdata['eventFeePaid'] = $row['EventFeePaid'];
         $pdata['participationId'] = $row['ParticipationID'];
         $pdata['signupTimestamp'] = $row['SignupTimestamp'];
         $pdata['className'] = $row['ClassName'];
         $pdata['classId'] = $row['ClassId'];
         $retValue[] = $pdata;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


function GetParticipantsForRound($previousRoundId)
{
   $retValue = array();
   $rrid = (int) $previousRoundId;
   $query = "SELECT :User.id AS UserId, Username, :Player.firstname FirstName, :Player.lastname LastName, Role, :Player.email Email, Sex, YEAR(birthdate) YearOfBirth,
                               :Player.player_id AS PlayerId, pdga PDGANumber, Classification,
                               :Participation.id AS ParticipationID,
                               :RoundResult.Result, :Participation.DidNotFinish
                  FROM `:Round`
                  INNER JOIN :RoundResult ON :RoundResult.`Round` = `:Round`.id
                  INNER JOIN :Participation ON (:Participation.Player = :RoundResult.Player AND :Participation.Event = `:Round`.Event)
                  INNER JOIN :Player ON :RoundResult.Player = :Player.player_id
                  INNER JOIN :User ON :Player.player_id = :User.Player
                  WHERE :RoundResult.Round = $rrid
                  ORDER BY :Participation.Standing";

   $query = format_query($query);
   $result = execute_query($query);

   require_once 'core/player.php';
   require_once 'core/user.php';

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $pdata = array();

         $pdata['user'] = new User($row['UserId'], $row['Username'], $row['Role'], $row['FirstName'], $row['LastName'], $row['Email'], $row['PlayerId']);
         $pdata['player'] = new Player($row['PlayerId'], $row['PDGANumber'], $row['Sex'], $row['YearOfBirth'], $row['FirstName'], $row['LastName'], $row['Email']);
         $pdata['participationId'] = $row['ParticipationID'];
         $pdata['classification'] = $row['Classification'];
         $pdata['result'] = $row['Result'];
         $pdata['didNotFinish']=  $row['DidNotFinish'];

         $retValue[] = $pdata;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


function GetEventHoles($eventId)
{
   require_once 'core/hole.php';

   $retValue = array();
   $eventId = (int) $eventId;
   $query = format_query("SELECT :Hole.id, :Hole.Course, HoleNumber, HoleText, Par, Length, :Round.id AS Round FROM :Hole
                         INNER JOIN :Course ON (:Course.id = :Hole.Course)
                         INNER JOIN :Round ON (:Round.Course = :Course.id)
                         INNER JOIN :Event ON :Round.Event = :Event.id
                         WHERE :Event.id = $eventId
                         ORDER BY :Round.StartTime, HoleNumber");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      $index = 1;
      while ($row = mysql_fetch_assoc($result)) {
         $hole =  new Hole($row);
         $retValue[] = $hole;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


function GetEventResults($eventId)
{
   require_once 'core/hole.php';

   $retValue = array();
   $eventId = (int) $eventId;

   $query = "SELECT :Participation.*, player_id as PlayerId, :Player.firstname FirstName, :Player.lastname LastName, :Player.pdga PDGANumber,
                 :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                 :StartingOrder.GroupNumber, (:HoleResult.Result - :Hole.Par) AS Plusminus,
                 :HoleResult.Result AS HoleResult, :Hole.id AS HoleId, :Hole.HoleNumber,
                 :Classification.Name ClassName,
                 TournamentPoints, :Round.id RoundId,
                 :Participation.Standing
                         FROM :Round
                         INNER JOIN :Event ON :Round.Event = :Event.id
                         INNER JOIN :Section ON :Section.Round = :Round.id
                         INNER JOIN :StartingOrder ON (:StartingOrder.Section = :Section.id )
                         LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                         LEFT JOIN :HoleResult ON (:HoleResult.RoundResult = :RoundResult.id AND :HoleResult.Player = :StartingOrder.Player)
                         LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
                         LEFT JOIN :Participation ON (:Participation.Event = $eventId AND :Participation.Player = :Player.player_id)
                         LEFT JOIN :Classification ON :Participation.Classification = :Classification.id
                         LEFT JOIN :User ON :Player.player_id = :User.Player
                         LEFT JOIN :Hole ON :HoleResult.Hole = :Hole.id
                         WHERE :Event.id = $eventId AND :Section.Present
                         ORDER BY :Participation.Standing, player_id, :Round.StartTime, :Hole.HoleNumber";

   $query = format_query($query);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $penalties = array();
   if (mysql_num_rows($result) > 0) {
      $index = 1;
      $lastrow = null;

      while ($row = mysql_fetch_assoc($result)) {
         if (!$lastrow || @$lastrow['PlayerId'] != $row['PlayerId']) {
            if ($lastrow)
               $retValue[] = $lastrow;
            $lastrow = $row;
            $lastrow['Results'] = array();
            $lastrow['TotalPlusMinus'] = $lastrow['Penalty'];
            $penalties[$row['RoundId']] = true;
         }

         if (!@$penalties[$row['RoundId']]) {
            $penalties[$row['RoundId']] = true;
            $lastrow['Penalty'] += $row['Penalty'];
         }

         if ($row['HoleResult']) {
            $lastrow['Results'][$row['RoundId'] . '_' . $row['HoleNumber']] = array(
               'Hole' => $row['HoleNumber'],
               'HoleId' => $row['HoleId'],
               'Result' => $row['HoleResult']);
            $lastrow['TotalPlusMinus'] += $row['Plusminus'];
         }
      }

      if ($lastrow)
         $retValue[] = $lastrow;
   }
   mysql_free_result($result);

   return $retValue;
}


function GetEventResultsWithoutHoles($eventId)
{
   require_once 'core/hole.php';

   $retValue = array();
   $eventId = (int) $eventId;

   $query = "SELECT :Participation.*, player_id as PlayerId, :Player.firstname FirstName, :Player.lastname LastName, :Player.pdga PDGANumber,
                 :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                 :StartingOrder.GroupNumber, CumulativePlusminus, Completed  ,
                 :Classification.Name ClassName, PlusMinus, :StartingOrder.id StartId,
                 TournamentPoints, :Round.id RoundId,
                 :Participation.Standing
                         FROM :Round
                         INNER JOIN :Event ON :Round.Event = :Event.id
                         INNER JOIN :Section ON :Section.Round = :Round.id
                         INNER JOIN :StartingOrder ON (:StartingOrder.Section = :Section.id )
                         LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                         LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
                         LEFT JOIN :Participation ON (:Participation.Event = $eventId AND :Participation.Player = :Player.player_id)
                         LEFT JOIN :Classification ON :Participation.Classification = :Classification.id
                         LEFT JOIN :User ON :Player.player_id = :User.Player
                         WHERE :Event.id = $eventId AND :Section.Present
                         ORDER BY :Participation.Standing, player_id, :Round.StartTime";
   $query = format_query($query);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $penalties = array();
   if (mysql_num_rows($result) > 0) {
      $index = 1;
      $lastrow = null;

      while ($row = mysql_fetch_assoc($result)) {
         if (!$lastrow || @$lastrow['PlayerId'] != $row['PlayerId']) {
            if ($lastrow)
               $retValue[] = $lastrow;

            $lastrow = $row;
            $lastrow['Results'] = array();
            $lastrow['TotalCompleted'] = 0;
            $lastrow['TotalPlusminus'] = 0;
         }

         $lastrow['TotalCompleted'] += $row['Completed'];
         $lastrow['TotalPlusminus'] += $row['PlusMinus'];
         $lastrow['Results'][$row['RoundId']] = $row;
      }

      if ($lastrow)
         $retValue[] = $lastrow;
   }
   mysql_free_result($result);

   usort($retValue, 'data_sort_leaderboard');

   return $retValue;
}


function data_ProduceSearchConditions($queryString, $fields)
{
   if (trim($queryString) == "")
      return "1";

   $words = explode(' ', $queryString);
   $words = array_filter($words, 'data_RemoveEmptyStrings');
   $words = array_map('mysql_real_escape_string', $words);
   $wordSpecificBits = array();

   if (!count($words))
      return "1";

   foreach ($words as $word) {
      $fieldSpecificBits = array();
      foreach ($fields as $field) {
         $field = str_replace('.', '`.`', $field);
         $fieldSpecificBits[] = "(`$field` LIKE '%$word%')";
      }
      $wordSpecificBits[] = '('. implode(' OR ', $fieldSpecificBits) . ')';
   }

   return '(' . implode(' AND ', $wordSpecificBits) . ')';
}


function GetAllRoundResults($eventid)
{
   $query = format_query("SELECT :RoundResult.id, `Round`, Result, Penalty, SuddenDeath, Completed, Player, PlusMinus, DidNotFinish
                     FROM :RoundResult
                    INNER JOIN `:Round` ON `:Round`.id = :RoundResult.`Round`
                    WHERE `:Round`.Event = %d", $eventid);
   $result = execute_query($query);

   $out = array();
   if ($result) {
      while (($row = mysql_fetch_assoc($result)) !== false)
         $out[] = $row;
   }
   mysql_free_result($result);

   return $out;
}


function GetAllParticipations($eventid)
{
   $query = format_query("SELECT Classification, :Classification.Name,
                    :Participation.Player, :Participation.id,
                    :Participation.Standing, :Participation.DidNotFinish, :Participation.TournamentPoints,
                    :Participation.OverallResult
                    FROM :Participation
                    INNER JOIN :Classification ON :Classification.id = :Participation.Classification
                    WHERE Event = %d AND EventFeePaid IS NOT NULL", $eventid);
   $result = execute_query($query);

   $out = array();
   if ($result) {
      while (($row = mysql_fetch_assoc($result)) !== false)
         $out[] = $row;
   }
   mysql_free_result($result);

   return $out;
}


function SaveParticipationResults($entry)
{
   $query = format_query("UPDATE :Participation
                        SET OverallResult = %d,
                        Standing = %d,
                        DidNotFinish = %d,
                        TournamentPoints = %d
                     WHERE id = %d",
                     $entry['OverallResult'],
                     $entry['Standing'],
                     $entry['DidNotFinish'],
                     $entry['TournamentPoints'],
                     $entry['id']
                     );
   execute_query($query);
}


function data_CreateSortOrder($desiredOrder, $fields)
{
   if (trim($desiredOrder) == "")
      return '1';

   $bits = explode(',', $desiredOrder);
   $out = array();

   foreach ($bits as $index => $bit) {
      $ascending = true;
      if ($bit != '' && $bit[0] == '-') {
         $ascending = false;
         $bit = substr($bit, 1);
      }

      $field = null;
      $field = @$fields[$bit];

      if (!$field) {
        if (data_string_in_array($bit, $fields))
           $field = $bit;
        else {
            echo $bit;
            return Error::notImplemented();
        }
      }

      if ($field === true)
         $field = $bit;

      if (is_array($field)) {
        if (!$ascending)
          foreach ($field as $k => $v)
            $field[$k] = "-" . $v;
         $bits[$index] = implode(',' , $field);
         $newbits = implode(',', $bits);

         return data_CreateSortOrder($newbits, $fields);
      }

      if ($field[0] == '-')
         $ascending = !$ascending;

      if (strpos($field, "(") !== false)
        $out[] = $field . ' ' . ($ascending ? '' : ' DESC');
      else
        $out[] = '`' . escape_string($field) . '`' . ($ascending ? '' : ' DESC') ;
   }

   return implode(', ', $out);
}


function UserParticipating($eventid, $userid)
{
   $query = format_query("SELECT :Participation.id FROM :Participation
                     INNER JOIN :Player ON :Participation.Player = :Player.player_id
                     INNER JOIN :User ON :User.Player = :Player.player_id
                     WHERE :User.id = %d AND :Participation.Event = %d",
                     $userid, $eventid);
   $result = execute_query($query);

   return (mysql_num_rows($result) > 0);
}


function GetAllToRemind($eventid)
{
   $query = format_query("SELECT :User.id FROM :User
      INNER JOIN :Player ON :User.Player = :Player.player_id
      INNER JOIN :Participation ON :Player.player_id = :Participation.Player
      WHERE :Participation.Event = %d AND :Participation.EventFeePaid IS NULL", $eventid);
   $result = execute_query($query);

   $out = array();
   if ($result) {
      while (($row = mysql_fetch_assoc($result)) !== false)
         $out[] = $row['id'];
   }
   mysql_free_result($result);

   return $out;
}


function data_FinalizeResultSort($roundid, $data)
{
   $needMoreInfoOn = array();

   foreach ($data as $results) {
      $lastRes = -1;
      $lastPlayer = -1;
      $added = false;

      foreach ($results as $player) {
         if ($player['CumulativeTotal'] == $lastRes) {
            if (!$added)
               $needMoreInfoOn[] = $lastPlayer;
            $added = true;
            $needMoreInfoOn[] = $player['PlayerId'];
         }
         else {
            $lastRes = $player['CumulativeTotal'];
            $lastPlayer = $player['PlayerId'];
            $added = false;
         }
      }
   }

   global $data_extraSortInfo;
   $data_extraSortInfo = data_GetExtraSortInfo($roundid, $needMoreInfoOn);

   $out = array();
   foreach ($data as $cn => $results) {
      usort($results, 'data_Result_Sort');
      $out[$cn] = $results;
   }

   return $out;
}


function data_GetExtraSortInfo($roundid, $playerList)
{
   if (!count($playerList))
      return array();

   $ids = array_filter($playerList, 'is_numeric');
   $ids = implode(',', $ids);

   $query = format_query(
     "SELECT `:Round`.id RoundId, :StartingOrder.id StartId, :RoundResult.Result, :StartingOrder.Player
         FROM `:Round` LinkRound INNER JOIN `:Round` ON `:Round`.Event = LinkRound.Event
         INNER JOIN :Section ON :Section.`Round` = `:Round`.id
         INNER JOIN :StartingOrder ON :StartingOrder.Section = :Section.id
         INNER JOIN :RoundResult ON (:RoundResult.`Round` = `:Round`.id AND :RoundResult.Player = :StartingOrder.Player)
         WHERE :StartingOrder.Player IN (%s) AND `:Round`.id <= %d AND LinkRound.id = %d
         ORDER BY :Round.StartTime, :StartingOrder.Player", $ids, $roundid, $roundid);
   $result = execute_query($query);

   $out = array();
   while (($row = mysql_fetch_assoc($result)) !== false) {
      if (!isset($out[$row['RoundId']]))
         $out[$row['RoundId']] = array();
      $out[$row['RoundId']]  [$row['Player']] = $row;
   }
   mysql_free_result($result);

   return array_reverse($out);
}


function GetRegisteringEvents()
{
   $now = time();
   return data_GetEvents("SignupStart < FROM_UNIXTIME($now) AND SignupEnd > FROM_UNIXTIME($now)", "SignupEnd");
}


function GetRegisteringSoonEvents()
{
   $now = time();
   $twoweeks = time() + 21*24*60*60;

   return data_GetEvents("SignupStart > FROM_UNIXTIME($now) AND SignupStart < FROM_UNIXTIME($twoweeks)", "SignupStart");
}


function GetUpcomingEvents($onlySome)
{
   $data = data_GetEvents("Date > FROM_UNIXTIME(" . time() . ')');
   if ($onlySome)
      $data = array_slice($data, 0, 10);

   return $data;
}


function GetPastEvents($onlySome, $onlyYear = null)
{
   $thisYear = "";
   if ($onlyYear != null)
      $thisYear = "AND YEAR(Date) = $onlyYear";

   $data = data_GetEvents("Date < FROM_UNIXTIME(" . time() . ") $thisYear AND ResultsLocked IS NOT NULL");
   $data = array_reverse($data);

   if ($onlySome)
      $data = array_slice($data, 0, 5);

   return $data;
}
function DeleteEventPermanently($event)
{
   $id = $event->id;

   $queries = array();
   $queries[] = format_query("DELETE FROM :AdBanner WHERE Event = %d", $id);
   $queries[] = format_query("DELETE FROM :EventQueue WHERE Event = %d", $id);
   $queries[] = format_query("DELETE FROM :ClassInEvent WHERE Event = %d", $id);
   $queries[] = format_query("DELETE FROM :EventManagement WHERE Event = %d", $id);

   $rounds = $event->GetRounds();
   foreach ($rounds as $round) {
      $rid = $round->id;
      $sections = GetSections($rid);
      foreach ($sections as $section) {
         $sid = $section->id;

         $queries[] = format_query("DELETE FROM :SectionMembership WHERE Section = %d", $sid);
         $queries[] = format_query("DELETE FROM :StartingOrder WHERE Section = %d", $sid);
      }
      $queries[] = format_query("DELETE FROM :Section WHERE Round = %d", $rid);

      $query = format_query("SELECT id FROM :RoundResult WHERE Round = %d", $rid);
      $result = execute_query($query);

      while (($row = mysql_fetch_assoc($result)) !== false)
         $queries[] = format_query("DELETE FROM :HoleResult WHERE RoundResult = %d", $row['id']);
      mysql_free_result($result);

      $queries[] = format_query("DELETE FROM :RoundResult WHERE Round = %d", $rid);
   }

   $queries[] = format_query("DELETE FROM :Round WHERE Event = %d", $id);
   $queries[] = format_query("DELETE FROM :TextContent WHERE Event = %d", $id);
   $queries[] = format_query("DELETE FROM :Participation WHERE Event = %d", $id);
   $queries[] = format_query("DELETE FROM :Event WHERE id = %d", $id);

   foreach ($queries as $query)
      execute_query($query);
}

