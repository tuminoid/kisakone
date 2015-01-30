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


function GetAllTextContent($eventid)
{
   require_once 'core/textcontent.php';

   $retValue = array();
   $eventCond = $eventid ? " = " . (int) $eventid : " IS NULL";
   $eventid = esc_or_null($eventid, 'int');
   $query = format_query("SELECT id, Event, Title, Content, UNIX_TIMESTAMP(Date)
                                    Date, Type, `Order`  FROM :TextContent
                                    WHERE Event $eventCond AND Type !=  'news' ORDER BY `order`");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $temp = new TextContent($row);
         $retValue[] = $temp;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


function GetTextContent($pageid)
{
   if (empty($pageid))
      return null;

   $retValue = null;
   $id = (int) $pageid;
   $query = format_query("SELECT id, Event, Title, Content, Date, Type, `Order` FROM :TextContent WHERE id = $id ");
   $result = execute_query($query);

   if (mysql_num_rows($result) == 1) {
      $row = mysql_fetch_assoc($result);
      $retValue = new TextContent($row);
   }
   mysql_free_result($result);

   return $retValue;
}


function GetTextContentByEvent($eventid, $type)
{
   $retValue = null;
   $id = (int) $eventid;
   $type = escape_string($type);
   $eventCond = $id ? "= $id" : "IS NULL";

   $query = format_query("SELECT id, Event, Title, Content, Date, Type, `Order` FROM :TextContent WHERE event $eventCond AND `type` = '$type' ");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      $row = mysql_fetch_assoc($result);
      $retValue = new TextContent($row);
   }
   mysql_free_result($result);

   return $retValue;
}


function GetTextContentByTitle($eventid, $title)
{
   $retValue = null;
   $id = (int) $eventid;
   $title = mysql_real_escape_string($title);
   $eventCond = $id ? "= $id" : "IS NULL";

   $query = format_query("SELECT id, Event, Title, Content, Date, Type, `Order` FROM :TextContent WHERE event $eventCond AND `title` = '$title' ");
   $result = execute_query($query);

   if (mysql_num_rows($result) == 1) {
      $row = mysql_fetch_assoc($result);
      $retValue = new TextContent($row);
   }
   mysql_free_result($result);

   return $retValue;
}


function SaveTextContent($page)
{
   if (!is_a($page, 'TextContent'))
      return Error::notFound('textcontent');

   if (!$page->id) {
      $query = format_query("INSERT INTO :TextContent (Event, Title, Content, Date, Type, `Order`)
                       VALUES (%s, '%s', '%s', FROM_UNIXTIME(%d), '%s', %d)",
                       esc_or_null($page->event, "int"),
                       escape_string($page->title),
                       escape_string($page->content),
                       time(),
                       escape_string($page->type),
                       0);
   }
   else {
      $query = format_query("UPDATE :TextContent
                           SET
                              Title = '%s',
                              Content = '%s',
                              Date = FROM_UNIXTIME(%d),
                              `Type` = '%s'
                              WHERE id = %d",

                              mysql_real_escape_string($page->title),
                              mysql_real_escape_string($page->content),
                              time(),
                              $page->type,
                              (int) $page->id);
   }
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function DeleteTextContent($id)
{
   $query = format_query("DELETE FROM :TextContent WHERE id = %d", $id);
   execute_query($query);
}


