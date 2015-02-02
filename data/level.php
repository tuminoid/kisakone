<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Level
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
require_once 'core/level.php';


// Gets an array of Level objects (optionally filtered by the Available bit)
function GetLevels($availableOnly = false)
{
    $query = "SELECT id, Name, ScoreCalculationMethod, Available FROM :Level";

    if ($availableOnly)
        $query .= " WHERE Available <> 0";
    $query = format_query($query);
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = new Level($row);
    }
    mysql_free_result($result);

    return $retValue;
}


// Gets a Level object by id
function GetLevelDetails($levelId)
{
    $levelId = (int) $levelId;

    $query = format_query("SELECT id, Name, ScoreCalculationMethod, Available FROM :Level WHERE id = $levelId");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) == 1)
        $retValue = new Level(mysql_fetch_assoc($result));
    mysql_free_result($result);

    return $retValue;
}


function EditLevel($id, $name, $method, $available)
{
    $id = (int) $id;
    $name = esc_or_null($name);
    $method = esc_or_null($method);
    $available = $available ? 1 : 0;

    $query = format_query("UPDATE :Level SET Name = $name, ScoreCalculationMethod = $method, Available = $available WHERE id = $id");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}


function CreateLevel($name, $method, $available)
{
    $name = esc_or_null($name);
    $method = esc_or_null($method);
    $available = $available ? 1 : 0;

    $query = format_query("INSERT INTO :Level (Name, ScoreCalculationmethod, Available) VALUES ($name, $method, $available)");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    return mysql_insert_id();
}


function DeleteLevel($id)
{
    $id = (int) $id;

    $query = format_query("DELETE FROM :Level WHERE id = $id");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}


// Returns true if the provided level is being used in any event or tournament, false otherwise
function LevelBeingUsed($id)
{
    $id = (int) $id;

    $query = format_query("SELECT (SELECT COUNT(*) FROM :Event WHERE Level = $id) AS Events,
                           (SELECT COUNT(*) FROM :Tournament WHERE Level = $id) AS Tournaments");
    $result = execute_query($query);

    $retValue = true;
    if (mysql_num_rows($result) > 0) {
        $temp = mysql_fetch_assoc($result);
        $retValue = ($temp['Events'] + $temp['Tournaments']) > 0;
    }
    mysql_free_result($result);

    return $retValue;
}
