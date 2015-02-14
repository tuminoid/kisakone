<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Event
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
require_once 'data/venue.php';
require_once 'data/event_quota.php';
require_once 'data/class.php';
require_once 'data/club.php';

require_once 'core/sort.php';
require_once 'core/classification.php';
require_once 'core/round.php';
require_once 'core/event_official.php';
require_once 'core/player.php';
require_once 'core/user.php';
require_once 'core/hole.php';


// Gets an array of Event objects where the conditions match
function data_GetEvents($conditions, $sort_mode = null)
{
    global $event_sort_mode;

    if ($sort_mode !== null)
        $sort = "`$sort_mode`";
    elseif (!$event_sort_mode)
        $sort = "`Date`";
    else
        $sort = data_CreateSortOrder($event_sort_mode, array('Name', 'VenueName' => 'Venue', 'Date', 'LevelName'));

    global $user;
    if ($user && $user->id) {
        $uid = $user->id;

        $player = $user->GetPlayer();
        if (is_a($player, 'Error'))
            return $player;
        $playerid = $player ? $player->id : - 1;

        $query = format_query("SELECT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament,
                                    Level, :Event.Name, UNIX_TIMESTAMP(Date) AS Date, Duration,
                                    UNIX_TIMESTAMP(ActivationDate) AS ActivationDate, UNIX_TIMESTAMP(SignupStart) AS SignupStart,
                                    UNIX_TIMESTAMP(SignupEnd) AS SignupEnd, ResultsLocked,
                                    :Level.Name AS LevelName, :EventManagement.Role AS Management, :Participation.Approved,
                                    :Participation.EventFeePaid, :Participation.Standing
                                FROM :Event
                                LEFT JOIN :EventManagement ON (:Event.id = :EventManagement.Event AND :EventManagement.User = $uid)
                                LEFT JOIN :Participation ON (:Participation.Event = :Event.id AND :Participation.Player = $playerid)
                                LEFT JOIN :Level ON :Event.Level = :Level.id
                                INNER Join :Venue ON :Venue.id = :Event.Venue
                                WHERE $conditions
                                ORDER BY $sort");
    }
    else {
        $query = format_query("SELECT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament,
                                    Level, :Event.Name, UNIX_TIMESTAMP(Date) AS Date, Duration,
                                    UNIX_TIMESTAMP(ActivationDate) AS ActivationDate, UNIX_TIMESTAMP(SignupStart) AS SignupStart,
                                    UNIX_TIMESTAMP(SignupEnd) AS SignupEnd, ResultsLocked, :Level.Name AS LevelName
                                FROM :Event
                                INNER Join :Venue ON :Venue.id = :Event.Venue
                                LEFT JOIN :Level ON :Event.Level = :Level.id
                                WHERE $conditions
                                ORDER BY $sort");
    }
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = new Event($row);
    }
    mysql_free_result($result);

    return $retValue;
}


// Gets an Event object by ID or null if the event was not found
// FIXME: handle user differently
function GetEventDetails($eventid)
{
    if (empty($eventid))
        return null;

    $id = (int) $eventid;

    global $user;
    if ($user && $user->id) {
        $uid = $user->id;

        $player = $user->GetPlayer();
        $pid = $player ? $player->id : - 1;

        $query = format_query("SELECT DISTINCT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament,
                                    :Event.Name, ContactInfo, UNIX_TIMESTAMP(Date) AS Date, Duration, PlayerLimit,
                                    UNIX_TIMESTAMP(ActivationDate) AS ActivationDate, UNIX_TIMESTAMP(SignupStart) AS SignupStart,
                                    UNIX_TIMESTAMP(SignupEnd) AS SignupEnd, ResultsLocked, PdgaEventId,
                                    :EventManagement.Role AS Management, :Participation.Approved, :Participation.EventFeePaid,
                                    :Participation.Standing, :Level.id AS LevelId,
                                    :Level.Name AS Level, :Tournament.id AS TournamentId, :Tournament.Name AS Tournament,
                                    :Participation.SignupTimestamp
                                FROM :Event
                                LEFT JOIN :EventManagement ON (:Event.id = :EventManagement.Event AND :EventManagement.User = $uid)
                                LEFT JOIN :Participation ON (:Participation.Event = :Event.id AND :Participation.Player = $pid)
                                LEFT Join :Venue ON :Venue.id = :Event.Venue
                                LEFT JOIN :Level ON :Level.id = :Event.Level
                                LEFT JOIN :Tournament ON :Tournament.id = :Event.Tournament
                                WHERE :Event.id = $id");
    }
    else {
        $query = format_query("SELECT DISTINCT :Event.id id, :Venue.Name AS Venue, Tournament, :Event.Name,
                                    UNIX_TIMESTAMP(Date) AS Date, Duration, PlayerLimit,
                                    UNIX_TIMESTAMP(ActivationDate) AS ActivationDate, ContactInfo,
                                    UNIX_TIMESTAMP(SignupStart) AS SignupStart, UNIX_TIMESTAMP(SignupEnd) AS SignupEnd,
                                    ResultsLocked, PdgaEventId, :Level.id AS LevelId, :Level.Name AS Level,
                                    :Tournament.id AS TournamentId, :Tournament.Name AS Tournament
                                FROM :Event
                                LEFT JOIN :Level ON :Level.id = :Event.Level
                                LEFT JOIN :Tournament ON :Tournament.id = :Event.Tournament
                                LEFT Join :Venue ON :Venue.id = :Event.Venue
                                WHERE :Event.id = $id");
    }
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1)
        $retValue = new Event(mysql_fetch_assoc($result));
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
    $signup_start, $signup_end, $classes, $td, $officials, $requireFees, $pdgaid)
{
    $venue = esc_or_null($venue, 'int');
    $tournament = esc_or_null($tournament, 'int');
    $level = esc_or_null($level, 'int');
    $name = esc_or_null($name);
    $start = (int) $start;
    $duration = (int) $duration;
    $playerlimit = (int) $playerlimit;
    $signup_start = esc_or_null($signup_start, 'int');
    $signup_end = esc_or_null($signup_end, 'int');
    $contact = esc_or_null($contact);
    $requireFees = (int) $requireFees;
    $pdgaid = esc_or_null($pdgaid, 'int');

    $query = format_query("INSERT INTO :Event (Venue, Tournament, Level, Name, Date, Duration, PlayerLimit,
                                SignupStart, SignupEnd, ContactInfo, FeesRequired, PdgaEventId)
                            VALUES ($venue, $tournament, $level, $name, FROM_UNIXTIME($start), $duration, $playerlimit,
                                FROM_UNIXTIME($signup_start), FROM_UNIXTIME($signup_end), $contact, $requireFees, $pdgaid)");
    $result = execute_query($query);

    $retValue = null;
    if ($result) {
        $eventid = mysql_insert_id();

        $retValue = SetClasses($eventid, $classes);
        if (!is_a($retValue, 'Error'))
            $retValue = SetTD($eventid, $td);
        if (!is_a($retValue, 'Error'))
            $retValue = SetOfficials($eventid, $officials);
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

    return data_GetEvents("Date BETWEEN FROM_UNIXTIME($start) AND FROM_UNIXTIME($end)");
}


// Get all Classifications in an Event
function GetEventClasses($event)
{
    $event = (int) $event;

    $query = format_query("SELECT :Classification.id, Name, MinimumAge, MaximumAge, GenderRequirement, Available
                            FROM :Classification, :ClassInEvent
                            WHERE :ClassInEvent.Classification = :Classification.id AND :ClassInEvent.Event = $event
                            ORDER BY Name");
    $result = execute_query($query);

    $retValue = array();
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
    $event = (int) $event;

    $query = format_query("SELECT id, Event, Course, StartType, UNIX_TIMESTAMP(StartTime) AS StartTime,
                                `Interval`, ValidResults, GroupsFinished
                            FROM :Round
                            WHERE Event = $event
                            ORDER BY StartTime");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        $index = 1;
        while ($row = mysql_fetch_assoc($result)) {
            $newRound =  new Round($row['id'], $row['Event'], $row['StartType'],
                $row['StartTime'], $row['Interval'], $row['ValidResults'],
                0, $row['Course'], $row['GroupsFinished']);
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
    $event = (int) $event;

    $query = format_query("SELECT :User.id as UserId, Username, UserEmail, :EventManagement.Role, UserFirstname, UserLastname, Event,
                                :Player.firstname AS pFN, :Player.lastname AS pLN, :Player.email AS pEM, Player
                            FROM :EventManagement, :User
                            LEFT JOIN :Player ON :User.Player = :Player.player_id
                            WHERE :EventManagement.User = :User.id AND :EventManagement.Event = $event
                            ORDER BY :EventManagement.Role DESC, Username ASC");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            $tempuser = new User($row['UserId'], $row['Username'], $row['Role'],
                                    data_GetOne($row['UserFirstname'], $row['pFN']),
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
function EditEvent($eventid, $name, $venuename, $duration, $playerlimit, $contact, $tournament,
    $level, $start, $signup_start, $signup_end, $state, $requireFees, $pdgaid)
{
    $venueid = GetVenueId($venuename);
    $activation = ($state == 'active' || $state == 'done') ? time() : 'NULL';
    $locking = ($state == 'done') ? time() : 'NULL';
    $tournament = esc_or_null($tournament, 'int');
    $level = esc_or_null($level, 'int');
    $name = esc_or_null($name);
    $start = (int) $start;
    $duration = (int) $duration;
    $playerlimit = (int) $playerlimit;
    $signup_start = esc_or_null($signup_start, 'int');
    $signup_end = esc_or_null($signup_end, 'int');
    $contact = esc_or_null($contact);
    $requireFees = (int) $requireFees;
    $eventid = (int) $eventid;
    $pdgaid = esc_or_null($pdgaid, 'int');

    $query = format_query("UPDATE :Event
                            SET Venue = $venueid, Tournament = $tournament, Level = $level, Name = $name, Date = FROM_UNIXTIME($start),
                                Duration = $duration, PlayerLimit = $playerlimit,
                                SignupStart = FROM_UNIXTIME($signup_start), SignupEnd = FROM_UNIXTIME($signup_end),
                                ActivationDate = FROM_UNIXTIME($activation), ResultsLocked = FROM_UNIXTIME($locking),
                                ContactInfo = $contact, FeesRequired = $requireFees, PdgaEventId = $pdgaid
                            WHERE id = $eventid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}


/**
 * Function for setting the tournament director for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the TD.
 */
function SetTD($eventid, $td)
{
    if (!isset($eventid) or !isset($td))
        return Error::InternalError("Event id or td argument is not set.");

    $eventid = (int) $eventid;
    $id = (int) $td;
    $role = esc_or_null('td');

    execute_query(format_query("DELETE FROM :EventManagement WHERE Event = $eventid AND Role = $role"));

    $query = format_query("INSERT INTO :EventManagement (User, Event, Role) VALUES ($td, $eventid, $role)");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
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
    $role = esc_or_null('official');

    if (!isset($eventid))
        return Error::InternalError("Event id argument is not set.");

    execute_query(format_query("DELETE FROM :EventManagement WHERE Event = $eventid AND Role = $role"));

    foreach ($officials as $official) {
        $official = (int) $official;

        $query = format_query("INSERT INTO :EventManagement (User, Event, Role) VALUES ($official, $eventid, $role)");
        $result = execute_query($query);

        if (!$result)
            return Error::Query($query);
    }
}


// Cancels a players signup for an event
function CancelSignup($eventId, $playerId, $check_promotion = true)
{
    $eventId = (int) $eventId;
    $playerId = (int) $playerId;

    // Delete from event and queue
    execute_query(format_query("DELETE FROM :Participation WHERE Player = $playerId AND Event = $eventId"));
    execute_query(format_query("DELETE FROM :EventQueue WHERE Player = $playerId AND Event = $eventId"));

    if ($check_promotion === false)
        return null;

    // Check if we can lift someone into competition
    return CheckQueueForPromotions($eventId);
}


function GetEventsByYear($year)
{
    $year = (int) $year;
    $start = mktime(0, 0, 0, 1, 1, $year);
    $end = mktime(0, 0, 0, 12, 31, $year);

    return GetEventsByDate($start, $end);
}


function GetEventYears()
{
    $query = format_query("SELECT DISTINCT(YEAR(Date)) AS year FROM :Event ORDER BY YEAR(Date) ASC");
    $result = execute_query($query);

    $retValue = array();
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

    $query = format_query("SELECT COUNT(*) AS cnt, Classification
                              FROM :Participation
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

    return $retValue;
}


function GetEventParticipants($eventId, $sortedBy, $search)
{
    $eventId = (int) $eventId;
    $sortOrder = data_CreateSortOrder($sortedBy,
        array('name' => array('LastName', 'FirstName'), 'class' => 'ClassName',
            'LastName' => true, 'FirstName' => true, 'birthyear' => 'YEAR(birthdate)', 'pdga', 'gender' => 'sex', 'Username'));

    if (is_a($sortOrder, 'Error'))
        return $sortOrder;

    if ($sortOrder == 1)
        $sortOrder = " LastName, FirstName";
    $where = data_ProduceSearchConditions($search, array('FirstName', 'LastName', 'pdga', 'Username', 'birthdate'));

    $query = "SELECT :User.id AS UserId, Username, Role, UserFirstName, UserLastName,
                    UserEmail, :Player.firstname AS pFN, :Player.lastname AS pLN, :Player.email AS pEM,
                    :Player.player_id AS PlayerId, pdga AS PDGANumber, Sex, YEAR(birthdate) AS YearOfBirth,
                    :Classification.Name AS ClassName, :Participation.id AS ParticipationID,
                    UNIX_TIMESTAMP(EventFeePaid) AS EventFeePaid, UNIX_TIMESTAMP(SignupTimestamp) AS SignupTimestamp,
                    :Classification.id AS ClassId, :Club.ShortName AS ClubName, :Participation.Rating,
                    :PDGAPlayers.country AS PDGACountry
                FROM :User
                INNER JOIN :Player ON :Player.player_id = :User.Player
                INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = $eventId)
                INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                LEFT JOIN :Club ON :Participation.Club = :Club.id
                LEFT JOIN :PDGAPlayers ON :Player.pdga = :PDGAPlayers.pdga_number
                WHERE $where
                ORDER BY $sortOrder";
    $query = format_query($query);
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

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
            $pdata['eventFeePaid'] = $row['EventFeePaid'];
            $pdata['participationId'] = $row['ParticipationID'];
            $pdata['signupTimestamp'] = $row['SignupTimestamp'];
            $pdata['className'] = $row['ClassName'];
            $pdata['classId'] = $row['ClassId'];
            $pdata['clubName'] = $row['ClubName'];
            $pdata['rating'] = $row['Rating'];
            $pdata['PDGACountry'] = $row['PDGACountry'];

            $retValue[] = $pdata;
        }
    }
    mysql_free_result($result);

    return $retValue;
}


function GetEventHoles($eventId)
{
    $eventId = (int) $eventId;

    $query = format_query("SELECT :Hole.id, :Hole.Course, HoleNumber, HoleText, Par, Length, :Round.id AS Round
                            FROM :Hole
                            INNER JOIN :Course ON :Course.id = :Hole.Course
                            INNER JOIN :Round ON :Round.Course = :Course.id
                            INNER JOIN :Event ON :Round.Event = :Event.id
                            WHERE :Event.id = $eventId
                            ORDER BY :Round.StartTime, HoleNumber");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = new Hole($row);
    }
    mysql_free_result($result);

    return $retValue;
}


function GetEventResults($eventId)
{
    $eventId = (int) $eventId;

    $query = "SELECT :Participation.*, player_id AS PlayerId, :Player.firstname AS FirstName, :Player.lastname AS LastName,
                    :Player.pdga AS PDGANumber, :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                    :StartingOrder.GroupNumber, (:HoleResult.Result - :Hole.Par) AS Plusminus,
                    :HoleResult.Result AS HoleResult, :Hole.id AS HoleId, :Hole.HoleNumber,
                    :Classification.Name AS ClassName, TournamentPoints, :Round.id AS RoundId,
                    :Participation.Standing, :Club.ShortName AS ClubName, :RoundResult.DidNotFinish AS DNF
                FROM :Round
                INNER JOIN :Event ON :Round.Event = :Event.id
                INNER JOIN :Section ON :Section.Round = :Round.id
                INNER JOIN :StartingOrder ON :StartingOrder.Section = :Section.id
                LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                LEFT JOIN :HoleResult ON (:HoleResult.RoundResult = :RoundResult.id AND :HoleResult.Player = :StartingOrder.Player)
                LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
                LEFT JOIN :Participation ON (:Participation.Event = $eventId AND :Participation.Player = :Player.player_id)
                LEFT JOIN :Classification ON :Participation.Classification = :Classification.id
                LEFT JOIN :User ON :Player.player_id = :User.Player
                LEFT JOIN :Hole ON :HoleResult.Hole = :Hole.id
                LEFT JOIN :Club ON :Participation.Club = :Club.id
                WHERE :Event.id = $eventId AND :Section.Present
                ORDER BY :Participation.Standing, player_id, :Round.StartTime, :Hole.HoleNumber";
    $query = format_query($query);
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = array();
    $penalties = array();
    if (mysql_num_rows($result) > 0) {
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
                $lastrow['Results'][$row['RoundId'] . '_' . $row['HoleNumber']] =
                    array('Hole' => $row['HoleNumber'], 'HoleId' => $row['HoleId'], 'Result' => $row['HoleResult']);
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
    $eventId = (int) $eventId;

    $query = "SELECT :Participation.*, player_id AS PlayerId, :Player.firstname AS FirstName,
                    :Player.lastname AS LastName, :Player.pdga AS PDGANumber,
                    :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                    :StartingOrder.GroupNumber, CumulativePlusminus, Completed,
                    :Classification.Name AS ClassName, PlusMinus, :StartingOrder.id AS StartId,
                    TournamentPoints, :Round.id AS RoundId, :Participation.Standing,
                    :Club.ShortName AS ClubName, :RoundResult.DidNotFinish AS DNF,
                    :PDGAPlayers.country AS PDGACountry
                FROM :Round
                INNER JOIN :Event ON :Round.Event = :Event.id
                INNER JOIN :Section ON :Section.Round = :Round.id
                INNER JOIN :StartingOrder ON :StartingOrder.Section = :Section.id
                LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
                LEFT JOIN :Participation ON (:Participation.Event = $eventId AND :Participation.Player = :Player.player_id)
                LEFT JOIN :Classification ON :Participation.Classification = :Classification.id
                LEFT JOIN :User ON :Player.player_id = :User.Player
                LEFT JOIN :Club ON :Participation.Club = :Club.id
                LEFT JOIN :PDGAPlayers ON :Player.pdga = :PDGAPlayers.pdga_number
                WHERE :Event.id = $eventId AND :Section.Present
                ORDER BY :Participation.Standing, player_id, :Round.StartTime";

    $query = format_query($query);
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = array();
    $penalties = array();
    if (mysql_num_rows($result) > 0) {
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
    $words = array_map('escape_string', $words);
    $wordSpecificBits = array();

    if (!count($words))
        return "1";

    foreach ($words as $word) {
        $fieldSpecificBits = array();
        foreach ($fields as $field) {
            $field = str_replace('.', '`.`', $field);
            $fieldSpecificBits[] = "(`$field` LIKE '%$word%')";
        }
        $wordSpecificBits[] = '(' . implode(' OR ', $fieldSpecificBits) . ')';
    }

    return '(' . implode(' AND ', $wordSpecificBits) . ')';
}


function GetAllRoundResults($eventid)
{
    $query = format_query("SELECT :RoundResult.id, Round, Result, Penalty, SuddenDeath, Completed, Player, PlusMinus, DidNotFinish
                            FROM :RoundResult
                            INNER JOIN :Round ON :Round.id = :RoundResult.Round
                            WHERE :Round.Event = $eventid");
    $result = execute_query($query);

    $retValue = array();
    if ($result) {
        while (($row = mysql_fetch_assoc($result)) !== false)
            $retValue[] = $row;
    }
    mysql_free_result($result);

    return $retValue;
}


function GetAllParticipations($eventid)
{
    $eventid = (int) $eventid;

    $query = format_query("SELECT Classification, :Classification.Name,
                                :Participation.Player, :Participation.id,
                                :Participation.Standing, :Participation.DidNotFinish,
                                :Participation.TournamentPoints, :Participation.OverallResult
                            FROM :Participation
                            INNER JOIN :Classification ON :Classification.id = :Participation.Classification
                            WHERE Event = $eventid AND EventFeePaid IS NOT NULL");
    $result = execute_query($query);

    $retValue = array();
    if ($result) {
        while (($row = mysql_fetch_assoc($result)) !== false)
            $retValue[] = $row;
    }
    mysql_free_result($result);

    return $retValue;
}


function SaveParticipationResults($entry)
{
    $overall = $entry['OverallResult'];
    $standing = $entry['Standing'];
    $dnf = $entry['DidNotFinish'];
    $points = esc_or_null($entry['TournamentPoints'], 'int');
    $id = $entry['id'];

    $query = format_query("UPDATE :Participation
                            SET OverallResult = $overall, Standing = $standing, DidNotFinish = $dnf, TournamentPoints = $points
                            WHERE id = $id");
    execute_query($query);
}


function UserParticipating($eventid, $userid)
{
    $eventid = (int) $eventid;
    $userid = (int) $userid;

    $query = format_query("SELECT :Participation.id
                            FROM :Participation
                            INNER JOIN :Player ON :Participation.Player = :Player.player_id
                            INNER JOIN :User ON :User.Player = :Player.player_id
                            WHERE :User.id = $userid AND :Participation.Event = $eventid");
    $result = execute_query($query);

    $retValue = (mysql_num_rows($result) > 0);
    mysql_free_result($result);

    return $retValue;
}


function GetAllToRemind($eventid)
{
    $eventid = (int) $eventid;

    $query = format_query("SELECT :User.id
                            FROM :User
                            INNER JOIN :Player ON :User.Player = :Player.player_id
                            INNER JOIN :Participation ON :Player.player_id = :Participation.Player
                            WHERE :Participation.Event = $eventid AND :Participation.EventFeePaid IS NULL");
    $result = execute_query($query);

    $retValue = array();
    if ($result) {
        while (($row = mysql_fetch_assoc($result)) !== false)
            $retValue[] = $row['id'];
    }
    mysql_free_result($result);

    return $retValue;
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
                return Error::NotImplemented();
            }
        }

        if ($field === true)
            $field = $bit;

        if (is_array($field)) {
            if (!$ascending)
                foreach ($field as $k => $v)
                    $field[$k] = "-" . $v;
            $bits[$index] = implode(',', $field);
            $newbits = implode(',', $bits);

            return data_CreateSortOrder($newbits, $fields);
        }

        if ($field[0] == '-')
            $ascending = !$ascending;

        if (strpos($field, "(") !== false)
            $out[] = $field . ' ' . ($ascending ? '' : ' DESC');
        else
            $out[] = '`' . escape_string($field) . '`' . ($ascending ? '' : ' DESC');
    }

    return implode(', ', $out);
}


function data_FinalizeResultSort($roundid, $data)
{
    $needMoreInfoOn = array();

    foreach ($data as $results) {
        $lastRes = - 1;
        $lastPlayer = - 1;
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

    $query = "SELECT :Round.id RoundId, :StartingOrder.id AS StartId, :RoundResult.Result, :StartingOrder.Player
                FROM :Round LinkRound
                INNER JOIN :Round ON :Round.Event = LinkRound.Event
                INNER JOIN :Section ON :Section.Round = :Round.id
                INNER JOIN :StartingOrder ON :StartingOrder.Section = :Section.id
                INNER JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                WHERE :StartingOrder.Player IN ($ids) AND :Round.id <= $roundid AND LinkRound.id = $roundid
                ORDER BY :Round.StartTime, :StartingOrder.Player";
    $query = format_query($query);
    $result = execute_query($query);

    $retValue = array();
    while (($row = mysql_fetch_assoc($result)) !== false) {
        if (!isset($retValue[$row['RoundId']]))
            $retValue[$row['RoundId']] = array();
        $retValue[$row['RoundId']][$row['Player']] = $row;
    }
    mysql_free_result($result);

    return array_reverse($retValue);
}


function GetRegisteringEvents()
{
    $now = time();

    return data_GetEvents("SignupStart < FROM_UNIXTIME($now) AND SignupEnd > FROM_UNIXTIME($now)", "SignupEnd");
}


function GetRegisteringSoonEvents()
{
    $now = time();
    $twoweeks = time() + 21 * 24 * 60 * 60;

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
    $id = (int) $event->id;

    $queries = array();
    $queries[] = format_query("DELETE FROM :AdBanner WHERE Event = $id");
    $queries[] = format_query("DELETE FROM :EventQueue WHERE Event = $id");
    $queries[] = format_query("DELETE FROM :ClassInEvent WHERE Event = $id");
    $queries[] = format_query("DELETE FROM :EventManagement WHERE Event = $id");

    $rounds = $event->GetRounds();
    foreach ($rounds as $round) {
        $rid = $round->id;
        $sections = GetSections($rid);

        foreach ($sections as $section) {
            $sid = (int) $section->id;

            $queries[] = format_query("DELETE FROM :SectionMembership WHERE Section = $sid");
            $queries[] = format_query("DELETE FROM :StartingOrder WHERE Section = $sid");
        }
        $queries[] = format_query("DELETE FROM :Section WHERE Round = $rid");

        $query = format_query("SELECT id FROM :RoundResult WHERE Round = $rid");
        $result = execute_query($query);

        if (mysql_num_rows($result) > 0) {
            while (($row = mysql_fetch_assoc($result)) !== false) {
                $hid = $row['id'];
                $queries[] = format_query("DELETE FROM :HoleResult WHERE RoundResult = $hid");
            }
        }
        mysql_free_result($result);

        $queries[] = format_query("DELETE FROM :RoundResult WHERE Round = $rid");
    }

    $queries[] = format_query("DELETE FROM :Round WHERE Event = $id");
    $queries[] = format_query("DELETE FROM :TextContent WHERE Event = $id");
    $queries[] = format_query("DELETE FROM :Participation WHERE Event = $id");
    $queries[] = format_query("DELETE FROM :Event WHERE id = $id");

    foreach ($queries as $query)
        execute_query($query);
}
