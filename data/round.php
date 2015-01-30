<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Round
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


// Get a Round object by id
function GetRoundDetails($roundid)
{
   require_once 'core/round.php';

   $retValue = null;
   $id = (int) $roundid;
   $query = format_query("SELECT
      id, Event, Course, StartType,UNIX_TIMESTAMP(StartTime) StartTime, `Interval`, ValidResults, GroupsFinished
      FROM `:Round` WHERE id = $id ORDER BY StartTime");
   $result = execute_query($query);

   if (mysql_num_rows($result) == 1) {
      while ($row = mysql_fetch_assoc($result))
         $retValue =  new Round($row['id'], $row['Event'], $row['StartType'], $row['StartTime'], $row['Interval'], $row['ValidResults'], 0, $row['Course'], $row['GroupsFinished']);
   }
   mysql_free_result($result);

   return $retValue;
}


/**
 * Function for setting the rounds for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the round.
 */
function SetRounds($eventid, $rounds, $deleteRounds = array())
{
   $eventid = (int) $eventid;

   foreach ($deleteRounds as $toDelete) {
      $toDelete = (int) $toDelete;
      $query = format_query("DELETE FROM :Round WHERE Event = $eventid AND id = $toDelete");
      $result = execute_query($query);

      if (!$result)
         return Error::Query($query);
   }

   foreach ($rounds as $round) {
      $date = $round['date'];
      $time = $round['time'];
      $datestring = $round['datestring'];
      $roundid = $round['roundid'];

      $r_event = (int) $eventid;
      $r_course = null;
      $r_starttype = "simultaneous";
      $r_starttime = (int) $date;
      $r_interval = 10;
      $r_validresults = 1;

      if (empty($roundid) || $roundid == '*') {
         $query = format_query("INSERT INTO :Round (Event, Course, StartType, StartTime, `Interval`, ValidResults) VALUES (%d, %s, '%s', FROM_UNIXTIME(%d), %d, %d);",
                           $r_event, esc_or_null($r_course, 'int'), $r_starttype, $r_starttime, $r_interval, $r_validresults);
         $result = execute_query($query);

         if (!$result)
            return Error::Query($query);
      }
   }

   return null;
}


/**
 * Function for setting the round course
 *
 * Returns cource id for success or an Error
 */
function GetOrSetRoundCourse($roundid)
{
   $courseid = null;
   $query = format_query("SELECT Course FROM :Round WHERE id = %d",
                      (int) $roundid);
   $result = execute_query($query);

   if (mysql_num_rows($result) == 1) {
      $row = mysql_fetch_assoc($result);
      $course = $row['Course'];
      mysql_free_result($result);
   }
   else
      return Error::internalError("Invalid round id argument");

   // Create a new course for the round
   $query = format_query("INSERT INTO :Course (Venue, Name, Description, Link, Map) VALUES (NULL, '%s', '%s', '%s', '%s');",
                     "", "", "", "");
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $courseid = mysql_insert_id();
   $query = format_query("UPDATE :Round SET Course = %d WHERE id = %d;", $courseid, $roundid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

  return $courseid;
}


function GetRoundHoles($roundId)
{
   require_once 'core/hole.php';

   $retValue = array();
   $roundId = (int) $roundId;
   $query = format_query("SELECT :Hole.id, :Hole.Course, HoleNumber, HoleText, Par, Length, :Round.id Round
                         FROM :Hole
                         INNER JOIN :Course ON (:Course.id = :Hole.Course)
                         INNER JOIN :Round ON (:Round.Course = :Course.id)
                         WHERE :Round.id = $roundId
                         ORDER BY HoleNumber");
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


function GetRoundResults($roundId, $sortedBy)
{
   require_once 'core/hole.php';

   $groupByClass = false;
   if ($sortedBy == 'resultsByClass')
      $groupByClass = true;

   $retValue = array();
   $roundId = (int) $roundId;

   $query = "SELECT :Player.player_id as PlayerId, :Player.firstname FirstName, :Player.lastname LastName, :Player.pdga PDGANumber,
                 :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                 :StartingOrder.GroupNumber, (:HoleResult.Result - :Hole.Par) AS Plusminus, Completed,
                 :HoleResult.Result AS HoleResult, :Hole.id AS HoleId, :Hole.HoleNumber, :RoundResult.PlusMinus RoundPlusMinus,
                 :Classification.Name ClassName, CumulativePlusminus, CumulativeTotal, :RoundResult.DidNotFinish,
                 :Classification.id Classification
                         FROM :Round
                         LEFT JOIN :Section ON :Round.id = :Section.Round
                         LEFT JOIN :StartingOrder ON (:StartingOrder.Section = :Section.id )
                         LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                         LEFT JOIN :HoleResult ON (:HoleResult.RoundResult = :RoundResult.id AND :HoleResult.Player = :StartingOrder.Player)
                         LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
                         LEFT JOIN :User ON :Player.player_id = :User.Player
                         LEFT JOIN :Participation ON (:Participation.Player = :Player.player_id AND
                                                     :Participation.Event = :Round.Event)
                         LEFT JOIN :Classification ON :Classification.id = :Participation.Classification
                         LEFT JOIN :Hole ON :HoleResult.Hole = :Hole.id
                         WHERE :Round.id = $roundId AND :Section.Present";

   switch ($sortedBy) {
     case 'group':
         $query .= " ORDER BY :StartingOrder.GroupNumber, :StartingOrder.id";
         break;

     case 'results':
     case 'resultsByClass':
         $query .= " ORDER BY (:RoundResult.DidNotFinish IS NULL OR :RoundResult.DidNotFinish = 0) DESC,  :Hole.id IS NULL, :RoundResult.CumulativePlusminus, :Player.player_id";
         break;

     default:
         return Error::InternalError();
   }

   $query = format_query($query);
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      $index = 1;
      $lastrow = null;

      while ($row = mysql_fetch_assoc($result)) {
         if (!$row['PlayerId'])
            continue;

         if (@$lastrow['PlayerId'] != $row['PlayerId']) {
            if ($lastrow) {
               if ($groupByClass) {
                  $class = $lastrow['ClassName'];
                  if (!isset($retValue[$class]))
                     $retValue[$class] = array();
                  $retValue[$class][] = $lastrow;
               }
               else {
                  $retValue[] = $lastrow;
               }
            }
            $lastrow = $row;
            $lastrow['Results'] = array();
            $lastrow['TotalPlusMinus'] = $lastrow['Penalty'];
         }

         $lastrow['Results'][$row['HoleNumber']] = array(
            'Hole' => $row['HoleNumber'],
            'HoleId' => $row['HoleId'],
            'Result' => $row['HoleResult']);

         $lastrow['TotalPlusMinus'] += $row['Plusminus'];
      }

      if ($lastrow) {
         if ($groupByClass) {
            $class = $lastrow['ClassName'];
            if (!isset($retValue[$class]))
               $retValue[$class] = array();
            $retValue[$class][] = $lastrow;
         }
         else {
             $retValue[] = $lastrow;
         }
      }
   }
   mysql_free_result($result);

   if ($sortedBy == 'resultsByClass')
      $retValue = data_FinalizeResultSort($roundId, $retValue);

   return $retValue;
}


function GetResultUpdatesSince($eventId, $roundId, $time)
{
   if ((int) $time < 10)
      $time = 10;

   if ($roundId) {
      $query = format_query("SELECT :HoleResult.Player, :HoleResult.Hole, :HoleResult.Result,
                          :RoundResult.`Round`, :Hole.HoleNumber
                       FROM :HoleResult
                       INNER JOIN :RoundResult ON :HoleResult.RoundResult = :RoundResult.id
                       INNER JOIN :Hole ON :Hole.id = :HoleResult.Hole
                       WHERE :RoundResult.`Round` = %d
                       AND :HoleResult.LastUpdated > FROM_UNIXTIME(%d)
                       ", $roundId, $time - 2);
   }
   else {
      $query = format_query("SELECT :HoleResult.Player, :HoleResult.Hole, :HoleResult.Result,
                          HoleNumber,
                          :RoundResult.`Round`
                       FROM :HoleResult
                       INNER JOIN :RoundResult ON :HoleResult.RoundResult = :RoundResult.id
                       INNER JOIN `:Round` ON `:Round`.id = :RoundResult.`Round`
                       INNER JOIN :Hole ON :Hole.id = :HoleResult.Hole
                       WHERE `:Round`.Event = %d
                       AND :HoleResult.LastUpdated > FROM_UNIXTIME(%d)
                       ", $eventId, $time - 2);
   }

   $out = array();
   $result = execute_query($query);

   while (($row = mysql_fetch_assoc($result)) !== false) {
      $out[] = array(
         'PlayerId' => $row['Player'],
         'HoleId' => $row['Hole'],
         'HoleNum' => $row['HoleNumber'],
         'Special' => null,
         'Value' => $row['Result'],
         'RoundId' => $row['Round']);
   }
   mysql_free_result($result);

   $query = format_query("SELECT Result, Player, SuddenDeath, Penalty, Round
                    FROM :RoundResult
                    WHERE :RoundResult.`Round` = %d
                    AND LastUpdated > FROM_UNIXTIME(%d)
                    ", $roundId, $time);
   $result = execute_query($query);

   while (($row = mysql_fetch_assoc($result)) !== false) {
      $out[] = array(
         'PlayerId' => $row['Player'],
         'HoleId' => null,
         'HoleNum' => 0,
         'Special' => 'Sudden Death',
         'Value' => $row['SuddenDeath'],
         'RoundId' => $row['Round']);
      $out[] = array(
         'PlayerId' => $row['Player'],
         'HoleId' => null,
         'HoleNum' => 0,
         'Special' => 'Penalty',
         'Value' => $row['Penalty'],
         'RoundId' => $row['Round']);
   }
   mysql_free_result($result);

   return $out;
}


function SaveResult($roundid, $playerid, $holeid, $special, $result)
{
   $rrid = GetRoundResult($roundid, $playerid);
   if (is_a($rrid, 'Error'))
      return $rrid;

   if ($holeid === null)
      return data_UpdateRoundResult($rrid, $special, $result);

   return data_UpdateHoleResult($rrid, $playerid, $holeid, $result);
}


function data_UpdateHoleResult($rrid, $playerid, $holeid, $result)
{
   execute_query(format_query("LOCK TABLE :HoleResult WRITE"));

   $query = format_query("SELECT id FROM :HoleResult WHERE RoundResult = %d AND Player = %d AND Hole = %d",
      $rrid, $playerid, $holeid);
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      $query = format_query("INSERT INTO :HoleResult (Hole, RoundResult, Player, Result, DidNotShow, LastUpdated) VALUES (%d, %d, %d, 0, 0, NOW())",
        $holeid, $rrid, $playerid);
      execute_query($query);
   }

   $dns = 0;
   if ($result == 99 || $result == 999) {
      $dns = 1;
      $result = 99;
   }

   $query = format_query("UPDATE :HoleResult SET Result = %d, DidNotShow = %d, LastUpdated = NOW() WHERE RoundResult = %d AND Hole = %d AND Player = %d",
                  $result, $dns, $rrid, $holeid, $playerid);
   $result = execute_query($query);

   execute_query(format_query("UNLOCK TABLES"));
   return data_UpdateRoundResult($rrid);
}


function data_UpdateRoundResult($rrid, $modifyField = null, $modValue = null)
{
   $query = format_query("SELECT `Round`, Penalty, SuddenDeath FROM :RoundResult WHERE id = %d", $rrid);
   $result = execute_query($query);
   if (!$result)
      return Error::Query($query);

   $details = mysql_fetch_assoc($result);
   $round = GetRoundDetails($details['Round']);
   $numHoles = $round->NumHoles();
   $query = format_query("SELECT Result, DidNotShow, :Hole.Par FROM :HoleResult
                        INNER JOIN :Hole ON :HoleResult.Hole = :Hole.id
                        WHERE RoundResult = %d", $rrid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $holes = $total = $plusminus = $dnf = 0;
   while (($row = mysql_fetch_assoc($result)) !== false) {
      if ($row['DidNotShow']) {
         $dnf = true;
         break;
      }
      else {
         if ($row['Result']) {
            $total += $row['Result'];
            $ppm = $plusminus;
            $plusminus += $row['Result'] - $row['Par'];
            $holes++;
         }
      }
   }
   $total += $details['Penalty'];
   $plusminus += $details['Penalty'];
   $complete = ($total == 999) ? $numHoles : $holes;

   $penalty = $details['Penalty'];
   if ($modifyField == 'Penalty') {
     $total += $modValue - $details['Penalty'];
     $plusminus += $modValue - $details['Penalty'];
     $penalty = $modValue;
   }

   $suddendeath = $details['SuddenDeath'];
   if ($modifyField == 'Sudden Death')
      $suddendeath = $modValue;

   $query = format_query("UPDATE :RoundResult SET Result = %d, Penalty = %d, SuddenDeath = %d, Completed = %d,
                       DidNotFinish = %d, PlusMinus = %d, LastUpdated = NOW() WHERE id = %d",
                    $total, $penalty, $suddendeath, $complete, $dnf ? 1 : 0, $plusminus, $rrid);
   $result = execute_query($query);
   if (!$result)
      return Error::Query($query);

   UpdateCumulativeScores($rrid);
   UpdateEventResults($round->eventId);
}


function UpdateCumulativeScores($rrid)
{
   $query = format_query("
          SELECT :RoundResult.PlusMinus, :RoundResult.Result, :RoundResult.CumulativePlusminus,
                  :RoundResult.CumulativeTotal, :RoundResult.id,
                  :RoundResult.DidNotFinish
                  FROM :RoundResult
                  INNER JOIN `:Round` ON `:Round`.id = :RoundResult.`Round`
                  INNER JOIN `:Round` RX ON `:Round`.Event = RX.Event
                  INNER JOIN :RoundResult RRX ON RRX.`Round` = RX.id
                  WHERE RRX.id = %d AND RRX.Player = :RoundResult.Player
                  ORDER BY `:Round`.StartTime", $rrid);
   $result = execute_query($query);

   $total = 0;
   $pm = 0;
   while (($row = mysql_fetch_assoc($result)) !== false) {
      if (!$row['DidNotFinish']) {
         $total += $row['Result'];
         $pm += $row['PlusMinus'];
      }

      if ($row['CumulativePlusminus'] != $pm || $row['CumulativeTotal'] != $total) {
         $query = format_query("UPDATE :RoundResult SET CumulativeTotal = %d, CumulativePlusminus = %d WHERE id = %d",
                              $total, $pm, $row['id']);
         execute_query($query);
      }
   }
   mysql_free_result($result);
}


function GetRoundResult($roundid, $playerid)
{
   $id = 0;

   $result = execute_query(format_query("LOCK TABLE :RoundResult WRITE"));
   if ($result) {
      $query = format_query("SELECT id FROM :RoundResult WHERE `Round` = %d AND Player = %d", $roundid, $playerid);
      $result = execute_query($query);

      if ($result) {
         $id = 0;
         $rows = mysql_num_rows($result);
         /* FIXME: Need to pinpoint where exactly does this score mangling happen
          * that causes two roundresult rows for same player on same round be created.
          * Then fix it and then decommission this piece of code. */
         if ($rows > 1) {
            /* Cleanest thing we can do is to throw away all the invalid scores and return error.
             * This way TD knows to reload the scoring page and can alleviate the error by re-entering. */
            $query = format_query("DELETE FROM :RoundResult WHERE `Round` = %d AND Player = %d", $roundid, $playerid);
            $result = execute_query($query);
            // Fall thru the the end and return Error to get proper cleanup on the way
         }
         elseif (!mysql_num_rows($result)) {
            $query = format_query("INSERT INTO :RoundResult (`Round`, Player, Result, Penalty, SuddenDeath, Completed, LastUpdated)
                             VALUES (%d, %d, 0, 0, 0, 0, NOW())",
                             $roundid, $playerid);
            $result = execute_query($query);
            if ($result)
               $id = mysql_insert_id();
         }
         else {
            $row = mysql_fetch_assoc($result);
            $id = $row['id'];
         }
      }

      execute_query(format_query("UNLOCK TABLES"));
   }

   if ($id)
      return $id;

   return Error::Query($query);
}




function SetRoundDetails($roundid, $date, $startType, $interval, $valid, $course)
{
   $query = format_query("UPDATE :Round SET StartTime = FROM_UNIXTIME(%d), StartType = '%s', `Interval` = %d, ValidResults = %d, Course = %s WHERE id = %d",
                    (int) $date,
                    escape_string($startType),
                    (int) $interval,
                    $valid ?  1:  0,
                    esc_or_null($course, 'int'),
                    $roundid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function PlayerOnRound($roundid, $playerid)
{
   $query = format_query("SELECT :Participation.Player FROM :Participation
                     INNER JOIN :SectionMembership ON :SectionMembership.Participation = :Participation.id
                     INNER JOIN :Section ON :Section.id = :SectionMembership.Section
                     WHERE :Participation.Player = %d
                     AND   :Section.Round = %d
                     LIMIT 1",
                     $playerid,
                     $roundid);
   $result = execute_query($query);

   return mysql_num_rows($result) != 0;
}


function GetParticipationIdByRound($roundid, $playerid)
{
   $query = format_query("SELECT :Participation.id FROM :Participation
                     INNER JOIN :Event ON :Event.id = :Participation.Event
                     INNER JOIN :Round ON :Round.Event = :Event.id
                     WHERE :Participation.Player = %d
                     AND :Round.id = %d
                     ",
                     $playerid,
                     $roundid);
   $result = execute_query($query);

   if ($result)
      $row = mysql_fetch_assoc($result);
   mysql_free_result($result);

   if ($row === false)
      return null;

   return $row['id'];
}


function RemovePlayersFromRound($roundid, $playerids = null)
{
   if (!is_array($playerids))
      $playerids = array($playerids);

   $retValue = null;
   $playerids = array_filter($playerids, 'is_numeric');

   $query = format_query( "SELECT :SectionMembership.id FROM :SectionMembership
      INNER JOIN :Section ON :Section.id = :SectionMembership.Section
      INNER JOIN :Participation ON :Participation.id = :SectionMembership.Participation
      WHERE :Section.Round = %d AND :Participation.Player IN (%s)",
      $roundid, implode(", " ,$playerids));
   $result = execute_query($query);

   $ids = array();
   while (($row = mysql_fetch_assoc($result)) !== false) {
      $ids[] = $row['id'];
   }
   mysql_free_result($result);

   if (!count($ids))
      return;

   $query = format_query("DELETE FROM :SectionMembership WHERE id IN (%s)", implode(", ", $ids ));
   $result = execute_query($query);

    if (!$result)
      return Error::Query($query);

    return $retValue;
}


function ResetRound($roundid, $resetType = 'full')
{
   $sections = GetSections((int) $roundid);
   $sectIds = array();

   foreach ($sections as $section) {
      $sectIds[] = $section->id;
   }
   $idList = implode(', ', $sectIds);

   if ($resetType == 'groups' || $resetType == 'full')
      execute_query(format_query("DELETE FROM :StartingOrder WHERE Section IN ($idList)"));

   if ($resetType == 'full' || $resetType == 'players')
      execute_query(format_query("DELETE FROM :SectionMembership WHERE Section IN ($idList)"));

   if ($resetType == 'full')
      execute_query(format_query("DELETE FROM :Section WHERE id IN ($idList)"));
}


function GetHoleResults($rrid)
{
   $query = format_query("SELECT Hole, Result FROM :HoleResult WHERE RoundResult = %d", $rrid);
   $result = execute_query($query);

   $out = array();
   if ($result) {
      while (($row = mysql_fetch_assoc($result)) !== false)
         $out[] = $row;
   }
   mysql_free_result($result);

   return $out;
}



function GetRoundCourse($roundid)
{
   $query = format_query("SELECT :Course.id, Name, Description, Link, Map
                  FROM :Course
                  INNER JOIN `:Round` ON `:Round`.Course = :Course.id
                  WHERE `:Round`.id = %d", $roundid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   return mysql_fetch_assoc($result);
}


