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

require_once 'data/db.php';
require_once 'core/level.php';


// Gets an array of Level objects (optionally filtered by the Available bit)
function GetLevels($availableOnly = false)
{
    $where = $availableOnly ? "WHERE Available <> 0" : "";

    $result = db_all("SELECT id, Name, ScoreCalculationMethod, Available FROM :Level $where");

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new Level($row['id'], $row['Name'], $row['ScoreCalculationMethod'], $row['Available']);
    return $retValue;
}


// Gets a Level object by id
function GetLevelDetails($levelid)
{
    $levelid = esc_or_null($levelid, 'int');

    $row = db_one("SELECT id, Name, ScoreCalculationMethod, Available
                            FROM :Level
                            WHERE id = $levelid");

    if (db_is_error($row))
        return $row;

    return new Level($row['id'], $row['Name'], $row['ScoreCalculationMethod'], $row['Available']);
}


function EditLevel($id, $name, $method, $available)
{
    $id = esc_or_null($id, 'int');
    $name = esc_or_null($name, 'string');
    $method = esc_or_null($method, 'string');
    $available = $available ? 1 : 0;

    return db_exec("UPDATE :Level
                            SET Name = $name, ScoreCalculationMethod = $method, Available = $available
                            WHERE id = $id");
}


function CreateLevel($name, $method, $available)
{
    $name = esc_or_null($name, 'string');
    $method = esc_or_null($method, 'string');
    $available = $available ? 1 : 0;

    return db_exec("INSERT INTO :Level (Name, ScoreCalculationmethod, Available) VALUES ($name, $method, $available)");
}


function DeleteLevel($id)
{
    $id = esc_or_null($id, 'int');

    return db_exec("DELETE FROM :Level WHERE id = $id");
}


// Returns true if the provided level is being used in any event or tournament, false otherwise
function LevelBeingUsed($id)
{
    $id = esc_or_null($id, 'int');

    $row = db_one("SELECT (SELECT COUNT(*) FROM :Event WHERE Level = $id) AS Events,
                           (SELECT COUNT(*) FROM :Tournament WHERE Level = $id) AS Tournaments");

    return (($row['Events'] + $row['Tournaments']) > 0);
}
