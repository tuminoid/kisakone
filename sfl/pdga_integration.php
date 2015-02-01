<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
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

define('PDGA_SERVER', "https://api.pdga.com");

require_once 'config.php';

global $settings;


/*
 * pdga_getSession
 *
 * Login to PDGA API and return session cookie.
 *
 * Returns null on failure, session on success.
 */
function pdga_getSession()
{
    static $session;

    if ($session)
        return $session;

    $request_url = PDGA_SERVER . '/services/json/user/login';
    $user_data = array(
        'username' => $settings['PDGA_USERNAME'],
        'password' => $settings['PDGA_PASSWORD'],
    );

    $user_data = http_build_query($user_data);
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
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
        error_log("Getting PDGA session failed: ". $error);
        return null;
    }
    $session = $logged_user->session_name . '=' . $logged_user->sessid;

    curl_close($curl);
    return $session;
}


/*
 * pdga_getPlayer
 *
 * Get full assoc array of player data from PDGA API.
 *
 * Takes player's PDGA# as int as parameter.
 * Returns null on failure, assoc array on success.
 */
function pdga_getPlayer($pdga_number = 0)
{
    static $cache;

    if ($pdga_number == 0)
        return null;

    if (isset($cache{"$pdga_number"}))
        return $cache{"$pdga_number"};

    if (!($session = pdga_getSession()))
        return null;

    $request_url = PDGA_SERVER . '/services/json/member/' . $pdga_number;
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_COOKIE, $session);
    curl_setopt($curl, CURLOPT_URL, $request_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);

    if ($http_code == 200) {
        $decoded = json_decode($response, true);

        if (!$decoded || isset($decoded{"status"})) {
            error_log("Getting data for PDGA#$pdga_number failed, status " . $decoded{"status"});
            return null;
        }
        else
            $cache{"$pdga_number"} = $decoded;
    }
    else {
        $error = curl_error($curl);
        error_log("Getting player data failed: ". $error);
        return null;
    }

    curl_close($curl);
    return $decoded;
}


/*
 * pdga_getPlayerData
 *
 * Gets a single field from player's data. Defaults to "rating".
 *
 * Takes player's PDGA# as int as first parameter, field as second.
 * Returns given data as-is or null on failure, or invalid field.
 */
function pdga_getPlayerData($pdga_number = 0, $field = "rating")
{
    $data = pdga_getPlayer($pdga_number);
    if (!$data)
        return null;

    if (isset($data{$field}))
        return $data{$field};

    return null;
}


/*
 * pdga_getPlayerRating
 *
 * Get player's rating.
 *
 * Takes PDGA# as parameter.
 * Returns rating as int, or null on failure.
 */
function pdga_getPlayerRating($pdga_number = 0)
{
    return pdga_getPlayerData($pdga_number, "rating");
}
