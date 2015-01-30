<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
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


function GetGroups($sectid)
{
   $query = format_query("
         SELECT
            :Player.player_id PlayerId, :Player.pdga PDGANumber, :StartingOrder.Section,
            :StartingOrder.id, UNIX_TIMESTAMP(:StartingOrder.StartingTime) StartingTime, :StartingOrder.StartingHole, :StartingOrder.GroupNumber,
            :User.UserFirstName, :User.UserLastName, firstname pFN, lastname pLN, :Classification.Name Classification, :Participation.OverallResult
            FROM :StartingOrder
            INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
            INNER JOIN :User ON :Player.player_id = :User.Player
            INNER JOIN :Section ON :StartingOrder.Section = :Section.id
            INNER JOIN :Round ON :Round.id = :Section.Round
            INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
            INNER JOIN :Classification ON :Participation.Classification = :Classification.id
            WHERE :StartingOrder.`Section` = %d
            ORDER BY GroupNumber, OverallResult",
            $sectid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $current = null;
   $out = array();
   $group = null;

   while (($row = mysql_fetch_assoc($result)) !== false) {
      $row['FirstName'] = data_GetOne($row['UserFirstName'], $row['pFN']);
      $row['LastName'] = data_GetOne($row['UserLastName'], $row['pLN']);

      if ($row['GroupNumber'] != $current) {
         if (count($group))
            $out[] = $group;
         $group = $row;
         $group['People'] = array();
         $current = $row['GroupNumber'];
         $group['GroupId'] = sprintf("%d-%d", $row['Section'], $row['GroupNumber']);

         if ($row['StartingHole'])
            $group['DisplayName'] = $row['StartingHole'];
         else
            $group['DisplayName'] = date('H:i', $row['StartingTime']);
      }
      $group['People'][] = $row;
   }

   if (count($group))
      $out[] = $group;

   mysql_free_result($result);

   return $out;
}


function InsertGroup($group)
{
   foreach ($group['People'] as $player) {
      $query = format_query("INSERT INTO :StartingOrder
                       (Player, StartingTime, StartingHole, GroupNumber, Section)
                     VALUES (%d, FROM_UNIXTIME(%d), %s, %d, %d)",
                     $player['PlayerId'],
                     $group['StartingTime'],
                     esc_or_null($group['StartingHole'], 'int'),
                     $group['GroupNumber'],
                     $group['Section']);
      execute_query($query);
   }
}


function InsertGroupMember($data)
{
   $query = format_query("INSERT INTO :StartingOrder
                    (Player, StartingTime, StartingHole, GroupNumber, Section)
                    VALUES (%d, FROM_UNIXTIME(%d), %s, %d, %d)",
                    $data['Player'],
                    $data['StartingTime'],
                    esc_or_null($data['StartingHole'], 'int'),
                    $data['GroupNumber'],
                    $data['Section']);
   execute_query($query);
}


function AnyGroupsDefined($roundid)
{
   $query = format_query("SELECT 1
                  FROM :StartingOrder
                  INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                  INNER JOIN `:Round` ON `:Round`.id = :Section.`Round`
                  WHERE `:Round`.id = %d LIMIT 1", $roundid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   return mysql_num_rows($result) > 0;
}


function GetRoundGroups($roundid)
{
   $query = format_query("SELECT GroupNumber, StartingTime, StartingHole, :Classification.Name ClassificationName,
                     :Player.lastname LastName, :Player.firstname FirstName, :User.id UserId, :Participation.OverallResult
                  FROM :StartingOrder
                  INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                  INNER JOIN `:Round` ON `:Round`.id = :Section.`Round`
                  INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                  INNER JOIN :User ON :User.Player = :Player.player_id
                  INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                  INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                  WHERE `:Round`.id = %d
                  ORDER BY GroupNumber, :StartingOrder.id", $roundid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $out = array();
   while (($row = mysql_fetch_array($result)) !== false)
      $out[] = $row;
   mysql_free_result($result);

   return $out;
}


function GetSingleGroup($roundid, $playerid)
{
   $query = format_query("SELECT :StartingOrder.GroupNumber, UNIX_TIMESTAMP(:StartingOrder.StartingTime) StartingTime, :StartingOrder.StartingHole,
                     :Classification.Name ClassificationName,
                     :Player.lastname LastName, :Player.firstname FirstName, :User.id UserId
                  FROM :StartingOrder
                  INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                  INNER JOIN `:Round` ON `:Round`.id = :Section.`Round`
                  INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                  INNER JOIN :User ON :User.Player = :Player.player_id
                  INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                  INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                  INNER JOIN :StartingOrder BaseGroup ON (:StartingOrder.Section = BaseGroup.Section
                                                       AND :StartingOrder.GroupNumber = BaseGroup.GroupNumber)
                  WHERE `:Round`.id = %d AND BaseGroup.Player = %d
                  ORDER BY GroupNumber, :StartingOrder.id", $roundid, $playerid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $out = array();
   while (($row = mysql_fetch_array($result)) !== false)
      $out[] =$row;
   mysql_free_result($result);

   return $out;
}


function GetSingleGroupByPN($roundid, $groupNumber)
{
   $query = format_query("SELECT :StartingOrder.GroupNumber, :StartingOrder.StartingTime, :StartingOrder.StartingHole,
                     :Classification.Name ClassificationName,
                     :Player.lastname LastName, :Player.firstname FirstName, :User.id UserId
                  FROM :StartingOrder
                  INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                  INNER JOIN `:Round` ON `:Round`.id = :Section.`Round`
                  INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                  INNER JOIN :User ON :User.Player = :Player.player_id
                  INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                  INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                  WHERE `:Round`.id = %d AND GroupNumber = %d
                  ORDER BY GroupNumber, :StartingOrder.id", $roundid, $groupNumber);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $out = array();
   while (($row = mysql_fetch_array($result)) !== false)
      $out[] =$row;
   mysql_free_result($result);

   return $out;
}


function GetUserGroupSummary($eventid, $playerid)
{
   $query = format_query("SELECT :StartingOrder.GroupNumber, UNIX_TIMESTAMP(:StartingOrder.StartingTime) StartingTime, :StartingOrder.StartingHole,
                     :Classification.Name ClassificationName, :Round.GroupsFinished,
                     :Player.lastname LastName, :Player.firstname FirstName, :User.id UserId
                  FROM :StartingOrder
                  INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                  INNER JOIN `:Round` ON `:Round`.id = :Section.`Round`
                  INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                  INNER JOIN :User ON :User.Player = :Player.player_id
                  INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                  INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                  WHERE `:Round`.Event = %d AND :StartingOrder.Player = %d
                  ORDER BY `:Round`.StartTime", $eventid, $playerid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $out = array();
   while (($row = mysql_fetch_array($result)) !== false)
      $out[] =$row;
   mysql_free_result($result);

   if (!count($out))
      return null;

   return $out;
}

function SetRoundGroupsDone($roundid, $done)
{
   $time = null;
   if ($done)
      $time = time();

   $query = format_query("UPDATE `:Round` SET GroupsFinished = FROM_UNIXTIME(%s) WHERE id = %d", esc_or_null($time, 'int' ), $roundid);
   execute_query($query);
}


