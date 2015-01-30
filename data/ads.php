<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Ads
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


function SaveAd($ad)
{
   $query = format_query("UPDATE :AdBanner SET URL = %s, ImageURL = %s, LongData = %s, ImageReference = %s, Type = %s WHERE id = %d",
                  esc_or_null($ad->url),
                  esc_or_null($ad->imageURL),
                  esc_or_null($ad->longData),
                  esc_or_null($ad->imageReference),
                  esc_or_null($ad->type),
                  $ad->id);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function GetAllAds($eventid)
{
   $retValue = array();

   $eventCond = $eventid ? " = " . (int) $eventid : " IS NULL";
   $eventid =  esc_or_null( $eventid, 'int');
   $query = format_query("SELECT id, Event, URL, ImageURL, LongData, ImageReference, Type, ContentId  FROM :AdBanner WHERE Event $eventCond");
   $result = execute_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $temp = new Ad($row);
         $retValue[] = $temp;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


function GetAd($eventid, $contentId)
{
   require_once 'core/ads.php';
   $retValue = null;

   $eventCond = $eventid ? " = " . (int) $eventid : " IS NULL";
   $contentId = escape_string($contentId);
   $eventid =  esc_or_null( $eventid, 'int');
   $query = format_query("SELECT id, Event, URL, ImageURL, LongData, ImageReference, Type, ContentId
                     FROM :AdBanner WHERE Event $eventCond AND ContentId = '%s'", $contentId);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);

   if (mysql_num_rows($result) > 0) {
      $row = mysql_fetch_assoc($result);
      $retValue = new Ad($row);
   }
   mysql_free_result($result);

   return $retValue;
}


function InitializeAd($eventid, $contentId)
{
   require_once 'core/ads.php';
   $retValue = array();

   $contentId = escape_string($contentId);
   $query = format_query( "INSERT INTO :AdBanner (Event, URL, ImageURL, LongData, ImageReference, Type, ContentId)
                    VALUES (%s, NULL, NULL, NULL, NULL, '%s', '%s')",
                    esc_or_null($eventid, 'int'), ($eventid ? AD_EVENT_DEFAULT : AD_DEFAULT), escape_string($contentId));
   $result = execute_query($query);

   if (!$result)
     return Error::Query($query, 'InitializeAd');

   return GetAd($eventid, $contentId);
}


