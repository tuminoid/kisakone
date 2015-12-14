<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Hole
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
require_once 'core/hole.php';


function GetHole($holeid)
{
    $holeid = esc_or_null($holeid, 'int');

    $result = db_one("SELECT :Hole.id, :Hole.Course, HoleNumber, HoleText, Par, Length,
                                :Course.id AS CourseId, :Round.id AS RoundId
                            FROM :Hole
                            LEFT JOIN :Course ON (:Course.id = :Hole.Course)
                            LEFT JOIN :Round ON (:Round.Course = :Course.id)
                            WHERE :Hole.id = $holeid
                            ORDER BY HoleNumber");

    if (db_is_error($result))
        return $result;

    return new Hole($result);
}


function SaveHole($hole)
{
    $par = esc_or_null($hole->par, 'int');
    $len = esc_or_null($hole->length, 'int');
    $number = esc_or_null($hole->holeNumber, 'int');
    $text = esc_or_null($hole->holeText, 'string');
    $id = esc_or_null($hole->id, 'int');
    $course = esc_or_null($hole->course, 'int');

    if ($hole->id)
        return db_exec("UPDATE :Hole SET Par = $par, Length = $len, HoleNumber = $number, HoleText = $text WHERE id = $id");

    return db_exec("INSERT INTO :Hole (Par, Length, Course, HoleNumber, HoleText) VALUES ($par, $len, $course, $number, $text)");
}
