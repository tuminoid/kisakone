<?php
/**
 *
 * Copyright 2018 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Functionality used exclusively for Suomen Frisbeegolfliitto for Suomisport API.
 *
 */

/**
 * suomisport_api_settings
 *
 * Check sanity of pdga settings we import from global $settings
 *
 * @return array for usable settings
 * @return false for bad settings
 */
function suomisport_api_settings()
{
    if (pdga_enabled() != true)
        return false;

    $username = GetConfig(SUOMISPORT_USERNAME);
    if (empty($username) || strlen($username) <= 0)
        return false;

    $password = GetConfig(SUOMISPORT_PASSWORD);
    if (empty($password) || strlen($password) <= 0)
        return false;

    $api = GetConfig(SUOMISPORT_API);
    if (empty($api) || strlen($api) <= 0)
        return false;

    return array($username, $password, $api);
}


/**
 * Get license data from Suomisport API and update it into our DB
 *
 * @param int $sportid Sport id number
 * @param int $pdga_number PDGA number
 * @param int $birthyear
 * @return true on success
 * @return false on failure
 */
function suomisport_db_importLicense($sportid, $pdga_number, $birthyear)
{
    list($username, $password, $api) = suomisport_api_settings();

    $data = array('sportid' => $sportid, 'pdga' => $pdga_number, 'birthyear' => $birthyear);
    $user_data = json_encode($data);

    $request_url = $api . '/api/check-license';
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FAILONERROR, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($user_data)
    ));
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $http_message = curl_error($curl);
    $data = json_decode($response, true);
    curl_close($curl);

    if ($http_code == 200) {
        // This list must match database fields
        $white_data = array(
            "player_firstname", "player_lastname", "player_fullname", "player_birthyear",
            "player_sportid", "player_gender", "player_pdga", "player_nationality",
            "club_sportid", "club_name", "club_shortname",
            "licence_valid", "licence_valid_until"
        );

        $extra = "";
        foreach ($data as $key => $value) {
            if (!in_array($key, $white_data)) {
                error_log("Not whitelisted: pdga: $pdga_number key: $key value: $value");
                unset($data[$key]);
                continue;
            }
            $data[$key] = escape_string($value);
            $extra .= ", $key = '" . $data[$key] ."'";
        }

        $keys = implode(", ", array_keys($data));
        $vals = "'" . implode("', '", array_values($data)) . "'";
        db_exec("INSERT INTO :SuomisportLicenses (last_updated, $keys) VALUES(NOW(), $vals)
                    ON DUPLICATE KEY UPDATE last_updated=NOW() $extra");
        return true;
    }
    elseif ($http_code == 404) {
        // license not found
        return false;
    }
    else {
        // some other error
        error_log("unexpected Suomisport error: " . $http_message . ". User data: " . print_r($user_data));
        return false;
    }
}


/**
 * Get player license from local Suomisport DB
 *
 * @param int $sportid Sport id number
 * @param int $pdga_number PDGA number
 * @param int $birthyear
 * @param bool $force Force refetch from API
 * @return null on failure, array on success
 */
function suomisport_db_getLicense($sportid, $pdga_number, $birthyear, $force=false)
{
    if ($force === true)
        suomisport_db_importLicense($sportid, $pdga_number, $birthyear);

    return db_one("
        SELECT * FROM :SuomisportLicenses
        WHERE player_sportid = $sportid AND player_pdga = $pdga_number AND player_birthyear = $birthyear
    ");
}


/* ************ ONlY FUNCTIONS CALLED OUTSIDE SHOULD BE ONES BELOW ************** */

/**
 * suomisport_testCredentials
 *
 * Login to Suomisport API and return session cookie.
 *
 * @return session on success
 * @return null on failure
 */
function suomisport_testCredentials($username = null, $password = null, $api = null)
{
    if (!($username && $password && $api))
        return false;

    $data = array('sportid' => 0, 'pdga' => 0, 'birthyear' => 0);
    $user_data = json_encode($data);

    $request_url = $api . '/api/check-license';
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $user_data);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FAILONERROR, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($http_code != 404)
        return false;

    return true;
}


/**
 * suomisport_get_License
 *
 * Gets all fields from player's data.
 *
 * @param int $sportid Suomisport sport id
 * @param int $pdga_number PDGA number
 * @param int $birthyear Year of birth
 * @param bool $force Force refetch from API
 * @return data on success
 * @return null on failure
 */
function suomisport_getLicense($sportid = 0, $pdga_number = 0, $birthyear = 0, $force = false)
{
    if (!(is_numeric($sportid) && $sportid > 0))
        return null;

    if (!(is_numeric($pdga_number) && $pdga_number > 0))
        return null;

    if (!(is_numeric($birthyear) && $birthyear > 0))
        return null;

    return suomisport_db_getLicense($sportid, $pdga_number, $birthyear, $force);
}


/**
 * suomisport_update_License
 *
 * Gets all fields from player's data.
 *
 * @param int $sportid Suomisport sport id
 * @param int $pdga_number PDGA number
 * @param int $birthyear Year of birth
 * @return data on success
 * @return null on failure
 */
function suomisport_importLicense($sportid = 0, $pdga_number = 0, $birthyear = 0)
{
    if (!(is_numeric($sportid) && $sportid > 0))
        return null;

    if (!(is_numeric($pdga_number) && $pdga_number > 0))
        return null;

    if (!(is_numeric($birthyear) && $birthyear > 0))
        return null;

    return suomisport_db_importLicense($sportid, $pdga_number, $birthyear);
}


/**
 * SmartifySuomisport
 *
 * Put all suomisport data into a smarty variables for template use
 *
 * @param smarty $smarty smarty object
 * @param mixed $data data from suomisport_getLicense call
 */
function SmartifySuomisport(&$smarty, $data)
{
    if (!$smarty || !$data) {
        $smarty->assign('suomisport', false);
        return null;
    }

    $keys = array(
        "player_firstname", "player_lastname", "player_fullname", "player_birthyear",
        "player_sportid", "player_gender", "player_pdga", "player_nationality",
        "club_sportid", "club_name", "club_shortname",
        "licence_valid", "licence_valid_until"
    );

    foreach ($keys as $key) {
        $smarty->assign('suomisport_' . $key, $data[$key]);
        if ($key == "player_gender")
            $smarty->assign('suomisport_' . $key . '_short', substr($data[$key], 0, 1));
    }

    $smarty->assign('suomisport', true);
}
