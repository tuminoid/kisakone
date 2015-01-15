<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file contains function related to logging in, password handling etc
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


/**
 * Method for generating the user salt.
 *
 * Returns 32 character salt
 */
function GenerateSalt()
{
    try {
        $rawsalt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
    }
    catch (Exception $e) {
        error_log("error: php5-crypt missing, cannot create salt");
        return null;
    }
    $salt = base64_encode($rawsalt);
    $salt = str_replace('+', '.', $salt);
    return $salt;
}


/**
 * Method for getting a hash for password
 *
 * Returns hash for a password or
 * null if error
 */
function GenerateHash($password, $hash = "md5", $salt = "")
{
    if (empty($password))
        return null;

    if (empty($hash))
        $hash = "md5";

    // Legacy, insecure
    if ($hash == "md5")
        return md5($password);

    // Correct way is to use salting and strong crypto
    if ($hash == "crypt") {
        if (IsValidSalt($salt))
            return crypt($password, '$2y$10$' . $salt  . '$');
    }

    return null;
}


/**
 * Method for enforcing password quality
 *
 * We will enforce password quality mainly by runtime JS checks
 * so this will just check the length is within boundaries
 *
 * Returns true for valid password and false for invalid password
 */
function IsValidPassword($password)
{
    if (empty($password))
        return false;

    if (strlen($password) < 8)
        return false;

    if (strlen($password) > 40)
        return false;

    return true;
}


/**
 * Method for checking valid salt
 *
 * Returns true for valid salt and false for invalid salt
 */
function IsValidSalt($salt)
{
    if (empty($salt))
        return false;

    if (strlen($salt) == 32)
        return true;

    return false;
}
