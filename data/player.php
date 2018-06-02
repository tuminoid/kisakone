<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2018 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Player
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

require_once 'data/db.php';
require_once 'data/club.php';
require_once 'core/player.php';
require_once 'data/configs.php';
require_once 'data/user.php';


function GetPlayerDetails($playerid)
{
    $playerid = esc_or_null($playerid, 'int');

    $row = db_one("SELECT *,YEAR(birthdate) AS birthyear FROM :Player WHERE player_id = $playerid");

    if (db_is_error($row) || !$row)
        return null;

    return new Player($row['player_id'], $row['pdga'], $row['sex'],
                        $row['birthyear'], $row['firstname'], $row['lastname'], $row['email']);
}


// Gets a User object associated with Playerid
function GetPlayerUser($playerid = null)
{
    if ($playerid === null)
        return null;

    $playerid = esc_or_null($playerid, 'int');

    $row = db_one("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname,
                                :Player.firstname AS pFN, :Player.lastname AS pLN,
                                :Player.email AS pEM, Sportid
                            FROM :User
                            INNER JOIN :Player ON :Player.player_id = :User.Player
                            WHERE :Player.player_id = $playerid");

    if (db_is_error($row) || !$row)
        return null;

    return new User($row['id'], $row['Username'], $row['Role'],
            data_GetOne($row['UserFirstname'], $row['pFN']),
            data_GetOne($row['UserLastname'], $row['pLN']),
            data_GetOne($row['UserEmail'], $row['pEM']),
            $playerid, $row['Sportid']);
}


/**
 * Function for setting the user participation on an event
 *
 * Returns true for success, false for successful queue signup or an Error
 */
function SetPlayerParticipation($playerid, $eventid, $classid, $signup_directly = true)
{
    $retValue = $signup_directly;
    $table = ($signup_directly === true) ? ":Participation" : ":EventQueue";

    $playerob = GetPlayerDetails($playerid);
    $userob = GetPlayerUser($playerid);
    $userid = $userob ? $userob->id : null;

    $pdga = $playerob->pdga;
    $rating = null;
    if (pdga_enabled()) {
        require_once 'pdga/pdga_integration.php';
        $rating = pdga_getPlayerRating($pdga);
    }
    if (suomisport_enabled()) {
        require_once 'suomisport/suomisport_integration.php';
        $data = suomisport_getLicense($userob->sportid, $playerob->pdga, $playerob->birthyear);
        if ($data && @$data['club_sportid']) {
            SaveClub($data['club_sportid'], $data['club_name'], $data['club_shortname']);
            SaveUserClub($userid, $data['club_sportid']);
        }
    }

    CancelSignup($eventid, $playerid, false);

    $clubid = esc_or_null(GetUsersClub($userid), 'int');
    $rating = esc_or_null($rating, 'int');
    $playerid = esc_or_null($playerid, 'int');
    $eventid = esc_or_null($eventid, 'int');
    $classid = esc_or_null($classid, 'int');

    return db_exec("INSERT INTO $table (Player, Event, Classification, Club, Rating)
                            VALUES ($playerid, $eventid, $classid, $clubid, $rating)");
}


/**
 * Function for setting or changing the player data.
 *
 * @param class Player $player - single system users player data
 */
function SetPlayerDetails($player)
{
    if (!is_a($player, "Player"))
        return Error::InternalError("Wrong class as argument");

    $pdga = esc_or_null($player->pdga, 'int');
    $gender = esc_or_null($player->gender == 'M' ? 'male' : 'female');
    $lastname = esc_or_null(data_fixNameCase($player->lastname));
    $firstname = esc_or_null(data_fixNameCase($player->firstname));
    $dobyear = esc_or_null((int) $player->birthyear . '-1-1');
    $email = esc_or_null($player->email);

    $result = db_exec("INSERT INTO :Player (pdga, sex, lastname, firstname, birthdate, email)
                            VALUES ($pdga, $gender, $lastname, $firstname, $dobyear, $email)");

    if (db_is_error($result))
        return $result;

    $player->SetId($result);

    return $player;
}
