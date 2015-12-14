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

require_once 'data/db.php';
require_once 'core/textcontent.php';


function GetEventNews($eventid, $from, $count)
{
    $eventid = esc_or_null($eventid, 'int');
    $from = esc_or_null($from, 'int');
    $count = esc_or_null($count, 'int');

    $result = db_all("SELECT id, Event, Title, Content, UNIX_TIMESTAMP(Date) AS Date, Type, `Order`
                            FROM :TextContent
                            WHERE Event = $eventid AND Type = 'news'
                            ORDER BY `date` DESC
                            LIMIT $from, $count");

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new TextContent($row);
    return $retValue;
}
