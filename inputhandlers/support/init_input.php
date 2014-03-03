<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Input handler initializing
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

function input_ParseDate($date)
{
    return strtotime($date);
}

function input_GetUser($user)
{
    if (strpos($user, ' ') === false) {
        return GetUserId($user);
    }

    if (preg_match('/^\pL+\s+\pL+\s*\(([\pL\d_]+)\)$/u', $user, $matches)) {
        return GetUserId($matches[1]);
    }

    if (preg_match('/^([\pL\d]+)\s*\(\pL+\s+\pL+\)$/u', $user, $matches)) {
        return GetUserId($matches[1]);
    }

    return null;
}

function input_CombinePostArray($prefix)
{
    $output = array();
    $len = strlen($prefix);

    foreach ($_POST as $key => $value) {
        if (substr($key, 0, $len) == $prefix) $output[] = $value;
    }

    return $output;
}
