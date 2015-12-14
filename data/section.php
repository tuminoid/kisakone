<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Section
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
require_once 'core/section.php';


// Get sections for a Round
function GetSections($round, $order = 'time')
{
    $roundid = esc_or_null($round, 'int');

    if ($order == 'time')
        $order = "Priority, StartTime, Name";
    else
        $order = "Classification, Name";

    $result = db_all("SELECT :Section.id, Name, UNIX_TIMESTAMP(StartTime) AS StartTime,
                                Priority, Classification, Round, Present
                            FROM :Section
                            WHERE :Section.Round = $roundid
                            ORDER BY $order");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new Section($row);
    return $retValue;
}


// Gets a Section object by id
function GetSectionDetails($sectionid)
{
    $sectionid = esc_or_null($sectionid, 'int');

    $row = db_one("SELECT id, Name, Round, Priority, UNIX_TIMESTAMP(StartTime) AS StartTime, Present, Classification
                            FROM :Section
                            WHERE id = $sectionid");

    if (db_is_error($row))
        return $row;

    return new Section($row);
}


function GetSectionMembers($sectionid)
{
    $sectionid = esc_or_null($sectionid, 'int');

    $result = db_all("SELECT :Player.player_id AS PlayerId, :User.UserFirstName, :User.UserLastName,
                                :Player.pdga AS PDGANumber, :Player.firstname AS pFN, :Player.lastname AS pLN,
                                :Player.email AS pEM,
                                IF(:Classification.Short IS NOT NULL,
                                    CONCAT(:Classification.Short, ' (', :Classification.Name, ')'),
                                    :Classification.Name
                                ) AS Classification,
                                SM.id AS MembershipId, :Participation.OverallResult
                            FROM :User
                            INNER JOIN :Player ON :User.Player = :Player.player_id
                            INNER JOIN :Participation ON :Player.player_id = :Participation.Player
                            INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                            INNER JOIN :SectionMembership SM ON SM.Participation = :Participation.id
                            WHERE SM.Section = $sectionid
                            ORDER BY :Participation.OverallResult DESC, SM.id");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    foreach ($result as $row) {
        $row['FirstName'] = data_GetOne($row['UserFirstName'], $row['pFN']);
        $row['LastName'] = data_GetOne($row['UserLastName'], $row['pLN']);
        $retValue[] = $row;
    }

    return $retValue;
}


function CreateSection($round, $baseClassId, $name)
{
    $round = esc_or_null($round, 'int');
    $classid = esc_or_null($baseClassId, 'int');
    $name = esc_or_null($name);

    return db_exec("INSERT INTO :Section(Round, Classification, Name, Present)
                        VALUES($round, $classid, $name, 1)");
}


function RenameSection($classid, $newName)
{
    $classid = esc_or_null($classid, 'int');
    $newName = esc_or_null($newName);

    return db_exec("UPDATE :Section SET Name = $newName WHERE id = $classid");
}


function AssignPlayersToSection($roundid, $sectionid, $playerids)
{
    $each = array();
    foreach ($playerids as $playerid)
        $each[] = sprintf("(%d, %d)", GetParticipationIdByRound($roundid, $playerid), $sectionid);

    $data = implode(", ", $each);
    return db_exec("INSERT INTO :SectionMembership (Participation, Section) VALUES $data");
}


function AdjustSection($sectionid, $priority, $sectiontime, $present)
{
    $sectionid = esc_or_null($sectionid, 'int');
    $priority = esc_or_null($priority, 'int');
    $sectiontime = esc_or_null($sectiontime, 'int');
    $present = $present ? 1 : 0;

    return db_exec("UPDATE :Section
                        SET Priority = $priority, StartTime = FROM_UNIXTIME($sectiontime), Present = $present
                        WHERE id = $sectionid");
}


// FIXME: What the hell this is doing for real?
function RemovePlayersDefinedforAnySection($a)
{
    list($round, $section) = $GLOBALS['RemovePlayersDefinedforAnySectionRound'];

    static $data;
    if (!is_array($data))
        $data = array();

    $key = sprintf("%d_%d", $round, $section);
    if (!isset($data[$key])) {
        $result = db_all("SELECT Player FROM :StartingOrder
                            INNER JOIN :Section ON :StartingOrder.Section = :Section.id
                            WHERE :Section.Round = $round");

        $mydata = array();
        foreach ($result as $row)
            $mydata[$row['Player']] = true;
        $data[$key] = $mydata;
    }

    return !@$data[$key][$a['PlayerId']];
}


function RemoveEmptySections($round)
{
    $sections = GetSections($round);
    foreach ($sections as $section) {
        $players = $section->GetPlayers();
        $id = esc_or_null($section->id, 'int');

        if (!count($players))
            db_exec("DELETE FROM :Section WHERE id = $id");
    }
}
