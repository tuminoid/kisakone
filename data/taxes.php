<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data module for Taxes module.
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
require_once 'data/config.php';


function TaxesEnabled()
{
    return GetConfig(TAXES_ENABLED);
}


function GetEventTaxes($eventid)
{
    $eventid = esc_or_null($eventid, 'int');

    return db_all("SELECT * FROM :EventTaxes WHERE Event = $eventid");
}


function SavePlayerTaxes($playerid, $eventid, $pro = 0, $am = 0, $other = 0)
{
    $playerid = esc_or_null($playerid, 'int');
    $eventid = esc_or_null($eventid, 'int');
    $pro = esc_or_null($pro, 'int');
    $am = esc_or_null($am, 'int');
    $other = esc_or_null($other, 'int');

    return db_exec("REPLACE INTO :EventTaxes (Event, Player, ProPrize, AmPrize, OtherPrize)
                        VALUES($eventid, $playerid, $pro, $am, $other)");
}

function GetPlayerTaxes($playerid, $eventid)
{
    $eventid = esc_or_null($eventid, 'int');
    $playerid = esc_or_null($playerid, 'int');

    return db_one("SELECT * FROM :EventTaxes WHERE Event = $eventid AND Player = $playerid");
}

