<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Round
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
require_once 'core/round.php';
require_once 'core/hole.php';


// Get a Round object by id
function GetRoundDetails($roundid)
{
    $id = (int) $roundid;

    $query = format_query("SELECT id, Event, Course, StartType, UNIX_TIMESTAMP(StartTime) AS StartTime,
                                `Interval`, ValidResults, GroupsFinished
                            FROM :Round
                            WHERE id = $id
                            ORDER BY StartTime");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = new Round($row['id'], $row['Event'], $row['StartType'],
            $row['StartTime'], $row['Interval'], $row['ValidResults'],
            0, $row['Course'], $row['GroupsFinished']);
    }
    mysql_free_result($result);

    return $retValue;
}


/**
 * Function for setting the rounds for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the round.
 */
function SetRounds($eventid, $rounds, $deleteRounds = array())
{
    $eventid = (int) $eventid;

    foreach ($deleteRounds as $toDelete) {
        $toDelete = (int) $toDelete;
        $query = format_query("DELETE FROM :Round WHERE Event = $eventid AND id = $toDelete");
        $result = execute_query($query);

        if (!$result)
            return Error::Query($query);
    }

    foreach ($rounds as $round) {
        $date = $round['date'];
        $time = $round['time'];
        $roundid = $round['roundid'];

        $r_event = (int) $eventid;
        $r_course = esc_or_null(null, 'int');
        $r_starttype = esc_or_null('simultaneous');
        $r_starttime = (int) $date;
        $r_interval = 10;
        $r_validresults = 1;

        if (empty($roundid) || $roundid == '*') {
            $query = format_query("INSERT INTO :Round (Event, Course, StartType, StartTime, `Interval`, ValidResults)
                VALUES ($r_event, $r_course, $r_starttype, FROM_UNIXTIME($r_starttime), $r_interval, $r_validresults)");
            $result = execute_query($query);

            if (!$result)
                return Error::Query($query);
        }
    }

    return null;
}


/**
 * Function for setting the round course
 *
 * Returns cource id for success or an Error
 */
function GetOrSetRoundCourse($roundid)
{
    $roundid = (int) $roundid;

    $query = format_query("SELECT Course FROM :Round WHERE id = $roundid");
    $result = execute_query($query);

    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $course = $row['Course'];
        mysql_free_result($result);
    }
    else
        return Error::internalError("Invalid round id argument");

    // Create a new course for the round
    $query = format_query("INSERT INTO :Course (Venue, Name, Description, Link, Map)
                            VALUES (NULL, '', '', '', '')");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $courseid = mysql_insert_id();
    $query = format_query("UPDATE :Round SET Course = $courseid WHERE id = $roundid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    return $courseid;
}


function GetRoundHoles($roundId)
{
    $roundId = (int) $roundId;

    $query = format_query("SELECT :Hole.id, :Hole.Course, HoleNumber, HoleText, Par, Length, :Round.id AS Round
                            FROM :Hole
                            INNER JOIN :Course ON (:Course.id = :Hole.Course)
                            INNER JOIN :Round ON (:Round.Course = :Course.id)
                            WHERE :Round.id = $roundId
                            ORDER BY HoleNumber");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = new Hole($row);
    }
    mysql_free_result($result);

    return $retValue;
}


function GetRoundResults($roundId, $sortedBy)
{
    $roundId = (int) $roundId;

    $groupByClass = false;
    if ($sortedBy == 'resultsByClass')
        $groupByClass = true;

    $query = "SELECT :Player.player_id AS PlayerId, :Player.firstname AS FirstName, :Player.lastname AS LastName,
                    :Player.pdga AS PDGANumber, :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                    :StartingOrder.GroupNumber, (:HoleResult.Result - :Hole.Par) AS Plusminus, Completed,
                    :HoleResult.Result AS HoleResult, :Hole.id AS HoleId, :Hole.HoleNumber, :RoundResult.PlusMinus AS RoundPlusMinus,
                    :Classification.Name AS ClassName, CumulativePlusminus, CumulativeTotal, :RoundResult.DidNotFinish,
                    :Classification.id AS Classification
                FROM :Round
                LEFT JOIN :Section ON :Round.id = :Section.Round
                LEFT JOIN :StartingOrder ON (:StartingOrder.Section = :Section.id)
                LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                LEFT JOIN :HoleResult ON (:HoleResult.RoundResult = :RoundResult.id AND :HoleResult.Player = :StartingOrder.Player)
                LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
                LEFT JOIN :User ON :Player.player_id = :User.Player
                LEFT JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                LEFT JOIN :Classification ON :Classification.id = :Participation.Classification
                LEFT JOIN :Hole ON :HoleResult.Hole = :Hole.id
                WHERE :Round.id = $roundId AND :Section.Present";

    switch ($sortedBy) {
        case 'group':
            $query .= " ORDER BY :StartingOrder.GroupNumber, :StartingOrder.id";
            break;

        case 'results':
        case 'resultsByClass':
            $query .= " ORDER BY (:RoundResult.DidNotFinish IS NULL OR :RoundResult.DidNotFinish = 0) DESC,
                        :Hole.id IS NULL, :RoundResult.CumulativePlusminus, :Player.player_id";
            break;

        default:
            return Error::InternalError();
    }

    $query = format_query($query);
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        $lastrow = null;

        while ($row = mysql_fetch_assoc($result)) {
            if (!$row['PlayerId'])
                continue;

            if (@$lastrow['PlayerId'] != $row['PlayerId']) {
                if ($lastrow) {
                    if ($groupByClass) {
                        $class = $lastrow['ClassName'];
                        if (!isset($retValue[$class]))
                            $retValue[$class] = array();

                        $retValue[$class][] = $lastrow;
                    }
                    else
                        $retValue[] = $lastrow;
                }
                $lastrow = $row;
                $lastrow['Results'] = array();
                $lastrow['TotalPlusMinus'] = $lastrow['Penalty'];
            }

            $lastrow['Results'][$row['HoleNumber']] = array('Hole' => $row['HoleNumber'],
                    'HoleId' => $row['HoleId'], 'Result' => $row['HoleResult']);
            $lastrow['TotalPlusMinus'] += $row['Plusminus'];
        }

        if ($lastrow) {
            if ($groupByClass) {
                $class = $lastrow['ClassName'];
                if (!isset($retValue[$class]))
                    $retValue[$class] = array();

                $retValue[$class][] = $lastrow;
            }
            else
                $retValue[] = $lastrow;
        }
    }
    mysql_free_result($result);

    if ($sortedBy == 'resultsByClass')
        $retValue = data_FinalizeResultSort($roundId, $retValue);

    return $retValue;
}


function GetResultUpdatesSince($eventId, $roundId, $time)
{
    $eventId = (int) $eventId;
    $roundId = (int) $roundId;
    $time = (int) $time;

    if ($time < 10)
        $time = 10;

    if ($roundId) {
        $query = "SELECT :HoleResult.Player, :HoleResult.Hole, :HoleResult.Result,
                        :RoundResult.Round, :Hole.HoleNumber
                    FROM :HoleResult
                    INNER JOIN :RoundResult ON :HoleResult.RoundResult = :RoundResult.id
                    INNER JOIN :Hole ON :Hole.id = :HoleResult.Hole
                    WHERE :RoundResult.Round = $roundId AND :HoleResult.LastUpdated > FROM_UNIXTIME($time - 2)";
    }
    else {
        $query = "SELECT :HoleResult.Player, :HoleResult.Hole, :HoleResult.Result,
                        HoleNumber, :RoundResult.Round
                    FROM :HoleResult
                    INNER JOIN :RoundResult ON :HoleResult.RoundResult = :RoundResult.id
                    INNER JOIN :Round ON :Round.id = :RoundResult.Round
                    INNER JOIN :Hole ON :Hole.id = :HoleResult.Hole
                    WHERE :Round.Event = $eventId AND :HoleResult.LastUpdated > FROM_UNIXTIME($time - 2)";
    }

    $query = format_query($query);
    $result = execute_query($query);

    $retValue = array();
    while (($row = mysql_fetch_assoc($result)) !== false)
        $retValue[] = array('PlayerId' => $row['Player'], 'HoleId' => $row['Hole'],
            'HoleNum' => $row['HoleNumber'], 'Special' => null,
            'Value' => $row['Result'], 'RoundId' => $row['Round']);
    mysql_free_result($result);


    $query = format_query("SELECT Result, Player, SuddenDeath, Penalty, Round
                            FROM :RoundResult
                            WHERE :RoundResult.Round = $roundId AND LastUpdated > FROM_UNIXTIME($time)");
    $result = execute_query($query);

    while (($row = mysql_fetch_assoc($result)) !== false) {
        $retValue[] = array('PlayerId' => $row['Player'], 'HoleId' => null,
            'HoleNum' => 0, 'Special' => 'Sudden Death',
            'Value' => $row['SuddenDeath'], 'RoundId' => $row['Round']);
        $retValue[] = array('PlayerId' => $row['Player'], 'HoleId' => null,
            'HoleNum' => 0, 'Special' => 'Penalty',
            'Value' => $row['Penalty'], 'RoundId' => $row['Round']);
    }
    mysql_free_result($result);

    return $retValue;
}


function SaveResult($roundid, $playerid, $holeid, $special, $holeresult)
{
    $roundid = (int) $roundid;
    $playerid = (int) $playerid;
    $holeid = (int) $holeid;
    $holeresult = (int) $holeresult;

    $rrid = GetRoundResult($roundid, $playerid);
    if (is_a($rrid, 'Error'))
        return $rrid;

    if (!$holeid)
        return data_UpdateRoundResult($rrid, $special, $holeresult);

    return data_UpdateHoleResult($rrid, $playerid, $holeid, $holeresult);
}


function data_UpdateHoleResult($rrid, $playerid, $holeid, $holeresult)
{
    $rrid = (int) $rrid;
    $playerid = (int) $playerid;
    $holeid = (int) $holeid;
    $holeresult = (int) $holeresult;

    $query = format_query("LOCK TABLE :HoleResult WRITE");
    $result = execute_query($query);
    if (!$result)
        error_log("Failed to '$query', there is potential race condition (rrid=$rrid, player=$playerid, hole=$holeid)!");

    $query = format_query("SELECT id
                            FROM :HoleResult
                            WHERE RoundResult = $rrid AND Player = $playerid AND Hole = $holeid");
    $result = execute_query($query);

    if (!mysql_num_rows($result)) {
        $query = format_query("INSERT INTO :HoleResult (Hole, RoundResult, Player, Result, DidNotShow, LastUpdated)
                                VALUES ($holeid, $rrid, $playerid, 0, 0, NOW())");
        execute_query($query);
    }

    $dns = 0;
    if ($holeresult == 99 || $holeresult == 999) {
        $dns = 1;
        $holeresult = 99;
    }

    $query = format_query("UPDATE :HoleResult
                            SET Result = $holeresult, DidNotShow = $dns, LastUpdated = NOW()
                            WHERE RoundResult = $rrid AND Hole = $holeid AND Player = $playerid");
    $result = execute_query($query);

    execute_query(format_query("UNLOCK TABLES"));

    return data_UpdateRoundResult($rrid);
}


function data_UpdateRoundResult($rrid, $modifyField = null, $modValue = null)
{
    $rrid = (int) $rrid;

    $query = format_query("SELECT Round, Penalty, SuddenDeath FROM :RoundResult WHERE id = $rrid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $details = mysql_fetch_assoc($result);
    $round = GetRoundDetails($details['Round']);
    $numHoles = $round->NumHoles();

    $query = format_query("SELECT Result, DidNotShow, :Hole.Par
                            FROM :HoleResult
                            INNER JOIN :Hole ON :HoleResult.Hole = :Hole.id
                            WHERE RoundResult = $rrid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $holes = $total = $plusminus = $dnf = 0;
    while (($row = mysql_fetch_assoc($result)) !== false) {
        if ($row['DidNotShow']) {
            $dnf = true;
            break;
        }
        else {
            if ($row['Result']) {
                $total += $row['Result'];
                $ppm = $plusminus;
                $plusminus += $row['Result'] - $row['Par'];
                $holes++;
            }
        }
    }
    $total += $details['Penalty'];
    $plusminus += $details['Penalty'];
    $complete = ($total == 999) ? $numHoles : $holes;

    $penalty = $details['Penalty'];
    if ($modifyField == 'Penalty') {
        $total += $modValue - $details['Penalty'];
        $plusminus += $modValue - $details['Penalty'];
        $penalty = $modValue;
    }

    $suddendeath = $details['SuddenDeath'];
    if ($modifyField == 'Sudden Death')
        $suddendeath = $modValue;

    $dnf = $dnf ? 1 : 0;
    $query = format_query("UPDATE :RoundResult
                            SET Result = $total, Penalty = $penalty, SuddenDeath = $suddendeath, Completed = $complete,
                                DidNotFinish = $dnf, PlusMinus = $plusminus, LastUpdated = NOW()
                            WHERE id = $rrid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    UpdateCumulativeScores($rrid);
    UpdateEventResults($round->eventId);
}


function UpdateCumulativeScores($rrid)
{
    $rrid = (int) $rrid;

    $query = format_query("SELECT :RoundResult.PlusMinus, :RoundResult.Result, :RoundResult.CumulativePlusminus,
                                :RoundResult.CumulativeTotal, :RoundResult.id, :RoundResult.DidNotFinish
                            FROM :RoundResult
                            INNER JOIN :Round ON :Round.id = :RoundResult.Round
                            INNER JOIN :Round RX ON :Round.Event = RX.Event
                            INNER JOIN :RoundResult RRX ON RRX.Round = RX.id
                            WHERE RRX.id = $rrid AND RRX.Player = :RoundResult.Player
                            ORDER BY :Round.StartTime");
    $result = execute_query($query);

    $total = $pm = 0;

    while (($row = mysql_fetch_assoc($result)) !== false) {
        if (!$row['DidNotFinish']) {
            $total += $row['Result'];
            $pm += $row['PlusMinus'];
        }

        if ($row['CumulativePlusminus'] != $pm || $row['CumulativeTotal'] != $total) {
            $id = (int) $row['id'];

            $query = format_query("UPDATE :RoundResult
                                    SET CumulativeTotal = $total, CumulativePlusminus = $pm
                                    WHERE id = $id");
            execute_query($query);
        }
    }
    mysql_free_result($result);
}


function GetRoundResult($roundid, $playerid)
{
    $roundid = (int) $roundid;
    $playerid = (int) $playerid;

    $query = format_query("LOCK TABLE :RoundResult WRITE");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $query = format_query("SELECT id FROM :RoundResult WHERE Round = $roundid AND Player = $playerid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $id = 0;
    $rows = mysql_num_rows($result);

    if ($rows > 1) {
        error_log("Double RoundResult for player=$playerid at round=$roundid, deleting them...");
        // Cleanest thing we can do is to throw away all the invalid scores and return error.
        // This way TD knows to reload the scoring page and can alleviate the error by re-entering.
        execute_query(format_query("DELETE FROM :RoundResult WHERE Round = $roundid AND Player = $playerid"));
        $id = Error::internalError("Double score detected, please reload...");
    }
    elseif (!mysql_num_rows($result)) {
        $query = format_query("INSERT INTO :RoundResult (Round, Player, Result, Penalty, SuddenDeath, Completed, LastUpdated)
                     VALUES ($roundid, $playerid, 0, 0, 0, 0, NOW())");
        $result = execute_query($query);

        if ($result)
            $id = mysql_insert_id();
    }
    else {
        $row = mysql_fetch_assoc($result);
        $id = $row['id'];
    }

    execute_query(format_query("UNLOCK TABLES"));

    return $id;
}


function SetRoundDetails($roundid, $date, $startType, $interval, $valid, $course)
{
    $roundid = (int) $roundid;
    $date = (int) $date;
    $startType = esc_or_null($startType);
    $interval = (int) $interval;
    $valid = $valid ? 1 : 0;
    $course = esc_or_null($course, 'int');

    $query = format_query("UPDATE :Round
                            SET StartTime = FROM_UNIXTIME($date), StartType = $startType,
                                `Interval = $interval, ValidResults = $valid, Course = $course
                            WHERE id = $roundid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}


function PlayerOnRound($roundid, $playerid)
{
    $roundid = (int) $roundid;
    $playerid = (int) $playerid;

    $query = format_query("SELECT :Participation.Player
                            FROM :Participation
                            INNER JOIN :SectionMembership ON :SectionMembership.Participation = :Participation.id
                            INNER JOIN :Section ON :Section.id = :SectionMembership.Section
                            WHERE :Participation.Player = $playerid AND :Section.Round = $roundid
                            LIMIT 1");
    $result = execute_query($query);

    $retValue = (mysql_num_rows($result) != 0);
    mysql_free_result($result);

    return $retValue;
}


function GetParticipationIdByRound($roundid, $playerid)
{
    $roundid = (int) $roundid;
    $playerid = (int) $playerid;

    $query = format_query("SELECT :Participation.id
                            FROM :Participation
                            INNER JOIN :Event ON :Event.id = :Participation.Event
                            INNER JOIN :Round ON :Round.Event = :Event.id
                            WHERE :Participation.Player = $playerid AND :Round.id = $roundid");
    $result = execute_query($query);

    if (!$result)
        return null;

    $row = mysql_fetch_assoc($result);
    mysql_free_result($result);

    return $row['id'];
}


function RemovePlayersFromRound($roundid, $playerids = null)
{
    $roundid = (int) $roundid;

    if (!is_array($playerids))
        $playerids = array($playerids);

    $playerids = array_filter($playerids, 'is_numeric');
    $players = implode(", ", $playerids);

    $query = format_query("SELECT :SectionMembership.id
                            FROM :SectionMembership
                            INNER JOIN :Section ON :Section.id = :SectionMembership.Section
                            INNER JOIN :Participation ON :Participation.id = :SectionMembership.Participation
                            WHERE :Section.Round = $roundid AND :Participation.Player IN ($players)");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $ids = array();
    while (($row = mysql_fetch_assoc($result)) !== false)
        $ids[] = $row['id'];
    mysql_free_result($result);

    if (!count($ids))
        return;

    $ids = implode(", ", $ids);
    execute_query(format_query("DELETE FROM :SectionMembership WHERE id IN ($ids)"));
}


function ResetRound($roundid, $resetType = 'full')
{
    $roundid = (int) $roundid;

    $sections = GetSections($roundid);
    $sectIds = array();

    foreach ($sections as $section)
        $sectIds[] = $section->id;
    $idList = implode(', ', $sectIds);

    if (count($sectIds) > 0) {
        if ($resetType == 'groups' || $resetType == 'full')
            execute_query(format_query("DELETE FROM :StartingOrder WHERE Section IN ($idList)"));

        if ($resetType == 'full' || $resetType == 'players')
            execute_query(format_query("DELETE FROM :SectionMembership WHERE Section IN ($idList)"));

        if ($resetType == 'full')
            execute_query(format_query("DELETE FROM :Section WHERE id IN ($idList)"));
    }
}


function GetHoleResults($rrid)
{
    $rrid = (int) $rrid;

    $query = format_query("SELECT Hole, Result FROM :HoleResult WHERE RoundResult = $rrid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = array();
    while (($row = mysql_fetch_assoc($result)) !== false)
        $retValue[] = $row;
    mysql_free_result($result);

    return $retValue;
}


function GetRoundCourse($roundid)
{
    $roundid = (int) $roundid;

    $query = format_query("SELECT :Course.id, Name, Description, Link, Map
                            FROM :Course
                            INNER JOIN :Round ON :Round.Course = :Course.id
                            WHERE :Round.id = $roundid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = mysql_fetch_assoc($result);
    mysql_free_result($result);

    return $retValue;
}
