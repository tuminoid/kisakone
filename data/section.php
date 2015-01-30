<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Section
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


// Get sections for a Round
function GetSections($round, $order = 'time')
{
   require_once 'core/section.php';

   $retValue = array();
   $roundId = (int) $round;
   $query = "SELECT :Section.id,  Name,
                         UNIX_TIMESTAMP(StartTime) StartTime, Priority, Classification, Round, Present
                                      FROM :Section
                                      WHERE :Section.Round = $roundId ORDER BY ";

   if ($order == 'time')
      $query .= "Priority, StartTime, Name";
   else
      $query .= "Classification, Name";
   $query = format_query($query);
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $retValue[] = new Section($row);
   }
   mysql_free_result($result);

   return $retValue;
}


// Gets a Section object by id
function GetSectionDetails($sectionId)
{
   require_once 'core/section.php';

   $retValue = null;
   $sectionId = (int) $sectionId;

   $query = format_query("SELECT id, Name, Round, Priority, UNIX_TIMESTAMP(StartTime) StartTime, Present, Classification FROM :Section WHERE id = $sectionId");
   $result = execute_query($query);

   if (mysql_num_rows($result) == 1) {
      $row = mysql_fetch_assoc($result);
      $retValue = new Section($row);
   }
   mysql_free_result($result);

   return $retValue;
}


function GetSectionMembers($sectionId)
{
   $sectionId = (int) $sectionId;

   $retValue = array();
   $query = format_query("SELECT :Player.player_id PlayerId, :User.UserFirstName, :User.UserLastName, :Player.pdga PDGANumber,
                 :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM, :Classification.Name Classification,
                    SM.id as MembershipId, :Participation.OverallResult
                 FROM :User
                 INNER JOIN :Player ON :User.Player = :Player.player_id
                 INNER JOIN :Participation ON :Player.player_id = :Participation.Player
                 INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                 INNER JOIN :SectionMembership SM ON SM.Participation = :Participation.id
                 WHERE SM.Section = $sectionId
                   ORDER BY SM.id");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $row['FirstName'] = data_GetOne($row['UserFirstName'], $row['pFN']);
         $row['LastName'] = data_GetOne($row['UserLastName'], $row['pLN']);
         $retValue[] = $row;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


function CreateSection($round, $baseClassId, $name)
{
   $round = (int) $round;
   $name = escape_string($name);

   $query = format_query("INSERT INTO :Section(Round, Classification, Name, Present)
      VALUES(%d, %s, '%s', 1)", $round, esc_or_null($baseClassId, 'int'), $name);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   return mysql_insert_id();
}


function RenameSection($classId, $newName)
{
   $classId = (int) $classId;
   $newName = escape_string($newName);
   $query = format_query("UPDATE :Section SET Name = '%s' WHERE id = %d", $newName, $classId);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function AssignPlayersToSection($roundId, $sectionid, $playerIds)
{
   $each = array();
   foreach ($playerIds as $playerId)
      $each[] = sprintf("(%d, %d)", GetParticipationIdByRound($roundId, $playerId), $sectionid);

   $data = implode(", ", $each);
   $query = format_query("INSERT INTO :SectionMembership (Participation, Section) VALUES %s", $data);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function EditSection($roundId, $sectionId, $priority, $startTime)
{
   $roundId = (int) $roundId;
   $classId = (int) $classId;
   $priority = esc_or_null($priority, 'int');
   $startTime = esc_or_null($startTime, 'int');

   $query = format_query("UPDATE :ClassOnRound SET Priority = %s, StartTime = FROM_UNIXTIME(%s) WHERE Round = %d AND Classification = %d",
                            $priority, $startTime, $roundId, $classId);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function AdjustSection($sectionid, $priority, $sectionTime, $present)
{
   $query = format_query("UPDATE :Section SET Priority = %d, StartTime = FROM_UNIXTIME(%s), Present = %d WHERE id = %d",
                     $priority,
                     esc_or_null($sectionTime, 'int'),
                     $present ? 1 : 0,
                     $sectionid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function RemovePlayersDefinedforAnySection($a)
{
   list($round, $section) = $GLOBALS['RemovePlayersDefinedforAnySectionRound'];

   static $data;
   if (!is_array($data))
      $data = array();

   $key = sprintf("%d_%d", $round, $section);
   if (!isset($data[$key])) {
      $query = format_query("SELECT Player FROM :StartingOrder
                          INNER JOIN :Section ON :StartingOrder.Section = :Section.id
                          WHERE :Section.Round = %d", $round);
      $result = execute_query($query);

      $mydata = array();
      while (($row = mysql_fetch_assoc($result)) !== false)
         $mydata[$row['Player']] = true;
      $data[$key] = $mydata;
      mysql_free_result($result);
   }

   return !@$data[$key][$a['PlayerId']];
}


function RemoveEmptySections($round)
{
   $sections = GetSections((int) $round);
   foreach ($sections as $section) {
      $players = $section->GetPlayers();

      if (!count($players))
         execute_query(format_query("DELETE FROM :Section WHERE id = %d", $section->id));
   }
}


