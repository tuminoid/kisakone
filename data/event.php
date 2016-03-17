<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'data/db.php';
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
function data_GetEvents($conditions, $sort_mode = null, $limit = null)
{
    global $event_sort_mode;

    if ($sort_mode !== null)
        $sort = "$sort_mode";
    elseif (!$event_sort_mode)
        $sort = "`Date`, Duration ASC, :Event.id ASC";
    else
        $sort = data_CreateSortOrder($event_sort_mode, array('Name', 'VenueName' => 'Venue', 'Date', 'LevelName'));

    $limit_limit = ($limit ? "LIMIT " . (int) $limit : "");

    global $user;
    if ($user && $user->id) {
        $uid = $user->id;

        $player = $user->GetPlayer();
        if (is_a($player, 'Error'))
            return $player;
        $playerid = $player ? $player->id : - 1;

        $result = db_all("SELECT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament, :Event.Club AS Club,
                                    Level, :Event.Name, UNIX_TIMESTAMP(Date) AS Date, Duration,
                                    UNIX_TIMESTAMP(ActivationDate) AS ActivationDate, UNIX_TIMESTAMP(SignupStart) AS SignupStart,
                                    UNIX_TIMESTAMP(SignupEnd) AS SignupEnd, ResultsLocked,
                                    :Level.Name AS LevelName, :EventManagement.Role AS Management, :Participation.Approved,
                                    :Participation.EventFeePaid, :Participation.Standing,
                                    (SELECT PaymentEnabled FROM :Config) AS PaymentEnabled
                                FROM :Event
                                LEFT JOIN :EventManagement ON (:Event.id = :EventManagement.Event AND :EventManagement.User = $uid)
                                LEFT JOIN :Participation ON (:Participation.Event = :Event.id AND :Participation.Player = $playerid)
                                LEFT JOIN :Level ON :Event.Level = :Level.id
                                INNER Join :Venue ON :Venue.id = :Event.Venue
                                WHERE $conditions
                                ORDER BY $sort
                                $limit_limit");
    }
    else {
        $result = db_all("SELECT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament, Club,
                                    Level, :Event.Name, UNIX_TIMESTAMP(Date) AS Date, Duration,
                                    UNIX_TIMESTAMP(ActivationDate) AS ActivationDate, UNIX_TIMESTAMP(SignupStart) AS SignupStart,
                                    UNIX_TIMESTAMP(SignupEnd) AS SignupEnd, ResultsLocked, :Level.Name AS LevelName
                                FROM :Event
                                INNER Join :Venue ON :Venue.id = :Event.Venue
                                LEFT JOIN :Level ON :Event.Level = :Level.id
                                WHERE $conditions
                                ORDER BY $sort
                                $limit_limit");
    }

    if (db_is_error($result))
        return $result;

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new Event($row);
    return $retValue;
}


// Gets an Event object by ID or null if the event was not found
// FIXME: handle user differently
function GetEventDetails($eventid)
{
    $id = esc_or_null($eventid, 'int');

    global $user;
    if ($user && $user->id) {
        $uid = $user->id;

        $player = $user->GetPlayer();
        $pid = $player ? $player->id : - 1;

        $row = db_one("SELECT DISTINCT :Event.id AS id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament,
                                    :Event.Name, ContactInfo, UNIX_TIMESTAMP(Date) AS Date, Duration, PlayerLimit, :Event.Club AS Club,
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
        $row = db_one("SELECT DISTINCT :Event.id AS id, :Venue.Name AS Venue, Tournament, :Event.Name,
                                    UNIX_TIMESTAMP(Date) AS Date, Duration, PlayerLimit, Club,
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

    if (db_is_error($row))
        return $row;

    return new Event($row);
}


/**
 * Function for creating a new event
 *
 * Returns the new event id for success or
 * an Error in case there was an error in creating a new event.
 */
function CreateEvent($name, $club, $venue, $duration, $playerlimit, $contact, $tournament, $level, $start,
    $signup_start, $signup_end, $classes, $td, $officials, $requireFees, $pdgaid)
{
    $venue = esc_or_null($venue, 'int');
    $tournament = esc_or_null($tournament ? $tournament : null, 'int');
    $level = esc_or_null($level ? $level : null, 'int');
    $name = esc_or_null($name, 'string');
    $start = esc_or_null($start, 'int');
    $duration = esc_or_null($duration, 'int');
    $playerlimit = esc_or_null($playerlimit, 'int');
    $signup_start = esc_or_null($signup_start, 'int');
    $signup_end = esc_or_null($signup_end, 'int');
    $contact = esc_or_null($contact, 'string');
    $requireFees = esc_or_null($requireFees, 'int');
    $pdgaid = esc_or_null($pdgaid, 'int');
    $club = esc_or_null($club, 'int');

    $eventid = db_exec("INSERT INTO :Event (Club, Venue, Tournament, Level, Name, Date, Duration, PlayerLimit,
                                SignupStart, SignupEnd, ContactInfo, LicensesRequired, PdgaEventId)
                            VALUES ($club, $venue, $tournament, $level, $name, FROM_UNIXTIME($start), $duration, $playerlimit,
                                FROM_UNIXTIME($signup_start), FROM_UNIXTIME($signup_end), $contact, $requireFees, $pdgaid)");

    if (db_is_error($eventid))
        return $eventid;

    $retValue = SetEventClasses($eventid, $classes);
    if (!is_a($retValue, 'Error'))
        $retValue = SetEventTD($eventid, $td);
    if (!is_a($retValue, 'Error'))
        $retValue = SetEventOfficials($eventid, $officials);

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
    $event = esc_or_null($event, 'int');

    $result = db_all("SELECT :Classification.id, Name, Short, MinimumAge, MaximumAge,
                                GenderRequirement, Available, Status, Priority, RatingLimit
                            FROM :Classification
                            INNER JOIN :ClassInEvent ON :ClassInEvent.Classification = :Classification.id
                            WHERE :ClassInEvent.Event = $event
                            ORDER BY Priority ASC, Name");

    if (db_is_error($result))
        return array();

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new Classification($row);
    return $retValue;
}


// Get rounds for an event by event id
function GetEventRounds($event)
{
    $event = esc_or_null($event, 'int');

    $result = db_all("SELECT id, Event, Course, StartType, UNIX_TIMESTAMP(StartTime) AS StartTime,
                                `Interval`, ValidResults, GroupsFinished
                            FROM :Round
                            WHERE Event = $event
                            ORDER BY StartTime");

    if (db_is_error($result))
        return array();

    $retValue = array();
    foreach ($result as $row) {
        $newRound =  new Round($row['id'], $row['Event'], $row['StartType'],
            $row['StartTime'], $row['Interval'], $row['ValidResults'],
            0, $row['Course'], $row['GroupsFinished']);
        $newRound->roundnumber = count($retValue) + 1;
        $retValue[] = $newRound;
    }

    return $retValue;
}


// Get event officials for an event
function GetEventOfficials($event)
{
    $event = esc_or_null($event, 'int');

    $result = db_all("SELECT :User.id as UserId, Username, UserEmail, :EventManagement.Role, UserFirstname, UserLastname, Event,
                                :Player.firstname AS pFN, :Player.lastname AS pLN, :Player.email AS pEM, Player
                            FROM :EventManagement, :User
                            LEFT JOIN :Player ON :User.Player = :Player.player_id
                            WHERE :EventManagement.User = :User.id AND :EventManagement.Event = $event
                            ORDER BY :EventManagement.Role DESC, Username ASC");

    if (db_is_error($result))
        return array();

    $retValue = array();
    foreach ($result as $row) {
        $tempuser = new User($row['UserId'], $row['Username'], $row['Role'],
                                data_GetOne($row['UserFirstname'], $row['pFN']),
                                data_GetOne($row['UserLastname'], $row['pLN']),
                                data_GetOne($row['UserEmail'], $row['pEM']),
                                $row['Player']);
        $retValue[] = new EventOfficial($row['UserId'], $row['Event'], $tempuser, $row['Role']);
    }

    return $retValue;
}


// Edit event information
function EditEvent($eventid, $name, $club, $venuename, $duration, $playerlimit, $contact, $tournament,
    $level, $start, $signup_start, $signup_end, $state, $requireFees, $pdgaid)
{
    $venueid = GetVenueId($venuename);
    $activation = ($state == 'active' || $state == 'done') ? time() : 'NULL';
    $locking = ($state == 'done') ? time() : 'NULL';
    $tournament = esc_or_null($tournament ? $tournament : null, 'int');
    $level = esc_or_null($level ? $level : null, 'int');
    $name = esc_or_null($name, 'string');
    $start = esc_or_null($start, 'int');
    $duration = esc_or_null($duration, 'int');
    $playerlimit = esc_or_null($playerlimit, 'int');
    $signup_start = esc_or_null($signup_start, 'int');
    $signup_end = esc_or_null($signup_end, 'int');
    $contact = esc_or_null($contact, 'string');
    $requireFees = esc_or_null($requireFees, 'int');
    $eventid = esc_or_null($eventid, 'int');
    $pdgaid = esc_or_null($pdgaid, 'int');
    $club = esc_or_null($club, 'int');

    return db_exec("UPDATE :Event
                            SET Venue = $venueid, Tournament = $tournament, Level = $level, Name = $name, Date = FROM_UNIXTIME($start),
                                Duration = $duration, PlayerLimit = $playerlimit, Club = $club,
                                SignupStart = FROM_UNIXTIME($signup_start), SignupEnd = FROM_UNIXTIME($signup_end),
                                ActivationDate = FROM_UNIXTIME($activation), ResultsLocked = FROM_UNIXTIME($locking),
                                ContactInfo = $contact, LicensesRequired = $requireFees, PdgaEventId = $pdgaid
                            WHERE id = $eventid");
}


/**
 * Function for setting the tournament director for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the TD.
 */
function SetEventTD($eventid, $td)
{
    if (!$eventid || !$td)
        return Error::InternalError("Event id or td argument is not set.");

    $eventid = esc_or_null($eventid, 'int');
    $id = esc_or_null($td, 'int');
    $role = esc_or_null('td', 'string');

    db_exec("DELETE FROM :EventManagement WHERE Event = $eventid AND Role = $role");
    return db_exec("INSERT INTO :EventManagement (User, Event, Role) VALUES ($td, $eventid, $role)");
}


/**
 * Function for setting the officials for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the official.
 */
function SetEventOfficials($eventid, $officials)
{
    if (!$eventid)
        return Error::InternalError("Event id argument is not set.");

    $eventid = esc_or_null($eventid, 'int');
    $role = esc_or_null('official');
    db_exec("DELETE FROM :EventManagement WHERE Event = $eventid AND Role = $role");

    foreach ($officials as $official) {
        $official = esc_or_null($official, 'int');
        db_exec("INSERT INTO :EventManagement (User, Event, Role) VALUES ($official, $eventid, $role)");
    }
}


// Cancels a players signup for an event
function CancelSignup($eventid, $playerid, $check_promotion = true)
{
    $eid = esc_or_null($eventid, 'int');
    $playerid = esc_or_null($playerid, 'int');

    db_exec("DELETE FROM :SectionMembership WHERE Participation = (SELECT id FROM :Participation WHERE Player = $playerid AND Event = $eid)");
    db_exec("DELETE FROM :Participation WHERE Player = $playerid AND Event = $eid");
    db_exec("DELETE FROM :EventQueue WHERE Player = $playerid AND Event = $eid");

    // Check if we can lift someone into competition
    if ($check_promotion !== true)
        return null;

    return CheckQueueForPromotions($eventid);
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
    $result = db_all("SELECT DISTINCT(YEAR(Date)) AS year FROM :Event ORDER BY YEAR(Date) ASC");

    if (db_is_error($result))
        return array();

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = $row['year'];
    return $retValue;
}


/* Return event's participant counts by class */
function GetEventParticipantCounts($eventid)
{
    $eventid = esc_or_null($eventid, 'int');

    $result = db_all("SELECT COUNT(*) AS cnt, Classification
                              FROM :Participation
                              WHERE Event = $eventid
                              GROUP BY Classification");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    foreach ($result as $row) {
        $class = $row['Classification'];
        $retValue[$class] = $row['cnt'];
    }
    return $retValue;
}


function GetEventParticipants($eventid, $sortedBy = '', $search = '')
{
    $eventid = esc_or_null($eventid, 'int');

    $sortOrder = data_CreateSortOrder($sortedBy,
        array('name' => array('LastName', 'FirstName'), 'class' => 'ClassName',
            'LastName' => true, 'FirstName' => true, 'birthyear' => 'YEAR(birthdate)', 'pdga', 'gender' => 'sex', 'Username'));

    if (is_a($sortOrder, 'Error'))
        return $sortOrder;

    if ($sortOrder == 1)
        $sortOrder = " LastName, FirstName";
    $where = data_ProduceSearchConditions($search, array('FirstName', 'LastName', 'pdga', 'Username', 'birthdate'));

    $result = db_all("SELECT :User.id AS UserId, Username, Role, UserFirstName, UserLastName,
                    UserEmail, :Player.firstname AS pFN, :Player.lastname AS pLN, :Player.email AS pEM,
                    :Player.player_id AS PlayerId, pdga AS PDGANumber, Sex, YEAR(birthdate) AS YearOfBirth,
                    :Classification.Name AS ClassName, :Classification.Short As ClassShort, :Participation.id AS ParticipationID,
                    UNIX_TIMESTAMP(EventFeePaid) AS EventFeePaid, UNIX_TIMESTAMP(SignupTimestamp) AS SignupTimestamp,
                    :Classification.id AS ClassId, :Club.ShortName AS ClubName, :Club.Name AS ClubLongName,
                    :Participation.Rating, :PDGAPlayers.country AS PDGACountry
                FROM :User
                INNER JOIN :Player ON :Player.player_id = :User.Player
                INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = $eventid)
                INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                LEFT JOIN :Club ON :Participation.Club = :Club.id
                LEFT JOIN :PDGAPlayers ON :Player.pdga = :PDGAPlayers.pdga_number
                WHERE $where
                ORDER BY $sortOrder");

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
        $pdata['eventFeePaid'] = payment_enabled() ? $row['EventFeePaid'] : true;
        $pdata['participationId'] = $row['ParticipationID'];
        $pdata['signupTimestamp'] = $row['SignupTimestamp'];
        $pdata['className'] = $row['ClassName'];
        $pdata['classShort'] = $row['ClassShort'];
        $pdata['classId'] = $row['ClassId'];
        $pdata['clubName'] = $row['ClubName'];
        $pdata['clubLongName'] = $row['ClubLongName'];
        $pdata['rating'] = $row['Rating'];
        $pdata['PDGACountry'] = $row['PDGACountry'];

        $retValue[] = $pdata;
    }

    return $retValue;
}


function GetEventHoles($eventid)
{
    $eventid = esc_or_null($eventid, 'int');

    $result = db_all("SELECT :Hole.id, :Hole.Course, HoleNumber, HoleText, Par, Length, :Round.id AS Round
                            FROM :Hole
                            INNER JOIN :Course ON :Course.id = :Hole.Course
                            INNER JOIN :Round ON :Round.Course = :Course.id
                            INNER JOIN :Event ON :Round.Event = :Event.id
                            WHERE :Event.id = $eventid
                            ORDER BY :Round.StartTime, HoleNumber");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new Hole($row);
    return $retValue;
}


function GetEventResults($eventid)
{
    $eventid = esc_or_null($eventid, 'int');

    $result = db_all("SELECT :Participation.*, player_id AS PlayerId, :Player.firstname AS FirstName, :Player.lastname AS LastName,
                            :Player.pdga AS PDGANumber, :PDGAPlayers.rating AS Rating, :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
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
                        LEFT JOIN :Participation ON (:Participation.Event = $eventid AND :Participation.Player = :Player.player_id)
                        LEFT JOIN :Classification ON :Participation.Classification = :Classification.id
                        LEFT JOIN :User ON :Player.player_id = :User.Player
                        LEFT JOIN :Hole ON :HoleResult.Hole = :Hole.id
                        LEFT JOIN :Club ON :Participation.Club = :Club.id
                        LEFT JOIN :PDGAPlayers ON :PDGAPlayers.pdga_number = :Player.pdga
                        WHERE :Event.id = $eventid AND :Section.Present
                        ORDER BY :Participation.Standing, player_id, :Round.StartTime, :Hole.HoleNumber");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    $penalties = array();
    $lastrow = null;

    foreach ($result as $row) {
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

    return $retValue;
}


function GetEventResultsWithoutHoles($eventid)
{
    $eventid = esc_or_null($eventid, 'int');

    $result = db_all("SELECT :Participation.*, player_id AS PlayerId, :Player.firstname AS FirstName,
                            :Player.lastname AS LastName, :Player.pdga AS PDGANumber,
                            :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                            :StartingOrder.GroupNumber, CumulativePlusminus, Completed,
                            :Classification.Short AS ClassName, PlusMinus, :StartingOrder.id AS StartId,
                            TournamentPoints, :Round.id AS RoundId, :Participation.Standing,
                            :Club.ShortName AS ClubName, :Club.Name AS ClubLongName,
                            :RoundResult.DidNotFinish AS DNF, :PDGAPlayers.country AS PDGACountry
                        FROM :Round
                        INNER JOIN :Event ON :Round.Event = :Event.id
                        INNER JOIN :Section ON :Section.Round = :Round.id
                        INNER JOIN :StartingOrder ON :StartingOrder.Section = :Section.id
                        LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                        LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
                        LEFT JOIN :Participation ON (:Participation.Event = $eventid AND :Participation.Player = :Player.player_id)
                        LEFT JOIN :Classification ON :Participation.Classification = :Classification.id
                        LEFT JOIN :User ON :Player.player_id = :User.Player
                        LEFT JOIN :Club ON :Participation.Club = :Club.id
                        LEFT JOIN :PDGAPlayers ON :Player.pdga = :PDGAPlayers.pdga_number
                        WHERE :Event.id = $eventid AND :Section.Present
                        ORDER BY :Participation.Standing, player_id, :Round.StartTime");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    $penalties = array();
    $lastrow = null;

    foreach ($result as $row) {
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
    $eventid = esc_or_null($eventid, 'int');

    return db_all("SELECT :RoundResult.id, Round, Result, Penalty, SuddenDeath, Completed, Player, PlusMinus, DidNotFinish
                            FROM :RoundResult
                            INNER JOIN :Round ON :Round.id = :RoundResult.Round
                            WHERE :Round.Event = $eventid");
}


function GetAllParticipations($eventid)
{
    $eventid = esc_or_null($eventid, 'int');
    $paymentEnabled = esc_or_null(payment_enabled(), 'int');

    return db_all("SELECT Classification, :Classification.Name,
                                :Participation.Player, :Participation.id,
                                :Participation.Standing, :Participation.DidNotFinish,
                                :Participation.TournamentPoints, :Participation.OverallResult
                            FROM :Participation
                            INNER JOIN :Classification ON :Classification.id = :Participation.Classification
                            WHERE Event = $eventid AND (EventFeePaid IS NOT NULL OR $paymentEnabled = 0)");
}


function SaveParticipationResults($entry)
{
    $overall = esc_or_null($entry['OverallResult'], 'int');
    $standing = esc_or_null($entry['Standing'], 'int');
    $dnf = esc_or_null($entry['DidNotFinish'], 'int');
    $points = esc_or_null($entry['TournamentPoints'], 'int');
    $id = esc_or_null($entry['id'], 'int');

    return db_exec("UPDATE :Participation
                            SET OverallResult = $overall, Standing = $standing, DidNotFinish = $dnf, TournamentPoints = $points
                            WHERE id = $id");
}


function UserParticipating($eventid, $userid)
{
    $eventid = esc_or_null($eventid, 'int');
    $userid = esc_or_null($userid, 'int');

    $row = db_one("SELECT :Participation.id
                            FROM :Participation
                            INNER JOIN :Player ON :Participation.Player = :Player.player_id
                            INNER JOIN :User ON :User.Player = :Player.player_id
                            WHERE :User.id = $userid AND :Participation.Event = $eventid");

    return count($row);
}


function GetAllToRemind($eventid)
{
    $eventid = esc_or_null($eventid, 'int');

    $result = db_all("SELECT :User.id
                            FROM :User
                            INNER JOIN :Player ON :User.Player = :Player.player_id
                            INNER JOIN :Participation ON :Player.player_id = :Participation.Player
                            WHERE :Participation.Event = $eventid AND :Participation.EventFeePaid IS NULL");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = $row['id'];
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

    $result = db_all("SELECT :Round.id RoundId, :StartingOrder.id AS StartId, :RoundResult.Result, :StartingOrder.Player
                        FROM :Round LinkRound
                        INNER JOIN :Round ON :Round.Event = LinkRound.Event
                        INNER JOIN :Section ON :Section.Round = :Round.id
                        INNER JOIN :StartingOrder ON :StartingOrder.Section = :Section.id
                        INNER JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                        WHERE :StartingOrder.Player IN ($ids) AND :Round.id <= $roundid AND LinkRound.id = $roundid
                        ORDER BY :Round.StartTime, :StartingOrder.Player");

    if (db_is_error($result))
        return array();

    $retValue = array();
    foreach ($result as $row) {
        if (!isset($retValue[$row['RoundId']]))
            $retValue[$row['RoundId']] = array();
        $retValue[$row['RoundId']][$row['Player']] = $row;
    }

    return array_reverse($retValue);
}


function GetRegisteringEvents()
{
    $now = time();

    return data_GetEvents("SignupStart < FROM_UNIXTIME($now) AND SignupEnd > FROM_UNIXTIME($now)", "SignupEnd, :Event.id ASC");
}


function GetRegisteringSoonEvents()
{
    $now = time();
    $threeweeks = time() + 21 * 24 * 60 * 60;

    return data_GetEvents("SignupStart > FROM_UNIXTIME($now) AND SignupStart < FROM_UNIXTIME($threeweeks)", "SignupStart, :Event.id ASC");
}


function GetUpcomingEvents($onlySome)
{
    $limit = $onlySome ? 10 : null;
    return data_GetEvents("Date > FROM_UNIXTIME(" . time() . ")", null, $limit);
}


function GetPastEvents($onlySome, $onlyYear = null)
{
    $thisYear = $onlyYear ? "AND YEAR(Date) = $onlyYear" : "";
    $limit = $onlySome ? 5 : null;

    return data_GetEvents("Date < FROM_UNIXTIME(" . time() . ") $thisYear AND ResultsLocked IS NOT NULL", '`Date` DESC, Duration ASC, :Event.id ASC', $limit);
}


function DeleteEvent($event)
{
    $eventid = esc_or_null($event->id, 'int');

    $queries = array();
    $queries[] = "DELETE FROM :AdBanner WHERE Event = $eventid";
    $queries[] = "DELETE FROM :EventQueue WHERE Event = $eventid";
    $queries[] = "DELETE FROM :ClassInEvent WHERE Event = $eventid";
    $queries[] = "DELETE FROM :EventManagement WHERE Event = $eventid";
    $queries[] = "DELETE FROM :EventTaxes WHERE Event = $eventid";

    $rounds = $event->GetRounds();
    foreach ($rounds as $round) {
        $sections = GetSections($round->id);
        foreach ($sections as $section) {
            $sectionid = esc_or_null($section->id, 'int');

            $queries[] = "DELETE FROM :SectionMembership WHERE Section = $sectionid";
            $queries[] = "DELETE FROM :StartingOrder WHERE Section = $sectionid";
        }

        $roundid = esc_or_null($round->id, 'int');
        $queries[] = "DELETE FROM :Section WHERE Round = $roundid";
        $result = db_all("SELECT id FROM :RoundResult WHERE Round = $roundid");

        foreach ($result as $row) {
            $holeid = esc_or_null($row['id'], 'int');

            $queries[] = "DELETE FROM :HoleResult WHERE RoundResult = $holeid";
        }

        $queries[] = "DELETE FROM :RoundResult WHERE Round = $roundid";
    }
    $queries[] = "UPDATE :Course SET Event = NULL WHERE Event = $eventid";
    $queries[] = "DELETE FROM :Round WHERE Event = $eventid";
    $queries[] = "DELETE FROM :TextContent WHERE Event = $eventid";
    $queries[] = "DELETE FROM :Participation WHERE Event = $eventid";
    $queries[] = "DELETE FROM :Event WHERE id = $eventid";

    foreach ($queries as $query)
        db_exec($query);
}
