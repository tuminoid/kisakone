<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module. Init database connections.
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
 * Connects to the database
 */
function InitializeDatabaseConnection()
{
    $retValue = null;
    global $settings;
    $con = @mysql_connect($settings['DB_ADDRESS'], $settings['DB_USERNAME'], $settings['DB_PASSWORD']);

    if (!($con && @mysql_select_db($settings['DB_DB']))) {
        $retValue = new Error();
        $retValue->isMajor = true;
        $retValue->title = 'error_db_connection';
        $retValue->description = translate('error_db_connection_description');
    }

    return $retValue;
}


/**
 * Formats SQL query to match the database naming, ie. replaces : with db_prefix
 *
 */
function data_query($query)
{
    static $prefix = false;
    if ($prefix === false) {
       global $settings;
        $prefix = $settings['DB_PREFIX'];
    }

    $query = str_replace(':', $prefix, $query);
    $args = func_get_args();
    $args[0] = $query;

    return call_user_func_array('sprintf', $args);
}


/**
 * Simple helper function to pick one of two values
 */

function data_GetOne($a, $b)
{
    if ($b)
        return $b;
    return $a;
}
