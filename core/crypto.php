<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file contains the password manipulation utilities
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


/** ************************************************************************
 * Method for generating the user salt.
 *
 */
function GenerateSalt()
{
    $rawsalt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
    $salt = base64_encode($rawsalt);
    $salt = str_replace('+', '.', $salt);
    return $salt;
}

/** ************************************************************************
 * Method for getting a hash for password
 *
 * Returns hash for a password or
 * null if error
 */
function GenerateHash($password, $hash = "md5", $salt = "")
{
    // Legacy, insecure
    if ($hash == "md5")
        return md5($password);

    // Correct way is to use salting and strong crypto
    if (!empty($salt))
        return crypt($password, '$2y$10$' . $this->salt  . '$');

    return null;
}
