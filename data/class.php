<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'data/db.php';
require_once 'core/classification.php';


// Gets an array of Classification objects (optionally filtered by the Available bit)
function GetClasses($onlyAvailable = false)
{
    $available = $onlyAvailable ? " WHERE Available <> 0" : "";

    $result = db_all("SELECT * FROM :Classification $available ORDER BY Priority ASC, Name");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new Classification($row);
    return $retValue;
}


// Gets a Classification object by id
function GetClassDetails($classid)
{
    $classid = esc_or_null($classid, 'int');

    $result = db_one("SELECT * FROM :Classification WHERE id = $classid");

    if (db_is_error($result))
        return $result;

    return new Classification($result);
}


/**
 * Function for setting the classes for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the class.
 */
function SetEventClasses($eventid, $classes)
{
    if (!isset($eventid))
        return Error::InternalError("Event id argument is not set.");

    $eventid = esc_or_null($eventid, 'int');
    $quotas = GetEventQuotas($eventid);
    db_exec("DELETE FROM :ClassInEvent WHERE Event = $eventid");

    foreach ($classes as $class) {
        $class = esc_or_null($class, 'int');
        $eventid = esc_or_null($eventid, 'int');

        $result = db_exec("INSERT INTO :ClassInEvent (Classification, Event) VALUES ($class, $eventid)");
        if (db_is_error($result))
            return $result;
    }

    // Fix limits back.. do not bother handling errors as some classes may be removed
    foreach ($quotas as $quota) {
        $cid = esc_or_null($quota['id'], 'int');
        $minquota = esc_or_null($quota['MinQuota'], 'int');
        $maxquota = esc_or_null($quota['MaxQuota'], 'int');

        $result = db_exec("UPDATE :ClassInEvent
                                SET MinQuota = $minquota, MaxQuota = $maxquota
                                WHERE Event = $eventid AND Classification = $cid");

        if (db_is_error($result))
            return $result;
    }
}


function EditClass($id, $name, $short, $minage, $maxage, $gender, $available, $status, $priority, $ratinglimit, $prosplayingamlimit)
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
    $prosplayingamlimit = esc_or_null($prosplayingamlimit, 'int');

    return db_exec("UPDATE :Classification
                SET Name = $name, Short = $short, MinimumAge = $minage, MaximumAge = $maxage,
                GenderRequirement = $gender, Available = $available, Status = $status,
                Priority = $priority, RatingLimit = $ratinglimit, ProsPlayingAmLimit = $prosplayingamlimit
                WHERE id = $id");
}


function CreateClass($name, $short, $minage, $maxage, $gender, $available, $status, $priority, $ratinglimit, $prosplayingamlimit)
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
    $prosplayingamlimit = esc_or_null($prosplayingamlimit, 'int');

    return db_exec("INSERT INTO :Classification (Name, Short, MinimumAge, MaximumAge,
                    GenderRequirement, Available, Status, Priority, RatingLimit, ProsPlayingAmLimit)
                  VALUES ($name, $short, $minage, $maxage, $gender, $available, $status,
                    $priority, $ratinglimit, $prosplayingamlimit)");
}


function DeleteClass($id)
{
    $id = esc_or_null($id, 'int');

    return db_exec("DELETE FROM :Classification WHERE id = $id");
}


// Returns true if the provided class is being used in any event, false otherwise
function ClassBeingUsed($id)
{
    $id = esc_or_null($id, 'int');

    $result = db_one("SELECT COUNT(*) AS Events FROM :ClassInEvent WHERE Classification = $id");

    if (db_is_error($result))
        return $result;

    return @$result['Events'];
}


function GetSignupsForClass($event, $class)
{
    $classId = esc_or_null($class, 'int');
    $eventId = esc_or_null($event, 'int');

    return db_all("SELECT :Player.id AS PlayerId, :User.FirstName, :User.LastName, :Player.PDGANumber, :Participation.id AS ParticipationId
                FROM :User
                INNER JOIN :Player ON User.id = :Player.User
                INNER JOIN :Participation ON :Participation.Player = :Player.id
                WHERE :Participation.Classification = $classId AND :Participation.Event = $eventId");
}


function SetParticipantClass($eventid, $playerid, $newclass)
{
    $eventid = esc_or_null($eventid, 'int');
    $playerid = esc_or_null($playerid, 'int');
    $newclass = esc_or_null($newclass, 'int');

    return db_exec("UPDATE :Participation SET Classification = $newclass WHERE Player = $playerid AND Event = $eventid");
}
