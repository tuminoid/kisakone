<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Class
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


// Gets an array of Classification objects (optionally filtered by the Available bit)
function GetClasses($onlyAvailable = false)
{
   require_once 'core/classification.php';

   $retValue = array();

   $query = "SELECT id, Name, MinimumAge, MaximumAge, GenderRequirement, Available FROM :Classification";
   if ($onlyAvailable)
      $query .= " WHERE Available <> 0";
   $query .= " ORDER BY Name";
   $query = format_query($query);
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $retValue[] = new Classification($row['id'], $row['Name'], $row['MinimumAge'],
                                                   $row['MaximumAge'], $row['GenderRequirement'], $row['Available']);
   }
   mysql_free_result($result);

   return $retValue;
}


// Gets a Classification object by id
function GetClassDetails($classId)
{
   require_once 'core/classification.php';

   $retValue = null;
   $classId = (int) $classId;

   $query = format_query("SELECT id, Name, MinimumAge, MaximumAge, GenderRequirement, Available FROM :Classification WHERE id = $classId");
   $result = execute_query($query);

   if (mysql_num_rows($result) == 1) {
      $row = mysql_fetch_assoc($result);
      $retValue = new Classification($row['id'], $row['Name'], $row['MinimumAge'],
                                                   $row['MaximumAge'], $row['GenderRequirement'], $row['Available']);
   }
   mysql_free_result($result);

   return $retValue;
}


/**
 * Function for setting the classes for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the class.
 */
function SetClasses($eventid, $classes)
{
   $retValue = null;
   $eventid = (int) $eventid;

   if (isset($eventid)) {
      $quotas = GetEventQuotas($eventid);
      $query = format_query("DELETE FROM :ClassInEvent WHERE Event = $eventid");
      $result = execute_query($query);

      foreach ($classes as $class) {
         $query = format_query("INSERT INTO :ClassInEvent (Classification, Event) VALUES (%d, %d);",
                           (int) $class, (int) $eventid);
         $result = execute_query($query);

         if (!$result)
            return Error::Query($query);
      }

      // Fix limits back.. do not bother handling errors as some classes may be removed
      foreach ($quotas as $quota) {
         $cid = (int) $quota['id'];
         $min = (int) $quota['MinQuota'];
         $max = (int) $quota['MaxQuota'];

         $query = format_query("UPDATE :ClassInEvent SET MinQuota = %d, MaxQuota = %d
                                 WHERE Event = %d AND Classification = %d",
                                 $min, $max, $eventid, $cid);
         execute_query($query);
      }
   }
   else
      return Error::internalError("Event id argument is not set.");

   return $retValue;
}


function EditClass($id, $name, $minage, $maxage, $gender, $available)
{
   $query = format_query("UPDATE :Classification SET Name = '%s', MinimumAge = %s, MaximumAge = %s, GenderRequirement = %s, Available = %d
                           WHERE id = %d",
                    escape_string($name), esc_or_null($minage,'int'), esc_or_null($maxage, 'int'),
                    esc_or_null($gender, 'gender'), $available ? 1:0, $id);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function CreateClass($name, $minage, $maxage, $gender, $available)
{
   $query = format_query("INSERT INTO :Classification (Name, MinimumAge, MaximumAge, GenderRequirement, Available)
                  VALUES ('%s', %s, %s, %s, %d);",
                    escape_string($name), esc_or_null($minage, 'int'), esc_or_null($maxage, 'int'),
                    esc_or_null($gender, 'gender'), $available ? 1:0);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function DeleteClass($id)
{
   $query = format_query("DELETE FROM :Classification WHERE id = ". (int) $id);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


// Returns true if the provided class is being used in any event, false otherwise
function ClassBeingUsed($id)
{
   $retValue = true;
   $id = (int) $id;
   $query = format_query("SELECT COUNT(*) AS Events FROM :ClassInEvent WHERE Classification = %d"
                          , $id);
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      $temp = mysql_fetch_assoc($result);
      $retValue = ($temp['Events']) > 0;
   }
   mysql_free_result($result);

   return $retValue;
}


function GetSignupsForClass($event, $class)
{
   $classId = (int) $class;
   $eventId = (int) $event;

   $retValue = array();
   $query = format_query("SELECT :Player.id PlayerId, :User.FirstName, :User.LastName, :Player.PDGANumber,
                    :Participation.id ParticipationId
                 FROM :User
                 INNER JOIN :Player ON User.id = :Player.User
                 INNER JOIN :Participation ON :Participation.Player = :Player.id
                 WHERE :Participation.Classification = $classId
                   AND :Participation.Event = $eventId");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $retValue[] = $row;
   }
   mysql_free_result($result);

   return $retValue;
}


function SetParticipantClass($eventid, $playerid, $newClass)
{
   $query = format_query("UPDATE :Participation SET Classification = %d WHERE Player = %d AND Event = %d",
                 $newClass, $playerid, $eventid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   return mysql_affected_rows() == 1;
}


