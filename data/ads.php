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

require_once 'data/db.php';
require_once 'core/ads.php';


function SaveAd($ad)
{
    $url = esc_or_null($ad->url);
    $imageurl = esc_or_null($ad->imageURL);
    $longdata = esc_or_null($ad->longData);
    $imagereference = esc_or_null($ad->imageReference);
    $type = esc_or_null($ad->type);
    $id = (int) $ad->id;

    $result = db_exec("UPDATE :AdBanner
                            SET URL = $url, ImageURL = $imageurl, LongData = $longdata, ImageReference = $imagereference, Type = $type
                            WHERE id = $id");
    if ($result === false)
        return Error::Query($query);
}


function GetAllAds($eventid)
{
    $eventCond = $eventid ? " = " . esc_or_null($eventid, 'int') : " IS NULL";

    $result = db_all("SELECT id, Event, URL, ImageURL, LongData, ImageReference, Type, ContentId
                            FROM :AdBanner
                            WHERE Event $eventCond");

    $retValue = array();
    foreach ($result as $row)
        $retValue[] = new Ad($row);

    return $retValue;
}


function GetAd($eventid, $contentid)
{
    $eventCond = $eventid ? " = " . esc_or_null($eventid, 'int') : " IS NULL";
    $contentid = esc_or_null($contentid);

    $result = db_one("SELECT id, Event, URL, ImageURL, LongData, ImageReference, Type, ContentId
                            FROM :AdBanner
                            WHERE Event $eventCond AND ContentId = $contentid");

    if (db_is_error($result) || empty($result))
        return null;

    return new Ad($result);
}


function InitializeAd($eventid, $contentid)
{
    $eid = esc_or_null($eventid, 'int');
    $cid = esc_or_null($contentid);
    $type = esc_or_null($eventid ? AD_EVENT_DEFAULT : AD_DEFAULT);

    $result = db_exec("INSERT INTO :AdBanner (Event, URL, ImageURL, LongData, ImageReference, Type, ContentId)
                            VALUES ($eid, NULL, NULL, NULL, NULL, $type, $cid)");

    if (db_is_error($result))
        return $result;

    return GetAd($eventid, $contentid);
}
