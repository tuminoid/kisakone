<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for News
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
require_once 'core/textcontent.php';


function GetEventNews($eventid, $from, $count)
{
    $eventid = (int) $eventid;
    $from = (int) $from;
    $count = (int) $count;

    $query = format_query("SELECT id, Event, Title, Content, UNIX_TIMESTAMP(Date) AS Date, Type, `Order`
                            FROM :TextContent
                            WHERE Event = $eventid AND Type = 'news'
                            ORDER BY `date` DESC
                            LIMIT $from, $count");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = new TextContent($row);
    }
    mysql_free_result($result);

    return $retValue;
}
