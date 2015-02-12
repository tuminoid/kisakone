<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Functionality used exclusively for Suomen Frisbeegolfliitto for PDGA API.
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

define('PDGA_API_SERVER', "https://api.pdga.com");

require_once 'config.php';
require_once 'data/db_init.php';


/**
 * pdga_api_settings
 *
 * Check sanity of pdga settings we import from global $settings
 *
 * @return array for usable settings
 * @return false for bad settings
 */
function pdga_api_settings()
{
    global $settings;

    if ($settings['PDGA_ENABLED'] != true)
        return false;

    $username = @$settings['PDGA_USERNAME'];
    if (empty($username) || strlen($username) <= 0)
        return false;

    $password = @$settings['PDGA_PASSWORD'];
    if (empty($password) || strlen($password) <= 0)
        return false;

    return array($username, $password);
}

/**
 * pdga_api_getSession
 *
 * Login to PDGA API and return session cookie.
 *
 * @return session on success
 * @return null on failure
 */
function pdga_api_getSession()
{
    static $session;
    static $timeout;

    if ($timeout && $timeout > time())
        $session = null;

    if ($session)
        return $session;

    $credentials = pdga_api_settings();
    if (!$credentials)
        return null;

    $request_url = PDGA_API_SERVER . '/services/json/user/login';
    $user_data = array('username' => $credentials[0], 'password' => $credentials[1]);

    $user_data = http_build_query($user_data);
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FAILONERROR, 1);
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($http_code == 200) {
        $logged_user = json_decode($response);
    }
    else {
        $error = curl_error($curl);
        error_log("Getting PDGA session failed: " . $error);
        return null;
    }
    $session = $logged_user->session_name . '=' . $logged_user->sessid;
    curl_close($curl);

    $timeout = time() + 10 * 60;
    return $session;
}

/**
 * pdga_api_getPlayer
 *
 * Get full assoc array of player data from PDGA API.
 *
 * @param int $pdga_number Player's PDGA number
 * @return null on failure
 * @return assoc array on success
 */
function pdga_api_getPlayer($pdga_number = 0)
{
    if (!is_integer($pdga_number) || $pdga_number <= 0)
        return null;

    if (!($session = pdga_api_getSession()))
        return null;

    $request_url = PDGA_API_SERVER . '/services/json/member/' . $pdga_number;
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_COOKIE, $session);
    curl_setopt($curl, CURLOPT_URL, $request_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FAILONERROR, 1);
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($http_code == 200) {
        $decoded = json_decode($response, true);

        if (!$decoded || isset($decoded["status"])) {
            error_log("Getting data for PDGA#$pdga_number failed, status= " . @$decoded['status'] .
                "message='" . @$decoded['message']);
            return null;
        }
    }
    else {
        $error = curl_error($curl);
        error_log("Getting player data failed: code $http_code, " . $error);
        return null;
    }

    curl_close($curl);
    return $decoded;
}

/**
 * Access database to get last_updated field for player's status
 *
 * @param int $pdga_number PDGA number to get
 * @return time of last update on success
 * @return null on failure
 */
function pdga_api_getLastUpdated($pdga_number = 0)
{
    $query = "SELECT unix_timestamp(last_updated) AS last_update FROM pdga_players WHERE pdga_number = $pdga_number";
    $result = execute_query($query);

    if (!$result || mysql_num_rows($result) != 1)
        return 0;

    $row = mysql_fetch_assoc($result);
    mysql_free_result($result);

    return (isset($row['last_update']) ? $row['last_update'] : 0);
}

/**
 * Get player data from PDGA API and update it into our pdga_players table.
 *
 * @param int $pdga_number PDGA number to get
 * @return true on success
 * @return false on failure
 */
function pdga_api_updatePlayer($pdga_number)
{
    $data = pdga_api_getPlayer($pdga_number);

    if (!is_array($data))
        return false;

    unset($data['sessid']);
    foreach ($data as $key => $value)
        $data[$key] = escape_string($value);

    $keys = implode(", ", array_keys($data));
    $vals = "'" . implode("', '", array_values($data)) . "'";

    $query = "REPLACE INTO pdga_players ($keys, last_updated) VALUES($vals, NOW())";
    return execute_query($query);
}



/* ************ ONlY FUNCTIONS CALLED OUTSIDE SHOULD BE ONES BELOW ************** */



/**
 * pdga_getPlayer
 *
 * Gets all fields from player's data.
 * If data is more than one day old, fetch that said data from API.
 *
 * @param int $pdga_number PDGA number
 * @param bool $force force fetching new data from PDGA, instead of local db
 * @return data on success
 * @return null on failure
 */
function pdga_getPlayer($pdga_number = 0, $force = false)
{
    if (!(is_numeric($pdga_number) && $pdga_number > 0))
        return null;

    $last_update = pdga_api_getLastUpdated($pdga_number);
    if ($force || ($last_update + 24 * 60 * 60) < time())
        pdga_api_updatePlayer($pdga_number);

    $query = "SELECT * FROM pdga_players WHERE pdga_number = $pdga_number";
    $result = execute_query($query);

    if (!$result)
        return null;

    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        mysql_free_result($result);
        return $row;
    }

    return null;
}


/**
 * pdga_getPlayerData
 *
 * Gets a single field from player's data. Defaults to "rating".
 *
 * @param int $pdga_number PDGA number
 * @param string $field Key to return
 * @param bool $force force fetching new data from PDGA, instead of local db
 * @return data on success
 * @return null on failure or invalid field
 */
function pdga_getPlayerData($pdga_number = 0, $field = "rating", $force = false)
{
    $data = pdga_getPlayer($pdga_number, $force);
    if (!$data)
        return null;

    if (isset($data[$field]))
        return $data[$field];

    return null;
}

/**
 * pdga_getPlayerRating
 *
 * Get player's rating.
 *
 * @param int $pdga_number PDGA number
 * @param bool $force force fetching new data from PDGA, instead of local db
 * @return rating on success
 */
function pdga_getPlayerRating($pdga_number = 0, $force = false)
{
    return pdga_getPlayerData($pdga_number, "rating", $force);
}
