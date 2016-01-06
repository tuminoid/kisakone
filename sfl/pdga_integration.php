<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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

const PDGA_API_SERVER = "https://api.pdga.com";

require_once 'data/db.php';
require_once 'core/cache.php';
require_once 'data/configs.php';


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
    if (pdga_enabled() != true)
        return false;

    $username = GetConfig(PDGA_USERNAME);
    if (empty($username) || strlen($username) <= 0)
        return false;

    $password = GetConfig(PDGA_PASSWORD);
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
    $session = cache_get('pdga_session');
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

    cache_set('pdga_session', $session, 15*60);

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
            error_log("Getting data for PDGA#$pdga_number failed, status= '" . @$decoded['status'] .
                "', message='" . @$decoded['message'] . "'");
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
function pdga_db_getLastUpdated($pdga_number = 0)
{
    $row = db_one("SELECT UNIX_TIMESTAMP(last_updated) AS last_update
                            FROM :PDGAPlayers
                            WHERE pdga_number = $pdga_number");

    if (db_is_error($row) || !$row)
        return 0;

    return (isset($row['last_update']) ? $row['last_update'] : 0);
}


/**
 * Get player data from PDGA API and update it into our :PDGAPlayers table.
 *
 * @param int $pdga_number PDGA number to get
 * @param bool $force force fetching new data from PDGA
 * @return true on success
 * @return false on failure
 */
function pdga_db_updatePlayer($pdga_number, $force = false)
{
    $last_update = pdga_db_getLastUpdated($pdga_number);
    $update_threshold = 24 * 60 * 60;

    if ($force || ($last_update + $update_threshold) < time()) {
        $data = pdga_api_getPlayer($pdga_number);

        if (!is_array($data))
            return false;

        unset($data['sessid']);
        unset($data['full_name']);
        $extra = "";
        foreach ($data as $key => $value) {
            $data[$key] = escape_string($value);
            $extra .= ", $key = '" . $data[$key] ."'";
        }

        $keys = implode(", ", array_keys($data));
        $vals = "'" . implode("', '", array_values($data)) . "'";

        db_exec("INSERT INTO :PDGAPlayers (last_updated, $keys) VALUES(NOW(), $vals)
                    ON DUPLICATE KEY UPDATE last_updated=NOW() $extra");

        $cache_key = "data_" . $pdga_number;
        cache_set($cache_key, pdga_db_getPlayer($pdga_number), $update_threshold);
    }
}


/**
 * Get player data from local PDGA DB.
 *
 * @param int $pdga_number PDGA number to get
 * @return null on failure, array on success
 */
function pdga_db_getPlayer($pdga_number)
{
    return db_one("SELECT * FROM :PDGAPlayers WHERE pdga_number = $pdga_number");
}



/* ************ ONlY FUNCTIONS CALLED OUTSIDE SHOULD BE ONES BELOW ************** */



/**
 * pdga_testCredentials
 *
 * Login to PDGA API and return session cookie.
 *
 * @return session on success
 * @return null on failure
 */
function pdga_testCredentials($username = null, $password = null)
{
    if (!($username && $password))
        return false;

    $request_url = PDGA_API_SERVER . '/services/json/user/login';
    $user_data = array('username' => $username, 'password' => $password);

    $user_data = http_build_query($user_data);
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FAILONERROR, 1);
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($http_code != 200)
        return false;

    return true;
}


/**
 * pdga_getPlayer
 *
 * Gets all fields from player's data.
 * If player data was fetched from API, it is in cache.
 * Otherwise it is in DB and is fetched from there.
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

    $cache_key = "data_" . $pdga_number;
    $data = cache_get($cache_key);
    if ($data)
        return $data;

    pdga_db_updatePlayer($pdga_number, $force);

    return pdga_db_getPlayer($pdga_number);
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


/**
 * SmartifyPDGA
 *
 * Put all pdga_data into a smarty variables for template use
 *
 * @param smarty $smarty smarty object
 * @param mixed $pdga_data data from pdga_getPlayer call
 */
function SmartifyPDGA(&$smarty, $pdga_data)
{
    if (!$smarty || !$pdga_data) {
        $smarty->assign('pdga', false);
        return null;
    }

    $smarty->assign('pdga', @$pdga_data['pdga_number']);
    $smarty->assign('pdga_rating', @$pdga_data['rating']);
    $smarty->assign('pdga_classification', @$pdga_data['classification']);
    $smarty->assign('pdga_birth_year', @$pdga_data['birth_year']);
    $smarty->assign('pdga_gender', @$pdga_data['gender']);
    $smarty->assign('pdga_membership_status', @$pdga_data['membership_status']);
    $smarty->assign('pdga_membership_expiration_date', @$pdga_data['membership_expiration_date']);
    $smarty->assign('pdga_official_status', @$pdga_data['official_status']);
    $smarty->assign('pdga_city', @$pdga_data['city']);
    $smarty->assign('pdga_state', @$pdga_data['state']);
    $smarty->assign('pdga_country', strtoupper(@$pdga_data['country']));
}



/**
 * Is PDGA enabled
 *
 * @return  true if PDGA API is enabled
 */
function pdga_enabled()
{
    return GetConfig(PDGA_ENABLED);
}
