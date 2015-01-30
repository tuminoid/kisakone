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

require_once 'data/db_init.php';


function GetHoleDetails($holeid)
{
   require_once 'core/hole.php';

   $retValue = null;
   $holeid = (int) $holeid;
   $query = format_query("SELECT :Hole.id, :Hole.Course, HoleNumber, HoleText, Par, Length,
                         :Course.id CourseId, :Round.id RoundId FROM :Hole
                         LEFT JOIN :Course ON (:Course.id = :Hole.Course)
                         LEFT JOIN :Round ON (:Round.Course = :Course.id)
                         WHERE :Hole.id = $holeid
                         ORDER BY HoleNumber");
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   if (mysql_num_rows($result) > 0) {
      $index = 1;
      $row = mysql_fetch_assoc($result);
      $retValue =  new Hole($row);
   }
   mysql_free_result($result);

   return $retValue;
}


function SaveHole($hole)
{
   if ($hole->id) {
      $query = format_query("UPDATE :Hole SET Par = %d, Length = %d, HoleNumber = %d, HoleText = '%s' WHERE id = %d",
                       (int) $hole->par,
                       (int) $hole->length,
                       $hole->holeNumber,
                       $hole->holeText,
                       (int) $hole->id);
   }
   else {
      $query = format_query("INSERT INTO :Hole (Par, Length, Course, HoleNumber, HoleText) VALUES (%d, %d, %d, %d, '%s')",
                       (int) $hole->par,
                       (int) $hole->length,
                       (int) $hole->course,
                       $hole->holeNumber,
                       $hole->holeText);
   }
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


