<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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
function GetTournamentEvents($tournamentid)
{
    $tournamentid = esc_or_null($tournamentid, 'int');
    $conditions = ":Event.Tournament = $tournamentid";

    return data_GetEvents($conditions);
}


// Gets the number of people who have signed up for a tournament
function GetTournamentParticipantCount($tournamentid)
{
    $tournamentid = esc_or_null($tournamentid, 'int');
    $filter = payment_enabled() ? "AND :Participation.EventFeePaid IS NOT NULL" : "";

    $row = db_one("SELECT COUNT(DISTINCT :Participation.Player) AS Count
                        FROM :Event
                        INNER JOIN :Participation ON :Participation.Event = :Event.id
                        WHERE :Event.Tournament = $tournamentid
                        $filter");

    if (db_is_error($row))
        return $row;

    return $row['Count'];
}


// Gets an array of Tournament objects for a specific year
function GetTournaments($year, $onlyAvailable = false)
{
    $year = $year ? " AND Year = ". esc_or_null($year, 'int') : "";
    $available = $onlyAvailable ? " AND Available <> 0" : "";

    $result = db_all("SELECT id, Level, Name, ScoreCalculationMethod, Year, Available
                        FROM :Tournament
                        WHERE 1 $year $available
                        ORDER BY Year, Name");

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new Tournament($row['id'], $row['Level'], $row['Name'],
            $row['Year'], $row['ScoreCalculationMethod'], $row['Available']);
    return $retValue;
}


function EditTournament($id, $name, $method, $level, $available, $year, $description)
{
    $id = esc_or_null($id, 'int');
    $name = esc_or_null($name, 'string');
    $method = esc_or_null($method, 'string');
    $level = esc_or_null($level, 'int');
    $available = $available ? 1 : 0;
    $year = esc_or_null($year, 'int');
    $description = esc_or_null($description, 'string');

    return db_exec("UPDATE :Tournament
                        SET Name = $name, ScoreCalculationMethod = $method, Level = $level,
                            Available = $available, Year = $year, Description = $description
                        WHERE id = $id");
}


function CreateTournament($name, $method, $level, $available, $year, $description)
{
    $name = esc_or_null($name, 'string');
    $method = esc_or_null($method, 'string');
    $level = esc_or_null($level, 'int');
    $available = $available ? 1 : 0;
    $year = esc_or_null($year, 'int');
    $description = esc_or_null($description, 'string');

    return db_exec("INSERT INTO :Tournament(Name, ScoreCalculationMethod, Level, Available, Year, Description)
                        VALUES($name, $method, $level, $available, $year, $description)");
}


function DeleteTournament($id)
{
    $id = esc_or_null($id, 'int');

    return db_exec("DELETE FROM :Tournament WHERE id = $id");
}


// Returns true if the provided tournament is being used in any event, false otherwise
function TournamentBeingUsed($id)
{
    $id = esc_or_null($id, 'int');

    $row = db_one("SELECT 1 FROM :Event WHERE Tournament = $id LIMIT 1");

    return count($row);
}


function GetTournamentDetails($id)
{
    $id = esc_or_null($id, 'int');

    $row = db_one("SELECT id, Level, Name, ScoreCalculationMethod, Year, Available, Description
                        FROM :Tournament
                        WHERE id = $id");

    if (db_is_error($row) || !$row)
        return $row;

    return new Tournament($row['id'], $row['Level'], $row['Name'], $row['Year'],
            $row['ScoreCalculationMethod'], $row['Available'], $row['Description']);
}


function GetTournamentYears()
{
    $result = db_all("SELECT DISTINCT Year FROM :Tournament ORDER BY Year");

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = $row['Year'];
    return $retValue;
}


function GetTournamentData($tid)
{
    $tid = esc_or_null($tid, 'int');

    $result = db_all("SELECT player_id, :TournamentStanding.OverallScore, :TournamentStanding.Standing,
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

    if (db_is_error($result))
        return $result;

    $lastrow = null;
    $retValue = array();
    foreach ($result as $row) {
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

    return $retValue;
}


function SaveTournamentStanding($item)
{
    $pid = (int) $item['PID'];
    if ($pid == 0)
        return;

    $tsid = $item['TSID'];
    $tid = $item['TID'];

    if (!$tsid)
        db_exec("INSERT INTO :TournamentStanding (Player, Tournament, OverallScore, Standing)
                     VALUES ($pid, $tid, 0, NULL)");

    $score = (int) $item['OverallScore'];
    $standing = (int) $item['Standing'];

    db_exec("UPDATE :TournamentStanding
                SET OverallScore = $score, Standing = $standing
                WHERE Player = $pid AND Tournament = $tid");
}


function SetTournamentTieBreaker($tournament, $player, $value)
{
    $tournament = esc_or_null($tournament, 'int');
    $player = esc_or_null($player, 'int');
    $value = esc_or_null($value, 'int');

    db_exec("UPDATE :TournamentStanding
                SET TieBreaker = $value
                WHERE Player = $player AND Tournament = $tournament");
}


function GetTournamentResults($tournamentid)
{
    $tournamentid = esc_or_null($tournamentid, 'int');

    $result = db_all("SELECT :Player.player_id AS PlayerId, :Player.firstname AS FirstName, :Player.lastname AS LastName,
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
                WHERE :Tournament.id = $tournamentid AND :Event.ResultsLocked IS NOT NULL
                ORDER BY :TournamentStanding.Standing, :Player.lastname, :Player.firstname");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    $lastrow = null;

    foreach ($result as $row) {
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

    return $retValue;
}
