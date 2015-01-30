<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for User functions
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
   $retValue = null;
   $tournamentId = (int) $tournamentId;

   $query = format_query("SELECT COUNT(DISTINCT :Participation.Player) Count FROM :Event
                  INNER JOIN :Participation ON :Participation.Event = :Event.id
                  WHERE :Event.Tournament = $tournamentId AND :Participation.EventFeePaid IS NOT NULL");
   $result = execute_query($query);

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

   require_once 'core/tournament.php';
   $retValue = array();

   $query = format_query("SELECT id, Level, Name, ScoreCalculationMethod, Year, Available FROM :Tournament WHERE 1 ");
   if ($year) {
      $year = (int) $year;
      $query .= " AND Year = $year ";
   }
   if ($onlyAvailable) {
      $query .= " AND Available <> 0";
   }
   $query .= " ORDER BY Year, Name";

   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $retValue[] = new Tournament($row['id'], $row['Level'], $row['Name'], $row['Year'], $row['ScoreCalculationMethod'], $row['Available']);
   }
   mysql_free_result($result);

   return $retValue;
}


function EditTournament($id, $name, $method, $level, $available, $year, $description)
{
   $query = format_query("UPDATE :Tournament SET Name = '%s', ScoreCalculationMethod = '%s', Level = %d, Available = %d, Year = %d,
                       Description = '%s'
                       WHERE id = %d",
                           escape_string($name), escape_string($method), (int) $level, $available ? 1 : 0, (int) $year,
                           escape_string($description),(int) $id);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function CreateTournament($name, $method, $level, $available, $year, $description)
{
   $query = format_query("INSERT INTO :Tournament(Name, ScoreCalculationMethod, Level, Available, Year, Description)
                        VALUES('%s', '%s', %d, %d, %d, '%s')",
                           escape_string($name), escape_string($method), (int) $level, $available ? 1 : 0, (int) $year,
                           escape_string($description));
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function DeleteTournament($id)
{
   $query = format_query("DELETE FROM :Tournament WHERE id = ". (int) $id);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


// Returns true if the provided tournament is being used in any event, false otherwise
function TournamentBeingUsed($id)
{
   $retValue = true;
   $query = format_query("SELECT COUNT(*) AS n FROM :Event WHERE Tournament = ". (int) $id);
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      $temp = mysql_fetch_assoc($result);
      $retValue = $temp['n'] > 0;
   }
   mysql_free_result($result);

   return $retValue;
}


function GetTournamentDetails($id)
{
    require_once 'core/tournament.php';

    $id = (int) $id;
    $retValue = array();

    $query = format_query("SELECT id, Level, Name, ScoreCalculationMethod, Year, Available, Description FROM :Tournament WHERE id = $id");
    $result = execute_query($query);

    if (mysql_num_rows($result) == 1) {
      while ($row = mysql_fetch_assoc($result))
         $retValue = new Tournament($row['id'], $row['Level'], $row['Name'], $row['Year'], $row['ScoreCalculationMethod'], $row['Available'], $row['Description']);
    }
    mysql_free_result($result);

    return $retValue;
}


function GetTournamentYears()
{
   $retValue = array();
   $query = format_query("SELECT DISTINCT Year FROM :Tournament ORDER BY Year");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $retValue[] = $row['Year'];
   }
   mysql_free_result($result);

   return $retValue;
}


function GetTournamentLeader($tournamentId)
{
   $tournamentId = (int) $tournamentId;
   $retValue = array();
   $query = format_query("SELECT :User.id FROM
                           :TournamentStanding
                           INNER JOIN :Player ON :TournamentStanding.Player = :Player.player_id
                           INNER JOIN :User ON :Player.player_id = :User.Player
                           WHERE :TournamentStanding.Tournament = $tournamentId
                           ORDER BY Standing
                           LIMIT 1");
   $result = execute_query($query);

   if (mysql_num_rows($result) == 1) {
      $row = mysql_fetch_assoc($result);
      $retValue = GetUserDetails($row['id']);
   }
   mysql_free_result($result);

   return $retValue;
}


function GetTournamentData($tid)
{
   $query = format_query("SELECT player_id, :TournamentStanding.OverallScore, :TournamentStanding.Standing,
                         :Participation.TournamentPoints, :Participation.Classification,
                         :TournamentStanding.id TSID, :Player.player_id PID, :Tournament.id TID,
                         :Event.ResultsLocked, TieBreaker, :Participation.Standing EventStanding
                         FROM :Tournament
                         LEFT JOIN :Event ON :Event.Tournament = :Tournament.id
                         LEFT JOIN :Participation ON :Event.id = :Participation.Event
                         LEFT JOIN :Player ON :Participation.Player = :Player.player_id
                         LEFT JOIN :TournamentStanding ON (:TournamentStanding.Tournament = :Tournament.id
                             AND :TournamentStanding.Player = :Player.player_id)
                         WHERE :Tournament.id = %d
                         ORDER BY :Player.player_id", $tid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($results);

   $lastrow = null;
   $out = array();
   while (($row = mysql_fetch_assoc($result)) !== false) {
     if (!$lastrow || $row['player_id'] != $lastrow['player_id']) {
         if ($lastrow)
             $out[$lastrow['player_id']] = $lastrow;
         $lastrow = $row;
         $lastrow['Events'] = array();
     }
     $lastrow['Events'][] = $row;
   }

   if ($lastrow)
      $out[$lastrow['player_id']] = $lastrow;

   mysql_free_result($result);

   return $out;
}


function SaveTournamentStanding($item)
{
   if ((int) $item['PID'] == 0)
     return;

   if (!$item['TSID']) {
      $query = format_query("INSERT INTO :TournamentStanding (Player, Tournament, OverallScore, Standing)
                         VALUES (%d, %d, 0, NULL)", $item['PID'], $item['TID']);
      execute_query($query);
   }

   $query = format_query("UPDATE :TournamentStanding
                     SET OverallScore = %d, Standing = %d
                     WHERE Player = %d AND Tournament = %d",
                     $item['OverallScore'],
                     $item['Standing'],
                     $item['PID'],
                     $item['TID']);
   execute_query($query);
}


function SetTournamentTieBreaker($tournament, $player, $value)
{
   $query = format_query("UPDATE :TournamentStanding SET TieBreaker = %d WHERE Player = %d AND Tournament = %d",
                     $value, $player, $tournament);
   execute_query($query);
}


function GetTournamentResults($tournamentId)
{
   require_once 'core/hole.php';

   $retValue = array();
   $tournamentId = (int) $tournamentId;

   $query = "SELECT :Player.player_id as PlayerId, :Player.firstname FirstName , :Player.lastname LastName, :Player.pdga PDGANumber, :User.Username,
                 :TournamentStanding.OverallScore, :TournamentStanding.Standing,
                 :Event.id EventId, :Classification.Name ClassName, TieBreaker,
                 :Participation.Standing AS EventStanding, :Participation.TournamentPoints AS EventScore
               FROM
                  :Tournament
                  INNER JOIN :Event ON :Event.Tournament = :Tournament.id
                  INNER JOIN :Participation ON :Participation.Event = :Event.id
                  INNER JOIN :Player ON :Participation.Player = :Player.player_id
                  INNER JOIN :User ON :User.Player = :Player.player_id
                  INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                  LEFT JOIN :TournamentStanding ON (:TournamentStanding.Tournament = :Tournament.id AND :TournamentStanding.Player = :Player.player_id)
                  WHERE :Tournament.id = $tournamentId AND :Event.ResultsLocked IS NOT NULL
                  ORDER BY
                     :TournamentStanding.Standing,
                     :Player.lastname,
                     :Player.firstname";
   $query = format_query($query);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   if (mysql_num_rows($result) > 0) {
      $index = 1;
      $lastrow = null;

      while ($row = mysql_fetch_assoc($result)) {
         if (@$lastrow['PlayerId'] != $row['PlayerId']) {
            if ($lastrow)
               $retValue[] = $lastrow;
            $lastrow = $row;
            $lastrow['Results'] = array();
         }

         $lastrow['Results'][$row['EventId']] = array(
            'Event' => $row['EventId'],
            'Standing' => $row['EventStanding'],
            'Score' => $row['EventScore']);
      }

      if ($lastrow)
         $retValue[] = $lastrow;
   }
   mysql_free_result($result);

   return $retValue;
}


