<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
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
 * Escapes string
 */
function escape_string($string)
{
    InitializeDatabaseConnection();
    return mysql_real_escape_string($string);
}


/**
 * Formats SQL query to match the database naming, ie. replaces : with db_prefix
 *
 */
function format_query($query)
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
 * Formats and executes SQL query
 */
function execute_query($query)
{
    $dbError = InitializeDatabaseConnection();
    if ($dbError) {
        error_log("error: database connection init failed");
        return null;
    }

    if (empty($query))
        return null;

    $result = mysql_query($query);
    if (!$result) {
        global $settings;
        $db_error_log = $settings['DB_ERROR_LOGGING'];

        if (isset($db_error_log) && $db_error_log) {
            error_log("error: execute_query failed");
            error_log("query: $query");
            error_log("message: ". mysql_error());
        }
    }

    return $result;
}


/**
 * Log mysql errors properly
 */
function log_mysql_error($query, $line, $fatal = false)
{
   $err = mysql_error();
   $msg = "mysql_query('" . $query . "') => error: '" . $err . "' on line $line";

   if ($fatal)
      die($msg);

   error_log($msg);
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
