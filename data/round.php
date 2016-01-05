<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'data/db.php';
require_once 'core/round.php';
require_once 'core/hole.php';


// Get a Round object by id
function GetRoundDetails($roundid)
{
    $id = esc_or_null($roundid, 'int');

    $row = db_one("SELECT id, Event, Course, StartType, UNIX_TIMESTAMP(StartTime) AS StartTime,
                                `Interval`, ValidResults, GroupsFinished
                            FROM :Round
                            WHERE id = $id
                            ORDER BY StartTime");

    if (db_is_error($row))
        return $row;

    return new Round($row['id'], $row['Event'], $row['StartType'],
            $row['StartTime'], $row['Interval'], $row['ValidResults'],
            0, $row['Course'], $row['GroupsFinished']);
}


/**
 * Function for setting the rounds for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the round.
 */
function SetRounds($eventid, $rounds, $deleteRounds = array())
{
    $eventid = esc_or_null($eventid, 'int');

    foreach ($deleteRounds as $toDelete) {
        $toDelete = esc_or_null($toDelete, 'int');
        db_exec("DELETE FROM :Round WHERE Event = $eventid AND id = $toDelete");
    }

    foreach ($rounds as $round) {
        $date = $round['date'];
        $time = $round['time'];
        $roundid = $round['roundid'];

        $r_event = esc_or_null($eventid, 'int');
        $r_course = esc_or_null(null, 'int');
        $r_starttype = esc_or_null('simultaneous', 'string');
        $r_starttime = esc_or_null($date, 'int');
        $r_interval = 10;
        $r_validresults = 1;

        if (empty($roundid) || $roundid == '*') {
            $result = db_exec("INSERT INTO :Round (Event, Course, StartType, StartTime, `Interval`, ValidResults)
                VALUES ($r_event, $r_course, $r_starttype, FROM_UNIXTIME($r_starttime), $r_interval, $r_validresults)");

            if (db_is_error($result))
                return $result;
        }
    }

    return null;
}


function GetRoundHoles($roundid)
{
    $roundid = esc_or_null($roundid, 'int');

    $result = db_all("SELECT :Hole.id, :Hole.Course, HoleNumber, HoleText, Par, Length, :Round.id AS Round
                            FROM :Hole
                            INNER JOIN :Course ON (:Course.id = :Hole.Course)
                            INNER JOIN :Round ON (:Round.Course = :Course.id)
                            WHERE :Round.id = $roundid
                            ORDER BY HoleNumber");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new Hole($row);
    return $retValue;
}


function GetRoundResults($roundid, $sortedBy)
{
    $roundid = esc_or_null($roundid, 'int');

    $groupByClass = false;
    if ($sortedBy == 'resultsByClass')
        $groupByClass = true;

    $query = "SELECT :Player.player_id AS PlayerId, :Player.firstname AS FirstName, :Player.lastname AS LastName,
                    :Player.pdga AS PDGANumber, :PDGAPlayers.rating AS Rating, :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                    :StartingOrder.GroupNumber, (:HoleResult.Result - :Hole.Par) AS Plusminus, Completed,
                    :HoleResult.Result AS HoleResult, :Hole.id AS HoleId, :Hole.HoleNumber, :RoundResult.PlusMinus AS RoundPlusMinus,
                    :Classification.Name AS ClassName, CumulativePlusminus, CumulativeTotal, :RoundResult.DidNotFinish,
                    :Classification.id AS Classification, :Club.ShortName AS ClubName,
                    :PDGAPlayers.country AS PDGACountry
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
                LEFT JOIN :Club ON :Participation.Club = :Club.id
                LEFT JOIN :PDGAPlayers ON :Player.pdga = :PDGAPlayers.pdga_number
                WHERE :Round.id = $roundid AND :Section.Present";

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

    $result = db_all($query);

    if (db_is_error($result))
        return $result;

    $retValue = array();
    $lastrow = null;

    foreach ($result as $row) {
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

    if ($sortedBy == 'resultsByClass')
        $retValue = data_FinalizeResultSort($roundid, $retValue);

    return $retValue;
}


function GetResultUpdatesSince($eventid, $roundid, $time)
{
    $time = (int) $time;
    if ($time < 10)
        $time = 10;

    if ($roundid) {
        $roundid = esc_or_null($roundid, 'int');
        $query = "SELECT :HoleResult.Player, :HoleResult.Hole, :HoleResult.Result,
                        :RoundResult.Round, :Hole.HoleNumber
                    FROM :HoleResult
                    INNER JOIN :RoundResult ON :HoleResult.RoundResult = :RoundResult.id
                    INNER JOIN :Hole ON :Hole.id = :HoleResult.Hole
                    WHERE :RoundResult.Round = $roundid AND :HoleResult.LastUpdated > FROM_UNIXTIME($time - 2)";
    }
    else {
        $eventid = esc_or_null($eventid, 'int');
        $query = "SELECT :HoleResult.Player, :HoleResult.Hole, :HoleResult.Result,
                        HoleNumber, :RoundResult.Round
                    FROM :HoleResult
                    INNER JOIN :RoundResult ON :HoleResult.RoundResult = :RoundResult.id
                    INNER JOIN :Round ON :Round.id = :RoundResult.Round
                    INNER JOIN :Hole ON :Hole.id = :HoleResult.Hole
                    WHERE :Round.Event = $eventid AND :HoleResult.LastUpdated > FROM_UNIXTIME($time - 2)";
    }

    $result = db_all($query);

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = array('PlayerId' => $row['Player'], 'HoleId' => $row['Hole'],
            'HoleNum' => $row['HoleNumber'], 'Special' => null,
            'Value' => $row['Result'], 'RoundId' => $row['Round']);


    $result = db_all("SELECT Result, Player, SuddenDeath, Penalty, Round
                            FROM :RoundResult
                            WHERE :RoundResult.Round = $roundid AND LastUpdated > FROM_UNIXTIME($time)");

    foreach ($result as $row) {
        $retValue[] = array('PlayerId' => $row['Player'], 'HoleId' => null,
            'HoleNum' => 0, 'Special' => 'Sudden Death',
            'Value' => $row['SuddenDeath'], 'RoundId' => $row['Round']);
        $retValue[] = array('PlayerId' => $row['Player'], 'HoleId' => null,
            'HoleNum' => 0, 'Special' => 'Penalty',
            'Value' => $row['Penalty'], 'RoundId' => $row['Round']);
    }

    return $retValue;
}


function SaveResult($roundid, $playerid, $holeid, $special, $holeresult)
{
    $rrid = GetRoundResult($roundid, $playerid);
    if (is_a($rrid, 'Error'))
        return $rrid;

    if (!$holeid)
        return data_UpdateRoundResult($rrid, $special, $holeresult);

    return data_UpdateHoleResult($rrid, $playerid, $holeid, $holeresult);
}


function data_UpdateHoleResult($roundresultid, $playerid, $holeid, $holeresult)
{
    $result = db_exec("LOCK TABLE :HoleResult WRITE");
    if (db_is_error($result))
        error_log("Failed to LOCK :HoleResult, there is potential race condition (rrid=$rrid, player=$playerid, hole=$holeid)!");

    $rrid = esc_or_null($roundresultid, 'int');
    $playerid = esc_or_null($playerid, 'int');
    $holeid = esc_or_null($holeid, 'int');
    $holeresult = esc_or_null($holeresult, 'int');

    $result = db_one("SELECT id
                        FROM :HoleResult
                        WHERE RoundResult = $rrid AND Player = $playerid AND Hole = $holeid");

    if (!count($result))
        db_exec("INSERT INTO :HoleResult (Hole, RoundResult, Player, Result, DidNotShow, LastUpdated)
                        VALUES ($holeid, $rrid, $playerid, 0, 0, NOW())");

    $dns = 0;
    if ($holeresult == 99 || $holeresult == 999) {
        $dns = 1;
        $holeresult = 99;
    }

    db_exec("UPDATE :HoleResult
                SET Result = $holeresult, DidNotShow = $dns, LastUpdated = NOW()
                WHERE RoundResult = $rrid AND Hole = $holeid AND Player = $playerid");

    db_exec("UNLOCK TABLES");

    return data_UpdateRoundResult($roundresultid);
}


function data_UpdateRoundResult($roundresultid, $modifyField = null, $modValue = null)
{
    $rrid = esc_or_null($roundresultid, 'int');

    $details = db_one("SELECT Round, Penalty, SuddenDeath FROM :RoundResult WHERE id = $rrid");

    if (db_is_error($details))
        return $details;

    $round = GetRoundDetails($details['Round']);
    $numHoles = $round->NumHoles();

    $result = db_all("SELECT Result, DidNotShow, :Hole.Par
                            FROM :HoleResult
                            INNER JOIN :Hole ON :HoleResult.Hole = :Hole.id
                            WHERE RoundResult = $rrid");

    if (db_is_error($result))
        return $result;

    $holes = $total = $plusminus = $dnf = 0;
    foreach ($result as $row) {
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
    $penalty = $penalty ? $penalty : 0;
    $suddendeath = $suddendeath ? $suddendeath : 0;
    db_exec("UPDATE :RoundResult
                SET Result = $total, Penalty = $penalty, SuddenDeath = $suddendeath, Completed = $complete,
                    DidNotFinish = $dnf, PlusMinus = $plusminus, LastUpdated = NOW()
                WHERE id = $rrid");

    UpdateCumulativeScores($roundresultid);
    UpdateEventResults($round->eventId);
}


function UpdateCumulativeScores($rrid)
{
    $rrid = esc_or_null($rrid, 'int');

    $result = db_all("SELECT :RoundResult.PlusMinus, :RoundResult.Result, :RoundResult.CumulativePlusminus,
                            :RoundResult.CumulativeTotal, :RoundResult.id, :RoundResult.DidNotFinish
                        FROM :RoundResult
                        INNER JOIN :Round ON :Round.id = :RoundResult.Round
                        INNER JOIN :Round RX ON :Round.Event = RX.Event
                        INNER JOIN :RoundResult RRX ON RRX.Round = RX.id
                        WHERE RRX.id = $rrid AND RRX.Player = :RoundResult.Player
                        ORDER BY :Round.StartTime");

    if (db_is_error($result))
        return $result;

    $total = $pm = 0;
    foreach ($result as $row) {
        if (!$row['DidNotFinish']) {
            $total += $row['Result'];
            $pm += $row['PlusMinus'];
        }

        if ($row['CumulativePlusminus'] != $pm || $row['CumulativeTotal'] != $total) {
            $id = esc_or_null($row['id'], 'int');

            db_exec("UPDATE :RoundResult
                        SET CumulativeTotal = $total, CumulativePlusminus = $pm
                        WHERE id = $id");
        }
    }
}


function GetRoundResult($roundid, $playerid)
{
    $roundid = esc_or_null($roundid, 'int');
    $playerid = esc_or_null($playerid, 'int');

    db_exec("LOCK TABLE :RoundResult WRITE");

    $result = db_all("SELECT id FROM :RoundResult WHERE Round = $roundid AND Player = $playerid");
    $id = 0;
    $rows = count($result);

    if ($rows > 1) {
        error_log("Double RoundResult for player=$playerid at round=$roundid, deleting them...");

        // Cleanest thing we can do is to throw away all the invalid scores and return error.
        // This way TD knows to reload the scoring page and can alleviate the error by re-entering.
        db_exec("DELETE FROM :RoundResult WHERE Round = $roundid AND Player = $playerid");
        $id = Error::InternalError("Double score detected, please reload...");
    }
    elseif ($rows == 0) {
        $id = db_exec("INSERT INTO :RoundResult (Round, Player, Result, Penalty, SuddenDeath, Completed, LastUpdated)
                     VALUES ($roundid, $playerid, 0, 0, 0, 0, NOW())");
    }
    else {
        $id = $result[0]['id'];
    }

    db_exec("UNLOCK TABLES");

    return $id;
}


function SetRoundDetails($roundid, $date, $startType, $interval, $valid, $course)
{
    $roundid = esc_or_null($roundid, 'int');
    $date = esc_or_null($date, 'int');
    $startType = esc_or_null($startType, 'string');
    $interval = esc_or_null($interval, 'int');
    $valid = $valid ? 1 : 0;
    $course = esc_or_null($course, 'int');

    return db_exec("UPDATE :Round
                        SET StartTime = FROM_UNIXTIME($date), StartType = $startType,
                            `Interval` = $interval, ValidResults = $valid, Course = $course
                        WHERE id = $roundid");
}


function PlayerOnRound($roundid, $playerid)
{
    $roundid = esc_or_null($roundid, 'int');
    $playerid = esc_or_null($playerid, 'int');

    $row = db_one("SELECT :Participation.Player
                    FROM :Participation
                    INNER JOIN :SectionMembership ON :SectionMembership.Participation = :Participation.id
                    INNER JOIN :Section ON :Section.id = :SectionMembership.Section
                    WHERE :Participation.Player = $playerid AND :Section.Round = $roundid
                    LIMIT 1");

    return count($row);
}


function GetParticipationIdByRound($roundid, $playerid)
{
    $roundid = esc_or_null($roundid, 'int');
    $playerid = esc_or_null($playerid, 'int');

    $result = db_one("SELECT :Participation.id
                        FROM :Participation
                        INNER JOIN :Event ON :Event.id = :Participation.Event
                        INNER JOIN :Round ON :Round.Event = :Event.id
                        WHERE :Participation.Player = $playerid AND :Round.id = $roundid");

    if (db_is_error($result))
        return $result;

    return $result['id'];
}


function RemovePlayersFromRound($roundid, $playerids = null)
{
    $roundid = esc_or_null($roundid, 'int');

    if (!is_array($playerids))
        $playerids = array($playerids);

    $playerids = array_filter($playerids, 'is_numeric');
    $players = implode(", ", $playerids);

    $result = db_all("SELECT :SectionMembership.id
                        FROM :SectionMembership
                        INNER JOIN :Section ON :Section.id = :SectionMembership.Section
                        INNER JOIN :Participation ON :Participation.id = :SectionMembership.Participation
                        WHERE :Section.Round = $roundid AND :Participation.Player IN ($players)");

    if (db_is_error($result))
        return $result;

    $ids = array();
    foreach ($result as $row)
        $ids[] = $row['id'];

    if (!count($ids))
        return;

    $ids = implode(", ", $ids);
    db_exec("DELETE FROM :SectionMembership WHERE id IN ($ids)");
}


function ResetRound($roundid, $resetType = 'full')
{
    $sections = GetSections($roundid);
    $sectIds = array();
    foreach ($sections as $section)
        $sectIds[] = $section->id;
    $idList = implode(', ', $sectIds);

    if (count($sectIds) > 0) {
        if ($resetType == 'groups' || $resetType == 'full')
            db_exec("DELETE FROM :StartingOrder WHERE Section IN ($idList)");

        if ($resetType == 'full' || $resetType == 'players')
            db_exec("DELETE FROM :SectionMembership WHERE Section IN ($idList)");

        if ($resetType == 'full')
            db_exec("DELETE FROM :Section WHERE id IN ($idList)");
    }
}


function GetHoleResults($rrid)
{
    $rrid = esc_or_null($rrid, 'int');

    return db_all("SELECT Hole, Result FROM :HoleResult WHERE RoundResult = $rrid");
}


function GetRoundCourse($roundid)
{
    $roundid = esc_or_null($roundid, 'int');

    return db_one("SELECT :Course.id, Name, Description, Link, Map
                            FROM :Course
                            INNER JOIN :Round ON :Round.Course = :Course.id
                            WHERE :Round.id = $roundid");
}
