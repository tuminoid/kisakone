<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Functionality used exclusively for Suomen Frisbeegolfliitto.
 * SFL API access functions for checking licenses and other player data
 * that is stored in the SFL Jäsenrekisteri.
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

// We have a local API instance
define('SFL_API_SERVER', "http://127.0.0.1:8082");

require_once 'config.php';
require_once 'data/user.php';


/**
 * Parse settings from config.php
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


function sfl_api_curl_exec($url)
{
    global $curl;

    $creds = sfl_api_settings();
    if (!$creds)
        return null;

    list($username, $password) = $creds;
    if (!$username || !$password)
        return null;

    if (!$curl) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FAILONERROR, 1);
    }
    curl_setopt($curl, CURLOPT_URL, $url);

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);

    return array($response, $http_code, $error);
}

/**
 * Send curl request to API
 *
 * @param  string $url url (without server)
 * @return  returns decoded json data
 */
function sfl_api_sendRequest($url)
{
    if (!$url)
        return null;

    $request_url = SFL_API_SERVER . $url;
    list($response, $http_code, $error) = sfl_api_curl_exec($request_url);

    $decoded = null;
    if ($http_code == 200) {
        $decoded = json_decode($response, true);

        if (!$decoded)
            error_log("Getting data for '$request_url' failed, response =\n" . print_r($response, true));
    }
    else
        error_log("Getting SFL data failed: code $http_code, " . $error);

    return $decoded;
}


/**
 * Parse returned array into standard assoc array
 *
 * @param  array $data json decoded data
 * @return  returns assoc array of licenses [a, b, membership]
 */
function sfl_api_parseLicenses($data)
{
    // For development/club use purposes
    if (IGNORE_PAYMENTS == true)
        return array('a_license' => true, 'b_license' => true, 'membership' => true);

    if (!$data || $data['status'] == false)
        return array('a_license' => false, 'b_license' => false, 'membership' => false);

    $data['membership'] = isset($data['membership']) ? $data['membership'] : false;
    $data['a_license'] = isset($data['a_license']) ? $data['a_license'] : false;
    $data['b_license'] = isset($data['b_license']) ? $data['b_license'] : false;

    return $data;
}



/** ************************** ONLY FUNCTIONS BELOW SHOULD BE CALLED ***************************** */



/**
 * Get users licenses for a specific year, identified by traditional
 * firstname+lastname+birthyear combo.
 *
 * @param  string $firstname first name
 * @param  string $lastname last name
 * @param  int $birthdate year of birth
 * @param  int $year year to be checked
 * @return  returns assoc array of licenses [a, b, membership]
 */
function SFL_getLicensesByName($firstname, $lastname, $birthdate)
{
    $birthdate = (int) $birthdate;
    $url = "/sfl/name/$firstname/$lastname/$birthdate";

    return sfl_api_parseLicenses(sfl_api_sendRequest($url));
}


/**
 * Get users licenses for a specific year, identified by SFL ID number
 *
 * @param  int $sflId sfl id number
 * @param  int $year year to be checked
 * @return  returns assoc array of licenses [a, b, membership]
 */
function SFL_getLicensesById($sflid)
{
    $sflid = (int) $sflid;
    $url = "/sfl/id/$sflid";

    return sfl_api_parseLicenses(sfl_api_sendRequest($url));
}


/**
 * Get users licenses for a specific year, identified by PDGA number
 *
 * @param  int $pdga pdga number
 * @return  returns assoc array of licenses [a, b, membership]
 */
function SFL_getLicensesByPDGA($pdga)
{
    $pdga = (int) $pdga;
    $url = "/sfl/pdga/$pdga";

    return sfl_api_parseLicenses(sfl_api_sendRequest($url));
}


/**
 * Get users licenses for a specific year
 *
 * @param  int $userid internal userid
 * @return  returns assoc array of licenses [a, b, membership]
 */
function SFL_getPlayer($userid)
{
    $userid = (int) $userid;

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

        if ($sflid > 0) {
            $data = SFL_getLicensesById($sflid);
        }
        elseif ($pdga > 0) {
            $data =  SFL_getLicensesByPDGA($pdga);
        }
        else {
            $data = SFL_getLicensesByName($firstname, $lastname, $birthdate);
        }

        if (SaveClub(@$data['club_id'], @$data['club_name'], @$data['club_short']))
            SaveUserClub($userid, @$data['club_id']);
        SaveUserSflId($userid, @$data['sfl_id']);

        return $data;
    }

    return sfl_api_parseLicenses(null);
}
