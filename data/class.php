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
require_once 'core/classification.php';


// Gets an array of Classification objects (optionally filtered by the Available bit)
function GetClasses($onlyAvailable = false)
{
    $available = $onlyAvailable ? " WHERE Available <> 0" : "";

    $query = format_query("SELECT * FROM :Classification $available ORDER BY Priority ASC, Name");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = new Classification($row);
    }
    mysql_free_result($result);

    return $retValue;
}


// Gets a Classification object by id
function GetClassDetails($classId)
{
    $classId = (int) $classId;

    $query = format_query("SELECT * FROM :Classification WHERE id = $classId");
    $result = execute_query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = new Classification($row);
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
    $eventid = (int) $eventid;

    if (!isset($eventid))
        return Error::InternalError("Event id argument is not set.");

    $quotas = GetEventQuotas($eventid);
    execute_query(format_query("DELETE FROM :ClassInEvent WHERE Event = $eventid"));

    foreach ($classes as $class) {
        $class = (int) $class;
        $eventid = (int) $eventid;

        $query = format_query("INSERT INTO :ClassInEvent (Classification, Event) VALUES ($class, $eventid)");
        $result = execute_query($query);

        if (!$result)
            return Error::Query($query);
    }

    // Fix limits back.. do not bother handling errors as some classes may be removed
    foreach ($quotas as $quota) {
        $cid = (int) $quota['id'];
        $minquota = (int) $quota['MinQuota'];
        $maxquota = (int) $quota['MaxQuota'];

        $query = format_query("UPDATE :ClassInEvent
                                SET MinQuota = $minquota, MaxQuota = $maxquota
                                WHERE Event = $eventid AND Classification = $cid");
        execute_query($query);
    }
}


function EditClass($id, $name, $short, $minage, $maxage, $gender, $available, $status, $priority, $ratinglimit)
{
    $id = esc_or_null($id, 'int');
    $name = esc_or_null($name);
    $short = esc_or_null($short);
    $minage = esc_or_null($minage, 'int');
    $maxage = esc_or_null($maxage, 'int');
    $gender = esc_or_null($gender, 'gender');
    $available = $available ? 1 : 0;
    $status = esc_or_null(strtolower($status) == 'a' ? 'A' : 'P');
    $priority = esc_or_null($priority, 'int');
    $ratinglimit = esc_or_null($ratinglimit, 'int');

    $query = "UPDATE :Classification
                SET Name = $name, Short = $short, MinimumAge = $minage, MaximumAge = $maxage,
                GenderRequirement = $gender, Available = $available, Status = $status,
                Priority = $priority, RatingLimit = $ratinglimit
                WHERE id = $id";
    $query = format_query($query);
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}


function CreateClass($name, $short, $minage, $maxage, $gender, $available, $status, $priority, $ratinglimit)
{
    $name = esc_or_null($name);
    $short = esc_or_null($short);
    $minage = esc_or_null($minage, 'int');
    $maxage = esc_or_null($maxage, 'int');
    $gender = esc_or_null($gender, 'gender');
    $available = $available ? 1 : 0;
    $status = esc_or_null(strtolower($status) == 'a' ? 'A' : 'P');
    $priority = esc_or_null($priority, 'int');
    $ratinglimit = esc_or_null($ratinglimit, 'int');

    $query = "INSERT INTO :Classification (Name, Short, MinimumAge, MaximumAge, GenderRequirement, Available, Status, Priority, RatingLimit)
                  VALUES ($name, $short, $minage, $maxage, $gender, $available, $status, $priority, $ratinglimit)";
    $query = format_query($query);
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}


function DeleteClass($id)
{
    $id = (int) $id;

    $query = format_query("DELETE FROM :Classification WHERE id = $id");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}


// Returns true if the provided class is being used in any event, false otherwise
function ClassBeingUsed($id)
{
    $id = (int) $id;

    $query = format_query("SELECT COUNT(*) AS Events FROM :ClassInEvent WHERE Classification = $id");
    $result = execute_query($query);

    $retValue = true;
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

    $query = "SELECT :Player.id AS PlayerId, :User.FirstName, :User.LastName, :Player.PDGANumber, :Participation.id AS ParticipationId
                FROM :User
                INNER JOIN :Player ON User.id = :Player.User
                INNER JOIN :Participation ON :Participation.Player = :Player.id
                WHERE :Participation.Classification = $classId AND :Participation.Event = $eventId";
    $query = format_query($query);
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = $row;
    }
    mysql_free_result($result);

    return $retValue;
}


function SetParticipantClass($eventid, $playerid, $newClass)
{
    $eventid = (int) $eventid;
    $playerid = (int) $playerid;
    $newClass = (int) $newClass;

    $query = format_query("UPDATE :Participation SET Classification = $newClass WHERE Player = $playerid AND Event = $eventid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    return mysql_affected_rows() == 1;
}
