<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'data/db.php';
require_once 'data/player.php';
require_once 'core/player.php';
require_once 'core/user.php';
require_once 'core/email.php';
require_once 'core/rules.php';


/* Return event's queue counts by class */
function GetEventQueueCounts($eventid)
{
    $eventid = esc_or_null($eventid, 'int');

    $result = db_all("SELECT COUNT(*) AS cnt, Classification
                           FROM :EventQueue
                           WHERE Event = $eventid
                           GROUP BY Classification");

    $retValue = array();
    foreach ($result as $row) {
        $class = $row['Classification'];
        $retValue[$class] = $row['cnt'];
    }

    return $retValue;
}


// FIXME: Redo to a simpler form sometime
function GetEventQueue($eventid, $strategy = '', $search = '')
{
    $eventid = esc_or_null($eventid, 'int');
    $where = data_ProduceSearchConditions($search, array('FirstName', 'LastName', 'pdga', 'Username', 'birthdate'));

    $sortedby = 'SignupTimestamp ASC';
    if ($strategy == 'rating')
        $sortedby = 'Rating DESC, PDGANumber ASC';

    $result = db_all("SELECT :User.id AS UserId, Username, Role, UserFirstName, UserLastName, UserEmail,
                        :Player.firstname AS pFN, :Player.lastname AS pLN, :Player.email AS pEM, :Player.player_id AS PlayerId,
                        pdga AS PDGANumber, Sex, YEAR(birthdate) AS YearOfBirth,
                        :Classification.Name AS ClassName, :Classification.Short AS ClassShort,
                        :EventQueue.id AS QueueId, :EventQueue.Rating AS Rating,
                        :Club.ShortName AS ClubName, :Club.Name AS ClubLongName,
                        UNIX_TIMESTAMP(SignupTimestamp) AS SignupTimestamp, :Classification.id AS ClassId
                    FROM :User
                    INNER JOIN :Player ON :Player.player_id = :User.Player
                    INNER JOIN :EventQueue ON (:EventQueue.Player = :Player.player_id AND :EventQueue.Event = $eventid)
                    INNER JOIN :Classification ON :EventQueue.Classification = :Classification.id
                    LEFT JOIN :Club ON :User.Club = :Club.id
                    WHERE $where
                    ORDER BY $sortedby, :EventQueue.id ASC");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    foreach ($result as $row) {
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
        $pdata['classShort'] = $row['ClassShort'];
        $pdata['classId'] = $row['ClassId'];
        $pdata['clubName'] = $row['ClubName'];
        $pdata['clubLongName'] = $row['ClubLongName'];
        $pdata['rating'] = $row['Rating'];

        $retValue[] = $pdata;
    }

    if ($strategy == 'random')
        shuffle($retValue);

    return $retValue;
}


// Get events queue promotion strategy
function GetQueuePromotionStrategy($eventid)
{
    $eventid = esc_or_null($eventid, 'int');
    $row = db_one("SELECT QueueStrategy FROM :Event WHERE id = $eventid");

    if (db_is_error($row))
        return null;

    return $row['QueueStrategy'];
}


// Check if we can raise players from queue after someone left
function CheckQueueForPromotions($eventid)
{
    $strategy = GetQueuePromotionStrategy($eventid);
    $queuers = GetEventQueue($eventid, $strategy);

    foreach ($queuers as $queuer) {
        $playerid = (int) $queuer['player']->id;
        $classid = (int) $queuer['classId'];

        $quota_ok = CheckSignupQuota($eventid, $playerid, $classid);
        $rules_ok = CheckEventRules($eventid, $classid, $playerid) === true ? true : false;

        if ($quota_ok && $rules_ok)
            PromotePlayerFromQueue($eventid, $playerid);
    }

    return null;
}


// Check if this queuer can be promoted
function PromotionToEventOK($eventid, $queuer)
{
    $playerid = (int) $queuer['player']->id;
    $classid = (int) $queuer['classId'];

    $quota_ok = CheckSignupQuota($eventid, $playerid, $classid);
    $rules_ok = CheckEventRules($eventid, $classid, $playerid) === true ? true : false;

    return ($quota_ok && $rules_ok);
}


// Raise competitor from queue to the event
function PromotePlayerFromQueue($eventid, $playerid)
{
    $eid = esc_or_null($eventid, 'int');
    $pid = esc_or_null($playerid, 'int');
    $row = db_one("SELECT * FROM :EventQueue WHERE Player = $pid AND Event = $eid");

    if (db_is_error($row))
        return $row;

    if (empty($row))
        return null;

    // Insert into competition
    $player = (int) $row['Player'];
    $event = (int) $row['Event'];
    $class = (int) $row['Classification'];
    $user = GetPlayerUser($player);
    $userid = $user ? $user->id : null;

    // cancel player from both queue/competition and set it again
    CancelSignup($eventid, $playerid, false);
    SetPlayerParticipation($player, $event, $class, true);

    if ($user !== null)
        SendEmail(EMAIL_PROMOTED_FROM_QUEUE, $user->id, GetEventDetails($eventid));

    return null;
}


function UserQueueing($eventid, $userid)
{
    $eventid = esc_or_null($eventid);
    $userid = esc_or_null($userid);

    $row = db_one("SELECT :EventQueue.id AS id
                            FROM :EventQueue
                            INNER JOIN :Player ON :EventQueue.Player = :Player.player_id
                            INNER JOIN :User ON :User.Player = :Player.player_id
                            WHERE :User.id = $userid AND :EventQueue.Event = $eventid");

    return count($row);
}


function PlayerQueueing($eventid, $playerid)
{
    $eventid = esc_or_null($eventid);
    $playerid = esc_or_null($playerid);

    return db_one("SELECT :EventQueue.id AS id FROM :EventQueue WHERE Player = $playerid AND :EventQueue.Event = $eventid");
}
