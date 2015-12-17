<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module. Init database connections and provide
 * data related utilities.
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

// This is a bit non-standard way of requiring this
// Upgrade scripts include this code and they cannot handle relative paths
require_once __DIR__ . '/../core/error.php';


/**
 * Connects to the database
 *
 * @return Null on success
 * @return Error object on failure
 */
function db_connect()
{
    global $settings;
    static $con;

    if (!$con) {
        $con = @mysqli_connect($settings['DB_ADDRESS'], $settings['DB_USERNAME'], $settings['DB_PASSWORD'], $settings['DB_DB']);

        if (mysqli_connect_errno())
            error_log("fatal: db connect failure: " . mysqli_connect_error());
    }

    return $con;
}


/**
 * Escapes string
 *
 * @param string $string string to escape
 * @return escaped string
 */
function escape_string($string)
{
    return mysqli_real_escape_string(db_connect(), $string);
}


/**
 * Returns $param as a database safe string surrounded by apostrophes
 *
 * @param mixed $param item to quote
 * @return 'NULL' if $param is null
 * @return On success, string good for sql insertion
 */
function esc_or_null($param, $type = 'string')
{
    $retValue = "NULL";

    if ($param !== null) {
        switch ($type) {
            case 'string':
                $retValue = "'" . escape_string($param) . "'";
                break;

            case 'long':
            case 'int':
                $retValue = (int) $param;
                break;

            case 'double':
            case 'float':
            case 'decimal':
                $retValue = (float) $param;
                break;

            case 'gender':
                $param = strtoupper($param);
                if ($param == 'M' || $param == 'F')
                    $retValue = "'" . $param . "'";
                break;

            case 'bool':
                $retValue = $param ? 1 : 0;
                break;

            case 'key':
                $retValue = '`' . escape_string($param) . '`';
                break;

            default:
                die("Unknown type: $type (param = $param)");
                break;
        }
    }

    return $retValue;
}


/**
 * Formats SQL query to match the database naming, ie. replaces : with db_prefix
 *
 * FIXME: Find a more reasonable way to sanitize prefix without touching content
 * NOTE: Thanks to str_replace semantics, EventXXX must be before Event etc
 * TODO: MembershipPayment and LicensePayment tables are dropped in 2016.01.01.
 *
 * @param string $query actual SQL query to format
 * @return formatted SQL that is prefixed correctly
 */
function format_query($query)
{
    global $settings;
    $prefix = $settings['DB_PREFIX'];

    $tables = array(':Config', ':Club', ':Player', ':User', ':Venue', ':Level',
        ':File', ':AdBanner', ':EventQueue', ':EventManagement', ':Event', ':TextContent',
        ':Classification', ':Course', ':RoundResult', ':Round', ':Participation',
        ':HoleResult', ':Hole', ':StartingOrder', ':SectionMembership', ':Section',
        ':TournamentStanding', ':Tournament', ':ClassInEvent',
        ':RegistrationRules', ':PDGAPlayers', ':PDGAStats', ':PDGAEvents',
        ':MembershipPayment', ':LicensePayment'
    );
    $realtables = str_replace(":", $prefix, $tables);

    return str_replace($tables, $realtables, $query);
}


/**
 * Executes raw SQL query and return you mysql result object
 *
 * @param string $query SQL query to run
 * @return false on failure
 * @return result object on success
 */
function db_query($query)
{
    if (empty($query))
        return false;

    $conn = db_connect();
    if (!$conn)
        return false;

    $query = format_query($query);
    $result = mysqli_query($conn, $query);
    if (!$result)
        $result = debug_query_and_die($query);

    return $result;
}


function db_exec($query)
{
    if (empty($query))
        return false;

    $conn = db_connect();
    $result = db_query($query);

    if (!$result)
        return Error::Query($query, mysqli_error($conn));
    if (is_a($result, 'Error'))
        return $result;

    $words = explode(" ", trim($query));
    $keyword = strtolower($words[0]);
    switch ($keyword) {
        case "insert":
        case "replace":
            $retValue = mysqli_insert_id($conn);
            break;

        case "update":
        case "delete":
            $retValue = mysqli_affected_rows($conn);
            break;

        default:
            $retValue = true;
            break;
    }

    if (is_resource($result))
        mysqli_free_result($result);

    return $retValue;
}


function db_all($query)
{
    if (empty($query))
        return false;

    $conn = db_connect();
    $result = db_query($query);

    if (!$result)
        return Error::Query($query, mysqli_error($conn));
    if (is_a($result, 'Error'))
        return $result;

    $retArray = array();
    while ($array = mysqli_fetch_assoc($result))
        $retArray[] = $array;
    mysqli_free_result($result);

    return $retArray;
}


function db_one($query)
{
    $result = db_all($query);

    if (db_is_error($result))
        return $result;

    if (!is_array($result) || empty($result))
        return null;

    return $result[0];
}


function db_is_error($error)
{
    return (is_a($error, 'Error') || $error === false);
}


/**
 * Log information about a query for debug purposes.
 *
 * If 'DB_ERROR_LOGGING' is set to true in config.php,
 * print out stack trace in error log.
 *
 * If 'DB_ERROR_DIE' is set to true, dump the stack
 * on browser too. DO NOT DO THIS ON PRODUCTION!
 *
 * You need to have 'php5-xdebug' module installed
 */
function debug_query_and_die($query)
{
    require_once 'data/config.php';

    $db_error_log = GetConfig(DEVEL_DB_LOGGING);
    $conn = db_connect();

    if ($db_error_log) {
        error_log("query: $query");
        error_log("mysql error: " . mysqli_error($conn));

        $cnt = 1;
        foreach (xdebug_get_function_stack() as $line) {
            $out = sprintf("%2d: %s(%s) %s:%d", $cnt++,
                $line['function'], implode(", ", $line['params']),
                $line['file'], $line['line']
            );
            error_log($out);
        }
    }

    $db_error_die = GetConfig(DEVEL_DB_DIEONERROR);
    if ($db_error_die) {
        header("Content-Type: text/plain; charset=utf-8");
        xdebug_print_function_stack();
        xdebug_var_dump($query);
        xdebug_var_dump(mysqli_error($conn));

        die();
    }

    return Error::Query($query, mysqli_error($conn));
}


/**
 * Simple helper function to pick one of two values
 *
 * FIXME: this is stupid function
 *
 * @param mixed $a secondary item
 * @param mixed $b primary item
 * @return If B is defined, return B, else A
 */
function data_GetOne($a, $b)
{
    if ($b)
        return $b;
    return $a;
}
