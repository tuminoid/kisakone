<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Tournament
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
require_once 'core/tournament.php';
require_once 'core/hole.php';


// Gets events for a specific tournament
function GetTournamentEvents($tournamentId)
{
    $tournamentId = (int) $tournamentId;
    $conditions = ":Event.Tournament = $tournamentId";

    return data_GetEvents($conditions);
}


// Gets the number of people who have signed up for a tournament
function GetTournamentParticipantCount($tournamentId)
{
    $tournamentId = (int) $tournamentId;
    $filter = payment_enabled() ? "AND :Participation.EventFeePaid IS NOT NULL" : "";

    $query = format_query("SELECT COUNT(DISTINCT :Participation.Player) AS Count
                            FROM :Event
                            INNER JOIN :Participation ON :Participation.Event = :Event.id
                            WHERE :Event.Tournament = $tournamentId
                            $filter");
    $result = db_query($query);

    $retValue = null;
    if (mysql_num_rows($result) > 0) {
        $temp = mysql_fetch_assoc($result);
        $retValue = $temp['Count'];
    }
    mysql_free_result($result);

    return $retValue;
}


// Gets an array of Tournament objects for a specific year
function GetTournaments($year, $onlyAvailable = false)
{
    if ($year && ($year < 2000 || $year > 2100))
        return Error::InternalError();

    $year = $year ? " AND Year = ". (int) $year : "";
    $available = $onlyAvailable ? " AND Available <> 0" : "";

    $query = format_query("SELECT id, Level, Name, ScoreCalculationMethod, Year, Available
                            FROM :Tournament
                            WHERE 1 $year $available
                            ORDER BY Year, Name");
    $result = db_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = new Tournament($row['id'], $row['Level'], $row['Name'],
                $row['Year'], $row['ScoreCalculationMethod'], $row['Available']);
    }
    mysql_free_result($result);

    return $retValue;
}


function EditTournament($id, $name, $method, $level, $available, $year, $description)
{
    $id = (int) $id;
    $name = esc_or_null($name);
    $method = esc_or_null($method);
    $level = (int) $level;
    $available = $available ? 1 : 0;
    $year = (int) $year;
    $description = esc_or_null($description);

    $query = format_query("UPDATE :Tournament
                            SET Name = $name, ScoreCalculationMethod = $method, Level = $level,
                                Available = $available, Year = $year, Description = $description
                            WHERE id = $id");
    $result = db_query($query);

    if (!$result)
        return Error::Query($query);
}


function CreateTournament($name, $method, $level, $available, $year, $description)
{
    $name = esc_or_null($name);
    $method = esc_or_null($method);
    $level = (int) $level;
    $available = $available ? 1 : 0;
    $year = (int) $year;
    $description = esc_or_null($description);

    $query = format_query("INSERT INTO :Tournament(Name, ScoreCalculationMethod, Level, Available, Year, Description)
                            VALUES($name, $method, $level, $available, $year, $description)");
    $result = db_query($query);

    if (!$result)
        return Error::Query($query);
}


function DeleteTournament($id)
{
    $id = (int) $id;

    $query = format_query("DELETE FROM :Tournament WHERE id = $id");
    $result = db_query($query);

    if (!$result)
        return Error::Query($query);
}


// Returns true if the provided tournament is being used in any event, false otherwise
function TournamentBeingUsed($id)
{
    $id = (int) $id;

    $query = format_query("SELECT COUNT(*) AS n FROM :Event WHERE Tournament = $id");
    $result = db_query($query);

    $retValue = true;
    if (mysql_num_rows($result) > 0) {
        $temp = mysql_fetch_assoc($result);
        $retValue = $temp['n'] > 0;
    }
    mysql_free_result($result);

    return $retValue;
}


function GetTournamentDetails($id)
{
    $id = (int) $id;

    $query = format_query("SELECT id, Level, Name, ScoreCalculationMethod, Year, Available, Description
                            FROM :Tournament
                            WHERE id = $id");
    $result = db_query($query);

    $retValue = array();
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = new Tournament($row['id'], $row['Level'], $row['Name'], $row['Year'],
            $row['ScoreCalculationMethod'], $row['Available'], $row['Description']);
    }
    mysql_free_result($result);

    return $retValue;
}


function GetTournamentYears()
{
    $query = format_query("SELECT DISTINCT Year FROM :Tournament ORDER BY Year");
    $result = db_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = $row['Year'];
    }
    mysql_free_result($result);

    return $retValue;
}


function GetTournamentData($tid)
{
    $tid = (int) $tid;

    $query = format_query("SELECT player_id, :TournamentStanding.OverallScore, :TournamentStanding.Standing,
                                :Participation.TournamentPoints, :Participation.Classification,
                                :TournamentStanding.id AS TSID, :Player.player_id AS PID, :Tournament.id AS TID,
                                :Event.ResultsLocked, TieBreaker, :Participation.Standing AS EventStanding
                            FROM :Tournament
                            LEFT JOIN :Event ON :Event.Tournament = :Tournament.id
                            LEFT JOIN :Participation ON :Event.id = :Participation.Event
                            LEFT JOIN :Player ON :Participation.Player = :Player.player_id
                            LEFT JOIN :TournamentStanding ON (:TournamentStanding.Tournament = :Tournament.id
                                AND :TournamentStanding.Player = :Player.player_id)
                            WHERE :Tournament.id = $tid
                            ORDER BY :Player.player_id");
    $result = db_query($query);

    if (!$result)
        return Error::Query($results);

    $lastrow = null;
    $retValue = array();
    while (($row = mysql_fetch_assoc($result)) !== false) {
        if (!$lastrow || $row['player_id'] != $lastrow['player_id']) {
            if ($lastrow)
                $retValue[$lastrow['player_id']] = $lastrow;
            $lastrow = $row;
            $lastrow['Events'] = array();
        }
        $lastrow['Events'][] = $row;
    }

    if ($lastrow)
        $retValue[$lastrow['player_id']] = $lastrow;

    mysql_free_result($result);

    return $retValue;
}


function SaveTournamentStanding($item)
{
    $pid = (int) $item['PID'];
    if ($pid == 0)
        return;

    $tsid = $item['TSID'];
    $tid = $item['TID'];

    if (!$tsid) {
        $query = format_query("INSERT INTO :TournamentStanding (Player, Tournament, OverallScore, Standing)
                         VALUES ($pid, $tid, 0, NULL)");
        db_query($query);
    }

    $score = (int) $item['OverallScore'];
    $standing = (int) $item['Standing'];

    $query = format_query("UPDATE :TournamentStanding
                            SET OverallScore = $score, Standing = $standing
                            WHERE Player = $pid AND Tournament = $tid");
    db_query($query);
}


function SetTournamentTieBreaker($tournament, $player, $value)
{
    $tournament = (int) $tournament;
    $player = (int) $player;
    $value = (int) $value;

    $query = format_query("UPDATE :TournamentStanding
                            SET TieBreaker = $value
                            WHERE Player = $player AND Tournament = $tournament");
    db_query($query);
}


function GetTournamentResults($tournamentId)
{
    $tournamentId = (int) $tournamentId;

    $query = "SELECT :Player.player_id AS PlayerId, :Player.firstname AS FirstName, :Player.lastname AS LastName,
                    :Player.pdga AS PDGANumber, :User.Username, :TournamentStanding.OverallScore, :TournamentStanding.Standing,
                    :Event.id AS EventId, :Classification.Name AS ClassName, TieBreaker,
                    :Participation.Standing AS EventStanding, :Participation.TournamentPoints AS EventScore
                FROM :Tournament
                INNER JOIN :Event ON :Event.Tournament = :Tournament.id
                INNER JOIN :Participation ON :Participation.Event = :Event.id
                INNER JOIN :Player ON :Participation.Player = :Player.player_id
                INNER JOIN :User ON :User.Player = :Player.player_id
                INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                LEFT JOIN :TournamentStanding ON (:TournamentStanding.Tournament = :Tournament.id
                    AND :TournamentStanding.Player = :Player.player_id)
                WHERE :Tournament.id = $tournamentId AND :Event.ResultsLocked IS NOT NULL
                ORDER BY :TournamentStanding.Standing, :Player.lastname, :Player.firstname";
    $query = format_query($query);
    $result = db_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        $lastrow = null;

        while ($row = mysql_fetch_assoc($result)) {
            if (@$lastrow['PlayerId'] != $row['PlayerId']) {
                if ($lastrow)
                    $retValue[] = $lastrow;
                $lastrow = $row;
                $lastrow['Results'] = array();
            }

            $lastrow['Results'][$row['EventId']] = array('Event' => $row['EventId'],
                'Standing' => $row['EventStanding'], 'Score' => $row['EventScore']);
        }

        if ($lastrow)
            $retValue[] = $lastrow;
    }
    mysql_free_result($result);

    return $retValue;
}
