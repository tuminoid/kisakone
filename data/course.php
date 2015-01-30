<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
*
 * Data access module for Course
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


function GetCourseHoles($courseId)
{
   require_once 'core/hole.php';

   $retValue = array();
   $query= format_query("SELECT id, Course, HoleNumber, HoleText, Par, Length FROM :Hole
                         WHERE Course = %d
                         ORDER BY HoleNumber", $courseId);
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      $index = 1;
      while ($row = mysql_fetch_assoc($result)) {
         $hole =  new Hole($row);
         $retValue[] = $hole;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


function CourseUsed($courseId)
{
   $query = format_query("SELECT id FROM `:Round` WHERE `:Round`.Course = %d LIMIT 1", $courseId);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   return mysql_num_rows($result) == 1;
}


function GetCourses()
{
   $query = format_query("SELECT id, Name, Event FROM :Course ORDER BY Name");
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $out = array();
   while (($row = mysql_fetch_assoc($result)) !== false)
      $out[] = $row;
   mysql_free_result($result);

   return $out;
}


function GetCourseDetails($id)
{
   $query = format_query("SELECT id, Name, Description, Link, Map, Event FROM :Course WHERE id = %d", $id);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   $out = null;
   while (($row = mysql_fetch_assoc($result)) !== false)
      $out = $row;
   mysql_free_result($result);

   return $out;
}


function SaveCourse($course)
{
   if ($course['id']) {
      $query = format_query("UPDATE :Course
                          SET Name = '%s',
                          Description = '%s',
                          Link = '%s',
                          Map = '%s'
                          WHERE id = %d",
                          escape_string($course['Name']),
                          escape_string($course['Description']),
                          escape_string($course['Link']),
                          escape_string($course['Map']),
                          $course['id']);
      $result = execute_query($query);

      if (!$result)
         return Error::Query($query);
   }
   else {
      $eventid = @$course['Event'];
      if (!$eventid)
         $eventid = null;

      $query = format_query("INSERT INTO :Course (Name, Description, Link, Map, Event)
                          VALUES ('%s', '%s', '%s', '%s', %s)",
                          escape_string($course['Name']),
                          escape_string($course['Description']),
                          escape_string($course['Link']),
                          escape_string($course['Map']),
                          esc_or_null($eventid, 'int'));
      $result = execute_query($query);

      if (!$result)
         return Error::Query($query);

      return mysql_insert_id();
   }
}



function DeleteCourse($id)
{
   $query = format_query("DELETE FROM :Hole WHERE Course = %d", $id);
   execute_query($query);

   $query = format_query("DELETE FROM :Course WHERE id = %d", $id);
   execute_query($query);
}


