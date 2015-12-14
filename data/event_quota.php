<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Event quotas
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


/* Get Quotas for Classes in Event */
function GetEventQuotas($eventId)
{
    $event = esc_or_null($eventId, 'int');

    return db_all("SELECT :Classification.id, Name, Short, :ClassInEvent.MinQuota, :ClassInEvent.MaxQuota
                            FROM :Classification, :ClassInEvent
                            WHERE :ClassInEvent.Classification = :Classification.id AND :ClassInEvent.Event = $event
                            ORDER BY Name");
}


// Return min and max quota for a class
function GetEventClassQuota($eventid, $classid)
{
    $quotas = GetEventQuotas($eventid);
    foreach ($quotas as $quota) {
        if ($quota['id'] == $classid)
            return array($quota['MinQuota'], $quota['MaxQuota']);
    }

    // not found, give defaults
    return array(0, 999);
}


// Set class's min quota
function SetEventClassQuota($eventid, $classid, $quota, $key)
{
    $eventid = esc_or_null($eventid, 'int');
    $classid = esc_or_null($classid, 'int');
    $quota = esc_or_null($quota, 'int');
    $key = esc_or_null($key, 'key');

    return db_exec("UPDATE :ClassInEvent SET $key = $quota WHERE Event = $eventid AND Classification = $classid");
}


// Set class's min quota
function SetEventClassMinQuota($eventid, $classid, $quota)
{
    return SetEventClassQuota($eventid, $classid, $quota, 'MinQuota');
}

// Set class's max quota
function SetEventClassMaxQuota($eventid, $classid, $quota)
{
    return SetEventClassQuota($eventid, $classid, $quota, 'MaxQuota');
}


/**
 * Function for checking if player fits event quota or should be queued
 *
 * Returns true for direct signup, false for queue
 *
 * @param int  $eventId   Event ID
 * @param int  $playerId  Player ID
 * @param int  $classId   Classification ID
 */
function CheckSignUpQuota($eventId, $playerId, $classId)
{
    $event = GetEventDetails($eventId);
    $participants = $event->GetParticipants();
    $limit = $event->playerLimit;
    $total = count($participants);

    // Too many players registered already
    if ($limit > 0 && $total >= $limit)
        return false;

    // Calculate some limits and counts
    list($minquota, $maxquota) = GetEventClassQuota($eventId, $classId);
    $classcounts = GetEventParticipantCounts($eventId);
    $classcount = isset($classcounts[$classId]) ? $classcounts[$classId] : 0;

    // Check versus class maxquota
    if ($classcount >= $maxquota)
        return false;

    // If there is unused quota in class, allow player in
    if ($classcount < $minquota)
        return true;

    // Calculate unused quota in other divisions, if there is global limit set
    if ($limit > 0) {
        $unusedQuota = 0;
        $quotas = GetEventQuotas($eventId);

        foreach ($quotas as $idx => $quota) {
            $cquota = $quota['MinQuota'];
            $ccount = (isset($classcounts[$quota['id']]) ? $classcounts[$quota['id']] : 0);
            $cunused = $cquota - $ccount;

            if ($cunused > 0)
                $unusedQuota += $cunused;
        }
        $spots_left = $limit - $total - $unusedQuota;

        // Deny if there is no unreserved space left
        if ($spots_left <= 0)
            return false;
    }

    // ok, we have space left
    return true;
}
