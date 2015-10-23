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
require_once 'core/hole.php';


function GetCourseHoles($courseid)
{
    $courseid = (int) $courseid;

    $query = format_query("SELECT id, Course, HoleNumber, HoleText, Par, Length
                            FROM :Hole
                            WHERE Course = $courseid
                            ORDER BY HoleNumber");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = new Hole($row);
    }
    mysql_free_result($result);

    return $retValue;
}


function CourseUsed($courseid)
{
    $courseid = (int) $courseid;

    $query = format_query("SELECT id FROM :Round WHERE :Round.Course = $courseid LIMIT 1");
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

    $retVaue = array();
    while (($row = mysql_fetch_assoc($result)) !== false)
        $retValue[] = $row;
    mysql_free_result($result);

    return $retValue;
}


function GetCourseDetails($id)
{
    $id = (int) $id;

    $query = format_query("SELECT id, Name, Description, Link, Map, Event FROM :Course WHERE id = $id");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $retValue = null;
    if (mysql_num_rows($result) > 0)
        $retValue = mysql_fetch_assoc($result);
    mysql_free_result($result);

    return $retValue;
}


function SaveCourse($course)
{
    $name = esc_or_null($course['Name']);
    $description = esc_or_null($course['Description']);
    $link = esc_or_null($course['Link']);
    $map = esc_or_null($course['Map']);

    if ($course['id']) {
        $id = (int) $course['id'];

        $query = format_query("UPDATE :Course
                                SET Name = $name, Description = $description, Link = $link, Map = $map
                                WHERE id = $id");
        $result = execute_query($query);

        if (!$result)
            return Error::Query($query);
    }
    else {
        $eventid = esc_or_null(@$course['Event'], 'int');

        $query = format_query("INSERT INTO :Course (Name, Description, Link, Map, Event)
                                VALUES ($name, $description, $link, $map, $eventid)");
        $result = execute_query($query);

        if (!$result)
            return Error::Query($query);

        return mysql_insert_id();
    }
}


function DeleteCourse($id)
{
    $id = (int) $id;

    execute_query(format_query("DELETE FROM :Hole WHERE Course = $id"));
    execute_query(format_query("DELETE FROM :Course WHERE id = $id"));
}
