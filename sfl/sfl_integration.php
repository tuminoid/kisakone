<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Functionality used exclusively for Suomen Frisbeegolfliitto.
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

define('SFL_API_SERVER', "http://127.0.0.1:8082");

require_once 'config.php';


/**
 * sfl_api_settings
 *
 * Check sanity of SFL settings we import from global $settings
 *
 * @return array for usable settings
 * @return false for bad settings
 */
function sfl_api_settings()
{
    global $settings;

    if ($settings['SFL_ENABLED'] != true)
        return false;

    $username = @$settings['SFL_USERNAME'];
    if (empty($username) || strlen($username) <= 0)
        return false;

    $password = @$settings['SFL_PASSWORD'];
    if (empty($password) || strlen($password) <= 0)
        return false;

    return array($username, $password);
}

function sfl_api_sendRequest($url)
{
    if (!$url)
        return null;

    list($username, $password) = sfl_api_settings();
    if (!$username || !$password)
        return null;

    $request_url = SFL_API_SERVER . $url;
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($curl, CURLOPT_URL, $request_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FAILONERROR, 1);
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    $decoded = null;
    if ($http_code == 200) {
        $decoded = json_decode($response, true);

        if (!$decoded)
            error_log("Getting data for '$request_url' failed, response =\n" . print_r($response, true));
    }
    else {
        $error = curl_error($curl);
        error_log("Getting player data failed: code $http_code, " . $error);
    }

    curl_close($curl);
    return $decoded;
}

function sfl_api_parseLicenses($data)
{
    // For development/club use purposes
    if (IGNORE_PAYMENTS == true)
        return array('a' => true, 'b' => true, 'membership' => true);

    if (!$data)
        return array('a' => false, 'b' => false, 'membership' => false);

    $membership = $data['membership'] ? true : false;
    $a = (isset($data['a_license']) && $data['a_license']) ? true : false;
    $b = (isset($data['b_license']) && $data['b_license']) ? true : false;

    return array('a' => $a, 'b' => $b, 'membership' => $membership);
}

function SFL_getLicensesByName($firstname, $lastname, $birthdate, $year = null)
{
    $birthdate = (int) $birthdate;
    $year = $year ? $year : date('Y');
    $url = "/sfl/license/$year/name/$firstname/$lastname/$birthdate";

    return sfl_api_parseLicenses(sfl_api_sendRequest($url));
}

function SFL_getLicensesById($sflid, $year = null)
{
    $sflid = (int) $sflid;
    $year = $year ? $year : date('Y');
    $url = "/sfl/license/$year/sfl/$sflid";

    return sfl_api_parseLicenses(sfl_api_sendRequest($url));
}

function SFL_getLicensesByPDGA($pdga, $year = null)
{
    $pdga = (int) $pdga;
    $year = $year ? $year : date('Y');
    $url = "/sfl/license/$year/pdga/$pdga";

    return sfl_api_parseLicenses(sfl_api_sendRequest($url));
}

function SFL_getLicenses($userid, $year = null)
{
    $userid = (int) $userid;
    $year = $year ? $year : date('Y');

    $query = format_query("SELECT UserFirstname, UserLastname, SflId, :Player.pdga AS PDGA,
                                YEAR(:Player.birthdate) AS Birthdate
                            FROM :User
                            INNER JOIN :Player ON :User.Player = :Player.player_id
                            WHERE :User.id = $userid");
    $result = execute_query($query);

    if (!$result)
        return null;

    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $sflid = $row['SflId'];
        $pdga = $row['PDGA'];
        $firstname = $row['UserFirstname'];
        $lastname = $row['UserLastname'];
        $birthdate = $row['Birthdate'];
        mysql_free_result($result);

        if ($row['SflId'] > 0)
            return SFL_getLicensesById($sflid, $year);

        if ($row['PDGA'] > 0)
            return SFL_getLicensesByPDGA($pdga, $year);

        return SFL_getLicensesByName($firstname, $lastname, $birthdate, $year);
    }

    return null;
}
