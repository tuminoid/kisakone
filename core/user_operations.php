<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file contains functionality for managing users
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

require_once 'core/player.php';

/** ****************************************************************************
 * Function for registering a new user.
 *
 * Returns null for success or an Error object in case the registration fails
 *
 * @param string $username  - users username
 * @param string $password  - users password
 * @param string $email     - users email
 * @param string $firstname - users firstname
 * @param string $lastname  - users lastname
 * @param string $gender    - players gender
 * @param int    $pdga      - players pdga
 * @param int    $birthyear - players birthyear
 */

function RegisterPlayer($username, $password, $email, $firstname, $lastname,
                        $gender, $pdga , $birthyear)
{
    $err = null;

    if (isset($gender) && $gender == "female")
        $gender = PLAYER_GENDER_FEMALE;
    else
        $gender = PLAYER_GENDER_MALE;

    $player = new Player(null, $pdga, $gender, $birthyear, $firstname, $lastname, $email);
    $err = $player->ValidatePlayer();
    if (!isset($err)) {
        $player = SetPlayerDetails($player);
        if (is_a($player, "Error"))
            return $player;
    }
    else
        return $err;

    $user = new User(null, $username, USER_ROLE_PLAYER,
                     $firstname, $lastname, $email, $player->id);
    $err = $user->ValidateUser();
    if (!isset($err)) {
        if ($user->username !== null) {
            $err = $user->SetPassword($password);
            if (is_a($err, "Error"))
                return $err;
        }

        if (!isset($err)) {
            $err = SetUserDetails($user);
            if (is_a($err, "Error"))
                $user = null;

        }
    }
    else
        return $err;

    return $user;
}
