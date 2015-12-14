<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Club
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
require_once 'core/club.php';


function GetClub($clubid)
{
    $clubid = esc_or_null($clubid, 'int');
    return db_one("SELECT id, Name, ShortName FROM :Club WHERE id = $clubid");
}


function GetUsersClub($userid)
{
    $userid = esc_or_null($userid, 'int');
    return db_one("SELECT Club FROM :User WHERE id = $userid");
}


function SaveClub($clubid, $clubname, $clubshort)
{
    if (!$clubname || !$clubshort)
        return null;

    $clubid = esc_or_null($clubid, 'int');
    $clubname = esc_or_null($clubname);
    $clubshort = esc_or_null($clubshort);

    return db_exec("INSERT INTO :Club VALUES($clubid, $clubname, $clubshort)
                            ON DUPLICATE KEY UPDATE Name = $clubname, ShortName = $clubshort");
}
