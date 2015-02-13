<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'data/db_init.php';
require_once 'core/textcontent.php';


function GetAllTextContent($eventid)
{
    $eventCond = $eventid ? " = " . (int) $eventid : " IS NULL";

    $query = format_query("SELECT id, Event, Title, Content, UNIX_TIMESTAMP(Date) AS Date, Type, `Order`
                            FROM :TextContent
                            WHERE Event $eventCond AND Type != 'news'
                            ORDER BY `Order`");
    $result = execute_query($query);

    $retValue = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result))
            $retValue[] = new TextContent($row);
    }
    mysql_free_result($result);

    return $retValue;
}


function GetTextContent($pageid)
{
    if (empty($pageid))
        return null;

    $id = (int) $pageid;

    $query = format_query("SELECT id, Event, Title, Content, Date, Type, `Order`
                            FROM :TextContent
                            WHERE id = $id");
    $result = execute_query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1)
        $retValue = new TextContent(mysql_fetch_assoc($result));
    mysql_free_result($result);

    return $retValue;
}


function GetTextContentByEvent($eventid, $type)
{
    $id = (int) $eventid;

    $type = esc_or_null($type);
    $eventCond = $id ? " = $id" : "IS NULL";

    $query = format_query("SELECT id, Event, Title, Content, Date, Type, `Order`
                            FROM :TextContent
                            WHERE event $eventCond AND type = $type");
    $result = execute_query($query);

    $retValue = null;
    if (mysql_num_rows($result) > 0)
        $retValue = new TextContent(mysql_fetch_assoc($result));
    mysql_free_result($result);

    return $retValue;
}


function GetTextContentByTitle($eventid, $title)
{
    $id = (int) $eventid;
    $title = esc_or_null($title);
    $eventCond = $id ? "= $id" : "IS NULL";

    $query = format_query("SELECT id, Event, Title, Content, Date, Type, `Order`
                            FROM :TextContent
                            WHERE event $eventCond AND Title = $title");
    $result = execute_query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1)
        $retValue = new TextContent(mysql_fetch_assoc($result));
    mysql_free_result($result);

    return $retValue;
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

        $query = format_query("INSERT INTO :TextContent (Event, Title, Content, Date, Type, `Order`)
                       VALUES ($event, $title, $content, FROM_UNIXTIME($time), $type, $order)");
    }
    else {
        $id = (int) $page->id;

        $query = format_query("UPDATE :TextContent
                                SET Title = $title, Content = $content, Date = FROM_UNIXTIME($time), Type = $type
                                WHERE id = $id");
    }
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}


function DeleteTextContent($id)
{
    $id = (int) $id;

    execute_query(format_query("DELETE FROM :TextContent WHERE id = $id"));
}
