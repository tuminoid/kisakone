<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for TextContent
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


function GetAllTextContent($eventid)
{
    $eventCond = $eventid ? " = " . esc_or_null($eventid, 'int') : " IS NULL";

    $result = db_all("SELECT id, Event, Title, Content, UNIX_TIMESTAMP(Date) AS Date, Type, `Order`
                        FROM :TextContent
                        WHERE Event $eventCond AND Type != 'news'
                        ORDER BY `Order`");

    if (db_is_error($result))
        return null;

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new TextContent($row);
    return $retValue;
}


function GetTextContent($pageid)
{
    $id = esc_or_null($pageid, 'int');

    $row = db_one("SELECT id, Event, Title, Content, Date, Type, `Order`
                        FROM :TextContent
                        WHERE id = $id");

    if (db_is_error($row) || !$row)
        return null;

    return new TextContent($row);
}


function GetTextContentByEvent($eventid, $type)
{
    $type = esc_or_null($type);
    $eventCond = $eventid ? " = " . esc_or_null($eventid, 'int') : "IS NULL";

    $row = db_one("SELECT id, Event, Title, Content, Date, Type, `Order`
                        FROM :TextContent
                        WHERE event $eventCond AND type = $type");

    if (db_is_error($row) || !$row)
        return null;

    return new TextContent($row);
}


function GetTextContentByTitle($eventid, $title)
{
    $title = esc_or_null($title, 'string');
    $eventCond = $eventid ? " = " . esc_or_null($eventid, 'int') : "IS NULL";

    $row = db_one("SELECT id, Event, Title, Content, Date, Type, `Order`
                            FROM :TextContent
                            WHERE event $eventCond AND Title = $title");

    if (db_is_error($row) || !$row)
        return null;

    return new TextContent($row);
}


function SaveTextContent($page)
{
    if (!is_a($page, 'TextContent'))
        return Error::NotFound('textcontent');

    $title = esc_or_null($page->title);
    $content = esc_or_null($page->content);
    $time = time();
    $type = esc_or_null($page->type);

    if (!$page->id) {
        $event = esc_or_null($page->event, 'int');
        $order = 0;

        return db_exec("INSERT INTO :TextContent (Event, Title, Content, Date, Type, `Order`)
                           VALUES ($event, $title, $content, FROM_UNIXTIME($time), $type, $order)");
    }

    $id = esc_or_null($page->id, 'int');

    return db_exec("UPDATE :TextContent
                        SET Title = $title, Content = $content, Date = FROM_UNIXTIME($time), Type = $type
                        WHERE id = $id");
}


function DeleteTextContent($id)
{
    $id = esc_or_null($id, 'int');

    db_exec("DELETE FROM :TextContent WHERE id = $id");
}
