<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Registration Rules
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


function GetRuleTypes()
{
    return array('rating', 'country', 'player', 'status', 'co');
}


function GetRuleOps()
{
    return array('>', '>=', '<', '<=', '!=', '==');
}


function GetRuleActions()
{
    return array(/*'accept',*/ 'queue', 'reject');
}


function GetEventRules($eventid, $classid = -1)
{
    $eventid = (int) $eventid;

    if ($classid === -1)
        $where_class = "";
    elseif ($classid == null || $classid == 0)
        $where_class = "AND Classification IS NULL";
    else
        $where_class = "AND Classification = " . esc_or_null($classid);

    $query = format_query("SELECT :RegistrationRules.id AS id, Event, Classification, Type, Op, Value, Action,
                                DATE_FORMAT(ValidUntil, '%Y-%m-%d %H:%m') AS ValidUntil, NOW() < ValidUntil AS Valid,
                                :Classification.Name AS ClassName
                            FROM :RegistrationRules
                            LEFT JOIN :Classification ON :RegistrationRules.Classification = :Classification.id
                            WHERE Event = $eventid
                            $where_class
                            ORDER BY Classification ASC, ValidUntil");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = null;
    while (($row = mysql_fetch_assoc($result)) !== false)
        $retValue[] = $row;
    mysql_free_result($result);

    return $retValue;
}


function DeleteEventRules($eventid)
{
    $eventid = (int) $eventid;
    execute_query(format_query("DELETE FROM :RegistrationRules WHERE Event = $eventid"));
}


function SaveRule($ruleid, $eventid, $classid, $type, $op, $value, $action, $validuntil)
{
    $ruleid = esc_or_null($ruleid, 'int');
    $eventid = (int) $eventid;
    $classid = esc_or_null($classid, 'int');
    $type = esc_or_null($type);
    $op = esc_or_null($op);
    $value = esc_or_null($value);
    $action = esc_or_null($action);
    $validuntil = esc_or_null($validuntil);

    $query = format_query("INSERT INTO :RegistrationRules (id, Event, Classification, Type, Op, Value, Action, ValidUntil)
                            VALUES($ruleid, $eventid, $classid, $type, $op, $value, $action, $validuntil)
                            ON DUPLICATE KEY UPDATE Event = $eventid, Classification = $classid,
                            Type = $type, Op = $op, Value = $value, Action = $action, ValidUntil = $validuntil");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}
