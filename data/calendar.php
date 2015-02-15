<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for creating AddThisEvent calendar widgets
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
require_once 'core/url.php';


function SmartifyCalendar($smarty, $eventid)
{
    $eventid = (int) $eventid;

    if (!$smarty)
        return null;

    $query = format_query("SELECT :Event.id as id,
                                DATE_FORMAT(Date, '%d.%m.%Y') AS start, DATE_FORMAT(Date, '%d-%m-%Y') AS start_data,
                                DATE_FORMAT(Date + INTERVAL Duration - 1 DAY, '%d.%m.%Y') AS end,
                                    DATE_FORMAT(Date + INTERVAL Duration - 1 DAY, '%d-%m-%Y') AS end_data,
                                DATE_FORMAT(Date, '%d') AS day, DATE_FORMAT(Date, '%m') AS month,
                                :Event.Name AS title, ContactInfo AS organizer,
                                :Venue.Name AS location
                            FROM :Event
                            LEFT JOIN :Venue ON :Venue.id = :Event.Venue
                            WHERE :Event.id = $eventid");
    $result = execute_query($query);

    if (!$result)
        return null;

    $retValue = null;
    while (($row = mysql_fetch_assoc($result)) !== false)
        $retValue = $row;
    mysql_free_result($result);

    $retValue['url'] = serverURL() . url_smarty(array('page' => 'event', 'id' => $eventid), $eventid);
    $smarty->assign('calendar', $retValue);

    error_log(print_r($retValue, true));
}
