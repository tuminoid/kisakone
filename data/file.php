<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for File
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
require_once 'core/files.php';



function CreateFileRecord($filename, $displayname, $type)
{
    $filename = esc_or_null($filename);
    $displayname = esc_or_null($displayname);
    $type = esc_or_null($type);

    $query = format_query("INSERT INTO :File (Filename, DisplayName, Type) VALUES ($filename, $displayname, $type)");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    return mysql_insert_id();
}


function GetFile($id)
{
    $id = (int) $id;

    $query = format_query("SELECT id, Filename, Type, DisplayName FROM :File WHERE id = $id");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = null;
    if (mysql_num_rows($result) > 0)
        $retValue = new File(mysql_fetch_assoc($result));
    mysql_free_result($result);

    return $retValue;
}


function GetFilesOfType($type)
{
    $type = esc_or_null($type);

    $query = format_query("SELECT id, Filename, Type, DisplayName FROM :File WHERE Type = $type ORDER BY DisplayName");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = array();
    while (($row = mysql_fetch_Assoc($result)) !== false)
        $retValue[] = new File($row);
    mysql_free_result($result);

    return $retValue;
}
