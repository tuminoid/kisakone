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
require_once 'data/player.php';
require_once 'core/player.php';
require_once 'core/user.php';
require_once 'core/email.php';
require_once 'core/rules.php';


/* Return event's queue counts by class */
function GetEventQueueCounts($eventId)
{
    $eventId = (int) $eventId;

    $query = format_query("SELECT COUNT(*) AS cnt, Classification
                           FROM :EventQueue
                           WHERE Event = $eventId
                           GROUP BY Classification");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            $class = $row['Classification'];
            $retValue[$class] = $row['cnt'];
        }
    }
    mysql_free_result($result);

    return $retValue;
}


// FIXME: Redo to a simpler form sometime
function GetEventQueue($eventId, $sortedBy, $search)
{
    $eventId = (int) $eventId;
    $where = data_ProduceSearchConditions($search, array('FirstName', 'LastName', 'pdga', 'Username', 'birthdate'));

    $query = "SELECT :User.id AS UserId, Username, Role, UserFirstName, UserLastName, UserEmail,
                    :Player.firstname AS pFN, :Player.lastname AS pLN, :Player.email AS pEM, :Player.player_id AS PlayerId,
                    pdga AS PDGANumber, Sex, YEAR(birthdate) AS YearOfBirth, :Classification.Name AS ClassName,
                    :EventQueue.id AS QueueId, :Club.ShortName AS ClubName, :EventQueue.Rating AS Rating,
                    UNIX_TIMESTAMP(SignupTimestamp) AS SignupTimestamp, :Classification.id AS ClassId
                FROM :User
                INNER JOIN :Player ON :Player.player_id = :User.Player
                INNER JOIN :EventQueue ON (:EventQueue.Player = :Player.player_id AND :EventQueue.Event = $eventId)
                INNER JOIN :Classification ON :EventQueue.Classification = :Classification.id
                LEFT JOIN :Club ON :User.Club = :Club.id
                WHERE $where
                ORDER BY SignupTimestamp ASC, :EventQueue.id ASC";
    $query = format_query($query);
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            $pdata = array();

            $firstname = data_GetOne($row['UserFirstName'], $row['pFN']);
            $lastname = data_GetOne($row['UserLastName'], $row['pLN']);
            $email = data_GetOne($row['UserEmail'], $row['pEM']);
            $user = new User($row['UserId'], $row['Username'], $row['Role'], $firstname, $lastname, $email, $row['PlayerId']);
            $player = new Player($row['PlayerId'], $row['PDGANumber'], $row['Sex'], $row['YearOfBirth'], $firstname, $lastname, $email);

            $pdata['user'] = $user;
            $pdata['player'] = $player;
            $pdata['queueId'] = $row['QueueId'];
            $pdata['signupTimestamp'] = $row['SignupTimestamp'];
            $pdata['className'] = $row['ClassName'];
            $pdata['classId'] = $row['ClassId'];
            $pdata['clubName'] = $row['ClubName'];
            $pdata['rating'] = $row['Rating'];

            $retValue[] = $pdata;
        }
    }
    mysql_free_result($result);

    return $retValue;
}


// Check if we can raise players from queue after someone left
function CheckQueueForPromotions($eventId)
{
    $queuers = GetEventQueue($eventId, '', '');

    foreach ($queuers as $queuer) {
        $playerId = (int) $queuer['player']->id;
        $classId = (int) $queuer['classId'];

        $quota_ok = CheckSignupQuota($eventId, $playerId, $classId);
        $rules_ok = (CheckEventRules($eventId, $classId, $playerId) === true ? true : false);

        if ($quota_ok && $rules_ok)
            PromotePlayerFromQueue($eventId, $playerId);
    }

    return null;
}


// Raise competitor from queue to the event
function PromotePlayerFromQueue($eventId, $playerId)
{
    $eventId = (int) $eventId;
    $playerId = (int) $playerId;

    // Get data from queue
    $query = format_query("SELECT * FROM :EventQueue WHERE Player = $playerId AND Event = $eventId");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_assoc($result);

        // Insert into competition
        $player = (int) $row['Player'];
        $event = (int) $row['Event'];
        $class = (int) $row['Classification'];
        $user = GetPlayerUser($player);
        $userid = $user ? $user->id : null;

        // cancel player from both queue/competition and set it again
        CancelSignup($eventId, $playerId, false);
        SetPlayerParticipation($player, $event, $class, true);

        if ($user !== null)
            SendEmail(EMAIL_PROMOTED_FROM_QUEUE, $user->id, GetEventDetails($eventId));
    }
    mysql_free_result($result);

    return null;
}


function UserQueueing($eventid, $userid)
{
    $eventid = (int) $eventid;
    $userid = (int) $userid;

    $query = format_query("SELECT :EventQueue.id
                            FROM :EventQueue
                            INNER JOIN :Player ON :EventQueue.Player = :Player.player_id
                            INNER JOIN :User ON :User.Player = :Player.player_id
                            WHERE :User.id = $userid AND :EventQueue.Event = $eventid");
    $result = execute_query($query);

    $retValue = (mysql_num_rows($result) > 0);
    mysql_free_result($result);

    return $retValue;
}
