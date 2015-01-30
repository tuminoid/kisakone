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


function CreateFileRecord($filename, $displayname, $type)
{
   $query = format_query("INSERT INTO :File (Filename, DisplayName, Type) VALUES
                  ('%s', '%s', '%s')",
                  escape_string($filename),
                  escape_string($displayname),
                  escape_string($type));
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   return mysql_insert_id();
}


function GetFile($id)
{
   require_once 'core/files.php';

   $query = format_query("SELECT id, Filename, Type, DisplayName FROM :File WHERE id = %d", $id);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $row = mysql_fetch_Assoc($result);
   mysql_free_result($result);

   if ($row)
     return new File($row);
}


function GetFilesOfType($type)
{
   require_once 'core/files.php';

   $query = format_query("SELECT id, Filename, Type, DisplayName FROM :File WHERE Type = '%s' ORDER BY DisplayName", mysql_real_escape_string($type));
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $retValue = array();
   while (($row = mysql_fetch_Assoc($result)) !== false)
     $retValue[] = new File($row);
   mysql_free_result($result);

   return $retValue;
}


