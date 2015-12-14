<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Venue
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


// Gets an array of strings containing Venue names that match the searchQuery
function GetVenueNames($searchQuery = '')
{
    $search = data_ProduceSearchConditions($searchQuery, array('Name'));

    $result = db_all("SELECT DISTINCT Name FROM :Venue WHERE $search ORDER BY Name");

    if (db_is_error($result))
        return $result;

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = $row['Name'];
    return $retValue;
}


/**
 * Function for setting the venue
 *
 * FIXME: Implicit add if not exist?
 *
 * Returns venue id for success or an Error
 */
function GetVenueId($venue)
{
    $venue = esc_or_null($venue);

    $row = db_one("SELECT id FROM :Venue WHERE Name = $venue");

    $venueid = @$row['id'];

    if (!isset($venueid))
        $venueid = db_exec("INSERT INTO :Venue (Name) VALUES ($venue)");

    return $venueid;
}
