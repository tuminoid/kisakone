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

require_once 'data/db_init.php';
require_once 'core/section.php';


// Get sections for a Round
function GetSections($round, $order = 'time')
{
    $roundid = (int) $round;

    if ($order == 'time')
        $order = "Priority, StartTime, Name";
    else
        $order = "Classification, Name";

    $query = format_query("SELECT :Section.id, Name, UNIX_TIMESTAMP(StartTime) AS StartTime,
                                Priority, Classification, Round, Present
                            FROM :Section
                            WHERE :Section.Round = $roundid
                            ORDER BY $order");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = new Section($row);
    }
    mysql_free_result($result);

    return $retValue;
}


// Gets a Section object by id
function GetSectionDetails($sectionId)
{
    $sectionId = (int) $sectionId;

    $query = format_query("SELECT id, Name, Round, Priority, UNIX_TIMESTAMP(StartTime) AS StartTime, Present, Classification
                            FROM :Section
                            WHERE id = $sectionId");
    $result = execute_query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1)
        $retValue = new Section(mysql_fetch_assoc($result));
    mysql_free_result($result);

    return $retValue;
}


function GetSectionMembers($sectionId)
{
    $sectionId = (int) $sectionId;

    $query = format_query("SELECT :Player.player_id AS PlayerId, :User.UserFirstName, :User.UserLastName,
                                :Player.pdga AS PDGANumber, :Player.firstname AS pFN, :Player.lastname AS pLN,
                                :Player.email AS pEM, :Classification.Name AS Classification,
                                SM.id AS MembershipId, :Participation.OverallResult
                            FROM :User
                            INNER JOIN :Player ON :User.Player = :Player.player_id
                            INNER JOIN :Participation ON :Player.player_id = :Participation.Player
                            INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                            INNER JOIN :SectionMembership SM ON SM.Participation = :Participation.id
                            WHERE SM.Section = $sectionId
                            ORDER BY :Participation.OverallResult DESC, SM.id");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            $row['FirstName'] = data_GetOne($row['UserFirstName'], $row['pFN']);
            $row['LastName'] = data_GetOne($row['UserLastName'], $row['pLN']);
            $retValue[] = $row;
        }
    }
    mysql_free_result($result);

    return $retValue;
}


function CreateSection($round, $baseClassId, $name)
{
    $round = (int) $round;
    $classid = esc_or_null($baseClassId, 'int');
    $name = esc_or_null($name);

    $query = format_query("INSERT INTO :Section(Round, Classification, Name, Present)
                            VALUES($round, $classid, $name, 1)");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    return mysql_insert_id();
}


function RenameSection($classId, $newName)
{
    $classId = (int) $classId;

    $newName = esc_or_null($newName);
    $query = format_query("UPDATE :Section SET Name = $newName WHERE id = $classId");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}


function AssignPlayersToSection($roundid, $sectionid, $playerids)
{
    $roundid = (int) $roundid;
    $sectionid = (int) $sectionid;

    $each = array();
    foreach ($playerids as $playerid)
        $each[] = sprintf("(%d, %d)", GetParticipationIdByRound($roundid, $playerid), $sectionid);

    $data = implode(", ", $each);
    $query = format_query("INSERT INTO :SectionMembership (Participation, Section) VALUES $data");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}


function AdjustSection($sectionid, $priority, $sectiontime, $present)
{
    $sectionid = (int) $sectionid;
    $priority = esc_or_null($priority, 'int');
    $sectiontime = esc_or_null($sectiontime, 'int');
    $present = $present ? 1 : 0;

    $query = format_query("UPDATE :Section
                            SET Priority = $priority, StartTime = FROM_UNIXTIME($sectiontime), Present = $present
                            WHERE id = $sectionid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
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
        $query = format_query("SELECT Player FROM :StartingOrder
                                INNER JOIN :Section ON :StartingOrder.Section = :Section.id
                                WHERE :Section.Round = $round");
        $result = execute_query($query);

        $mydata = array();
        while (($row = mysql_fetch_assoc($result)) !== false)
            $mydata[$row['Player']] = true;
        $data[$key] = $mydata;
        mysql_free_result($result);
    }

    return !@$data[$key][$a['PlayerId']];
}


function RemoveEmptySections($round)
{
    $round = (int) $round;

    $sections = GetSections($round);
    foreach ($sections as $section) {
        $players = $section->GetPlayers();
        $id = (int) $section->id;

        if (!count($players))
            execute_query(format_query("DELETE FROM :Section WHERE id = $id"));
    }
}
