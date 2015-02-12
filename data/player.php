<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'data/db_init.php';
require_once 'data/club.php';
require_once 'sfl/pdga_integration.php';
require_once 'core/player.php';


function GetPlayerDetails($playerid)
{
    $playerid = (int) $playerid;

    $query = format_query("SELECT *,YEAR(birthdate) AS birthyear FROM :Player WHERE player_id = $playerid");
    $result = execute_query($query);

    if (!$result)
        null;

    $retValue = null;
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = new Player($row['player_id'], $row['pdga'], $row['sex'],
            $row['birthyear'], $row['firstname'], $row['lastname'], $row['email']);
    }
    mysql_free_result($result);

    return $retValue;
}


// Gets a User object associated with Playerid
function GetPlayerUser($playerid = null)
{
    if ($playerid === null)
        return null;

    $playerid = (int) $playerid;

    $query = format_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname,
                                :Player.firstname AS pFN, :Player.lastname AS pLN, :Player.email AS pEM
                            FROM :User
                            INNER JOIN :Player ON :Player.player_id = :User.Player
                            WHERE :Player.player_id = $playerid");
    $result = execute_query($query);

    $retValue = null;
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_assoc($result);
        $retValue = new User($row['id'], $row['Username'], $row['Role'],
            data_GetOne($row['UserFirstname'], $row['pFN']),
            data_GetOne($row['UserLastname'], $row['pLN']),
            data_GetOne($row['UserEmail'], $row['pEM']),
            $playerid);
    }
    mysql_free_result($result);

    return $retValue;
}


/**
 * Function for setting the user participation on an event
 *
 * Returns true for success, false for successful queue signup or an Error
 */
function SetPlayerParticipation($playerid, $eventid, $classid, $signup_directly = true)
{
    $playerid = (int) $playerid;
    $eventid = (int) $eventid;
    $classid = (int) $classid;

    $retValue = $signup_directly;
    $table = ($signup_directly === true) ? ":Participation" : ":EventQueue";

    $playerob = GetPlayerDetails($playerid);
    $userob = GetPlayerUser($playerid);
    $userid = $userob ? $userob->id : null;

    CancelSignup($eventid, $playerid, false);

    $pdga = $playerob->pdga;
    $rating = pdga_getPlayerRating($pdga);
    $clubid = esc_or_null(GetUsersClub($userid), 'int');
    $rating = esc_or_null($rating, 'int');

    $query = format_query("INSERT INTO $table (Player, Event, Classification, Club, Rating)
                            VALUES ($playerid, $eventid, $classid, $clubid, $rating)");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    return $retValue;
}


/**
 * Function for setting or changing the player data.
 *
 * @param class Player $player - single system users player data
 */
function SetPlayerDetails($player)
{
    if (!is_a($player, "Player"))
        return Error::internalError("Wrong class as argument");

    $pdga = esc_or_null($player->pdga, 'int');
    $gender = esc_or_null($player->gender == 'M' ? 'male' : 'female');
    $lastname = esc_or_null(data_fixNameCase($player->lastname));
    $firstname = esc_or_null(data_fixNameCase($player->firstname));
    $dobyear = esc_or_null((int) $player->birthyear . '-1-1');
    $email = esc_or_null($player->email);

    $query = format_query("INSERT INTO :Player (pdga, sex, lastname, firstname, birthdate, email)
                            VALUES ($pdga, $gender, $lastname, $firstname, $dobyear, $email)");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);

    $p_id = mysql_insert_id();
    $player->SetId($p_id);

    return $player;
}
