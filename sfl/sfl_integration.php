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

require_once 'data/db_init.php';
require_once 'data/user.php';


/**
 * Run direct database query on player data based on where condition
 *
 * @param  string $where where clause
 * @return array if player data
 */
function sfl_api_run_query($where)
{
    $query = "SELECT year, license,
                sfl_player.pdga, sfl_player.sfl_id, sfl_clubs.club_id,
                CAST(CAST(sfl_clubs.club_name AS char character set utf8) AS binary) AS club_name,
                CAST(CAST(sfl_clubs.club_short AS char character set utf8) AS binary) AS club_short,
                CAST(CAST(sfl_player.firstname AS char character set utf8) AS binary) AS firstname,
                CAST(CAST(sfl_player.lastname AS char character set utf8) AS binary) AS lastname,
                YEAR(sfl_player.birthdate) AS birthyear, sfl_player.email,
                UPPER(SUBSTR(sfl_player.sex, 1, 1)) AS gender
            FROM sfl_membership
            INNER JOIN sfl_player ON (sfl_player.player_id = sfl_membership.player_id)
            INNER JOIN sfl_clubs ON (sfl_player.club_id = sfl_clubs.club_id)
            $where";
    $result = execute_query($query);

    if (!$result)
        return null;

    $rows = null;
    while (($row = mysql_fetch_assoc($result)) !== false)
        $rows[] = $row;
    mysql_free_result($result);

    $result = array();
    $result['status'] = false;
    $year = null;
    foreach ($rows as $line => $row) {
        foreach (array_keys($row) as $key) {
            switch ($key) {
                case 'year':
                    $year = $row['year'];
                    break;

                case 'license':
                    if ($row['license'] == LICENSE_MEMBERSHIP)
                        $result['membership'][$year] = true;
                    elseif ($row['license'] == LICENSE_A)
                        $result['a_license'][$year] = true;
                    elseif ($row['license'] == LICENSE_B)
                        $result['b_license'][$year] = true;
                    break;

                default:
                    $result[$key] = $row[$key];
                    break;
            }
        }

        $result['status'] = true;
    }

    return $result;
}


/**
 * Parse returned array into standard assoc array
 *
 * @param  array $data json decoded data
 * @return  returns assoc array of licenses [a, b, membership]
 */
function sfl_api_parseLicenses($data)
{
    $year = date('Y');

    // For development/club use purposes
    if (IGNORE_PAYMENTS == true)
        return array('a_license' => array("$year" => true), 'b_license' => array("$year" => true), 'membership' => array("$year" => true));

    if (!$data || $data['status'] == false)
        return null;

    $data['membership'] = isset($data['membership']) ? $data['membership'] : false;
    $data['a_license'] = isset($data['a_license']) ? $data['a_license'] : false;
    $data['b_license'] = isset($data['b_license']) ? $data['b_license'] : false;

    return $data;
}


/**
 * Get users licenses for a specific year, identified by traditional
 * firstname+lastname+birthyear combo.
 *
 * @param  string $firstname first name
 * @param  string $lastname last name
 * @param  int $birthdate year of birth
 * @return  returns assoc array of licenses [a, b, membership]
 */
function sfl_api_get_by_name($firstname, $lastname, $birthdate)
{
    $firstname = esc_or_null($firstname);
    $lastname = esc_or_null($lastname);
    $birthdate = esc_or_null($birthdate, 'int');
    $where = "WHERE sfl_player.firstname = CAST(CAST($firstname AS binary) AS char character set utf8)
                AND sfl_player.lastname = CAST(CAST($lastname AS binary) AS char character set utf8)
                AND YEAR(sfl_player.birthdate) = $birthdate";
    return sfl_api_parseLicenses(sfl_api_run_query($where));
}


/**
 * Get users licenses for a specific year, identified by SFL ID number
 *
 * @param  int $sflId sfl id number
 * @return  returns assoc array of licenses [a, b, membership]
 */
function sfl_api_get_by_id($sflid)
{
    $sflid = esc_or_null($sflid, 'int');
    $where = "WHERE sfl_player.sfl_id = $sflid AND sfl_player.pdga IN ('', 0, NULL)";
    return sfl_api_parseLicenses(sfl_api_run_query($where));
}


/**
 * Get users licenses for a specific year, identified by PDGA number
 *
 * @param  int $pdga pdga number
 * @return  returns assoc array of licenses [a, b, membership]
 */
function sfl_api_get_by_pdga($pdga)
{
    $pdga = esc_or_null($pdga, 'int');
    $where = "WHERE sfl_player.pdga = $pdga";
    return sfl_api_parseLicenses(sfl_api_run_query($where));
}



/** ************************** ONLY FUNCTIONS BELOW SHOULD BE CALLED ***************************** */



/**
 * Get users licenses for a specific year
 *
 * @param  int $userid internal userid
 * @return  returns assoc array of licenses [a, b, membership]
 */
function SFL_getPlayer($userid)
{
    $userid = (int) $userid;

    if (!$userid)
        return null;

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

        // sanitize input a little, mostly because we have legacy doubles people
        if (strstr($firstname, '/') || strstr($lastname, '/') || $birthdate == 1900)
            return null;

        // there may be valid cases for spaces, convert them into +
        list($firstname, $lastname) = str_replace(' ', '+', array($firstname, $lastname));

        if ($pdga > 0)
            $data = sfl_api_get_by_pdga($pdga);
        elseif ($sflid > 0)
            $data = sfl_api_get_by_id($sflid);
        else
            $data = sfl_api_get_by_name($firstname, $lastname, $birthdate);

        if ($data) {
            if (SaveClub(@$data['club_id'], @$data['club_name'], @$data['club_short']))
                SaveUserClub($userid, @$data['club_id']);
            SaveUserSflId($userid, @$data['sfl_id']);
        }

        return $data;
    }

    return null;
}
