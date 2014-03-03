<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * This file provides general functionality needed in the core module
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

/**
 * This function is used to convert fields names from database capitalized format
 * into the class field name format.
 *
 * Ie. db field User.Username
 * $field = core_ProduceFieldName("Username")
 * // $field == 'username'
 * $object->$field = $value  // works then
 *
 */
function core_ProduceFieldName($dbfield)
{
    return strtolower($dbfield[0]) . substr($dbfield, 1);
}

function core_sort_by_count($a, $b)
{
    $ac = count($a);
    $bc = count($b);
    if ($ac == $bc) return 0;
    if ($ac < $bc) return 1;
    return -1;
}
