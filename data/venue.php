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


// Gets an array of strings containing Venue names that match the searchQuery
function GetVenueNames($searchQuery = '')
{
   $retValue = array();
   $query = "SELECT DISTINCT Name FROM :Venue";
   $query .= " WHERE %s";
   $query .= " ORDER BY Name";
   $query = format_query($query, data_ProduceSearchConditions($searchQuery, array('Name')));
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result))
         $retValue[] = $row['Name'];
   }
   mysql_free_result($result);

   return $retValue;
}


/**
 * Function for setting the venue
 *
 * Returns venue id for success or an Error
 */
function GetVenueId($venue)
{
   $venueid = null;
   // Get the existing venue
   $query = format_query("SELECT id FROM :Venue WHERE Name = '%s'", mysql_real_escape_string( $venue));
   $result = execute_query($query);

   if (mysql_num_rows($result) >= 1) {
      $row = mysql_fetch_assoc($result);
      $venueid = $row['id'];
      mysql_free_result($result);
   }

   if (!isset($venueid)) {
      // Create a new venue
      $query = format_query("INSERT INTO :Venue (Name) VALUES ('%s')", mysql_real_escape_string( $venue));
      $result = execute_query($query);

      if (!$result)
         return Query::Error($query);

      $venueid = mysql_insert_id();
   }

   return $venueid;
}


