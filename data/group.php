<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'data/db.php';


function GetGroups($sectid)
{
    $sectid = esc_or_null($sectid, 'int');

    $result = db_all("SELECT :Player.player_id AS PlayerId, :Player.pdga AS PDGANumber, :StartingOrder.Section,
                    :StartingOrder.id, UNIX_TIMESTAMP(:StartingOrder.StartingTime) AS StartingTime,
                    :StartingOrder.StartingHole, :StartingOrder.GroupNumber,
                    :User.UserFirstName, :User.UserLastName, firstname AS pFN, lastname AS pLN,
                    IF(:Classification.Short IS NOT NULL,
                        :Classification.Short,
                        SUBSTR(:Classification.Name, 1, 3)
                    ) AS Classification,
                    :Participation.OverallResult
                FROM :StartingOrder
                INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                INNER JOIN :User ON :Player.player_id = :User.Player
                INNER JOIN :Section ON :StartingOrder.Section = :Section.id
                INNER JOIN :Round ON :Round.id = :Section.Round
                INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                WHERE :StartingOrder.Section = $sectid
                ORDER BY GroupNumber, OverallResult");

    if (db_is_error($result))
        return $result;

    $current = null;
    $group = null;
    $retValue = array();

    foreach ($result as $row) {
        $row['FirstName'] = data_GetOne($row['UserFirstName'], $row['pFN']);
        $row['LastName'] = data_GetOne($row['UserLastName'], $row['pLN']);

        if ($row['GroupNumber'] != $current) {
            if (count($group))
                $retValue[] = $group;
            $group = $row;
            $group['People'] = array();
            $current = $row['GroupNumber'];
            $group['GroupId'] = sprintf("%d-%d", $row['Section'], $row['GroupNumber']);

            if ($row['StartingHole'])
                $group['DisplayName'] = $row['StartingHole'];
            else
                $group['DisplayName'] = date('H:i', $row['StartingTime']);
        }
        $group['People'][] = $row;
    }

    if (count($group))
        $retValue[] = $group;

    return $retValue;
}


function InsertGroup($group)
{
    foreach ($group['People'] as $player) {
        $data = $group;
        $data['Player'] = $player['PlayerId'];
        InsertGroupMember($data);
    }
}


function InsertGroupMember($data)
{
    $playerid = esc_or_null($data['Player'], 'int');
    $start = esc_or_null($data['StartingTime'], 'int');
    $hole = esc_or_null($data['StartingHole'], 'int');
    $groupnumber = esc_or_null($data['GroupNumber'], 'int');
    $section = esc_or_null($data['Section'], 'int');

    return db_exec("INSERT INTO :StartingOrder (Player, StartingTime, StartingHole, GroupNumber, Section)
                        VALUES ($playerid, FROM_UNIXTIME($start), $hole, $groupnumber, $section)");
}


function AnyGroupsDefined($roundid)
{
    $roundid = esc_or_null($roundid, 'int');

    $row = db_one("SELECT 1
                        FROM :StartingOrder
                        INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                        INNER JOIN :Round ON :Round.id = :Section.Round
                        WHERE :Round.id = $roundid
                        LIMIT 1");

    return count($row);
}


function GetRoundGroups($roundid)
{
    $roundid = esc_or_null($roundid, 'int');

    return db_all("SELECT GroupNumber, StartingTime, StartingHole,
                                CONCAT(:Classification.Short, ' (', :Classification.Name, ')') AS ClassificationName,
                                :Player.lastname AS LastName, :Player.firstname AS FirstName,
                                :User.id AS UserId, :Participation.OverallResult, :Club.ShortName AS ClubName
                            FROM :StartingOrder
                            INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                            INNER JOIN :Round ON :Round.id = :Section.Round
                            INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                            INNER JOIN :User ON :User.Player = :Player.player_id
                            INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                            INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                            LEFT JOIN :Club ON (:User.Club = :Club.id)
                            WHERE :Round.id = $roundid
                            ORDER BY GroupNumber, :StartingOrder.id");
}


function GetSingleGroup($roundid, $playerid)
{
    $roundid = esc_or_null($roundid, 'int');
    $playerid = esc_or_null($playerid, 'int');

    return db_all("SELECT :StartingOrder.GroupNumber, UNIX_TIMESTAMP(:StartingOrder.StartingTime) AS StartingTime,
                                :StartingOrder.StartingHole,
                                CONCAT(:Classification.Short, ' (', :Classification.Name, ')') AS ClassificationName,
                                :Player.lastname AS LastName, :Player.firstname AS FirstName, :User.id AS UserId
                            FROM :StartingOrder
                            INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                            INNER JOIN :Round ON :Round.id = :Section.Round
                            INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                            INNER JOIN :User ON :User.Player = :Player.player_id
                            INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                            INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                            INNER JOIN :StartingOrder BaseGroup ON (:StartingOrder.Section = BaseGroup.Section AND :StartingOrder.GroupNumber = BaseGroup.GroupNumber)
                            WHERE :Round.id = $roundid AND BaseGroup.Player = $playerid
                            ORDER BY GroupNumber, :StartingOrder.id");
}


function GetUserGroupSummary($eventid, $playerid)
{
    $eventid = esc_or_null($eventid, 'int');
    $playerid = esc_or_null($playerid, 'int');

    return db_all("SELECT :StartingOrder.GroupNumber, UNIX_TIMESTAMP(:StartingOrder.StartingTime) AS StartingTime,
                                :StartingOrder.StartingHole, :Round.GroupsFinished,
                                CONCAT(:Classification.Short, ' (', :Classification.Name, ')') AS ClassificationName,
                                :Player.lastname AS LastName, :Player.firstname AS FirstName, :User.id AS UserId
                            FROM :StartingOrder
                            INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                            INNER JOIN :Round ON :Round.id = :Section.Round
                            INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                            INNER JOIN :User ON :User.Player = :Player.player_id
                            INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                            INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                            WHERE :Round.Event = $eventid AND :StartingOrder.Player = $playerid
                            ORDER BY :Round.StartTime");
}


function SetRoundGroupsDone($roundid, $done)
{
    $roundid = esc_or_null($roundid, 'int');
    $time = esc_or_null($done ? time() : null, 'int');

    return db_exec("UPDATE :Round SET GroupsFinished = FROM_UNIXTIME($time) WHERE id = $roundid");
}
