<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file contains the Player class.
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

// Valid User->gender attribute values
define('PLAYER_GENDER_MALE', 'M');
define('PLAYER_GENDER_FEMALE', 'F');

// Valid User->birthyear attribute values
define('PLAYER_BIRTHYEAR_MIN', 1900);
define('PLAYER_BIRTHYEAR_MAX', intval( date( "Y")));

/* *****************************************************************************
 * This class represents a single player in the system.
 */
class Player
{
    var $id;

    var $pdga;
    var $gender;
    var $birthyear;
    var $lastname;
    var $firstname;
    var $email;

    /** ************************************************************************
     * Class constructor
     */
    function Player($id = null,
                     $pdga = 0,
                     $gender = null,
                     $birthyear = 0,
                     $firstname = null,
                     $lastname = null,
                     $email = null)
    {
        if ($pdga && $email == null) {
            die('Invalid player construction call ' . print_r(debug_backtrace()));
        }

        if ($gender == 'male') $gender = 'M';
        else if ($gender =='female') $gender = 'F';

        $this->id = $id;
        $this->user = null;
        if ($pdga == null) $this->pdga = null;
        else $this->pdga = (int) $pdga;
        $this->SetGender( $gender);
        $this->birthyear = intval( $birthyear);
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->email = $email;

        return;
    }

    /** ************************************************************************
     * Method for setting the gender attribute
     *
     * Returns null
     */
    function SetGender($gender)
    {

        if( ( $gender == PLAYER_GENDER_MALE) or
            ( $gender == PLAYER_GENDER_FEMALE))
        {
            $this->gender = $gender;
        } else {
            $this->gender = null;
        }

        return null;
    }

    /** ************************************************************************
     * Method for setting the id attribute
     *
     * Returns null for success or
     * an Error object in case the id is already set to a different value.
     */
    function SetId($id)
    {
        $err = null;

        if ( !isset( $this->id)) {
            $this->id = intval( $id);
        } else {
            if ($this->id !== $id) {
                // Attempt to change a valid id, report internal error
                $err = new Error();
                $err->title = "error_invalid_argument";
                $err->description = translate( "error_invalid_argument_description");
                $err->internalDescription = "Attempt to change valid Player->id.";
                $err->function = "Player->SetId()";
                $err->IsMajor = true;
                $err->data = "pdga:" . $this->pdga .
                             "; id argument:" . $id;
            }
        }

        return $err;
    }

    /** ************************************************************************
     * Method for validating the correctness of the object attributes.
     *
     * Returns null for positive validation or
     * an Error object in case an attribute is not valid.
     */
    function ValidatePlayer()
    {

        $err = null;

        if (( !is_int( $this->pdga) or ( $this->pdga < 0)) && $this->pdga !== null) {
            // Invalid pdga attribute
            $err = new Error();
            $err->title = "error_invalid_attribute1";
            $err->description = translate( "error_invalid_attribute_description");
            $err->internalDescription = "Invalid Player->pdga attribute.";
            $err->function = "Player->ValidatePlayer()";
            $err->IsMajor = true;
            $err->data = "player id:" . $this->id .
                         "; user:" . $this->user .
                         "; pdga:" . $this->pdga;
        } else {
            if( ( $this->gender != PLAYER_GENDER_MALE) and
                ( $this->gender != PLAYER_GENDER_FEMALE))
            {
                // invalid gender attribute
                $err = new Error();
                $err->title = "error_invalid_attribute2";
                $err->description = translate( "error_invalid_attribute_description");
                $err->internalDescription = "Invalid Player->gender attribute.";
                $err->function = "Player->ValidatePlayer()";
                $err->IsMajor = true;
                $err->data = "player id:" . $this->id .
                             "; user:" . $this->user .
                             "; pdga:" . $this->pdga .
                             "; gender:" . $this->gender;
            } else {
                if( !is_int( $this->birthyear) or
                    ( $this->birthyear < PLAYER_BIRTHYEAR_MIN) or
                    ( $this->birthyear > PLAYER_BIRTHYEAR_MAX))
                {

                    // invalid birthyear attribute
                    $err = new Error();
                    $err->title = "error_invalid_attribute3";
                    $err->description = translate( "error_invalid_attribute_description");
                    $err->internalDescription = "Invalid Player->birthyear attribute.";
                    $err->function = "Player->ValidatePlayer()";
                    $err->IsMajor = true;
                    $err->data = "player id:" . $this->id .
                                 "; user:" . $this->user .
                                 "; pdga:" . $this->pdga .
                                 "; gender:" . $this->gender.
                                 "; birthyear:" . $this->birthyear;
                }
            }
        }

        return $err;
    }

    /** ************************************************************************
     * Method for testing if this player is acceptable for the given class
     *
     * Returns true if class is fine, false otherwise
     */
    function IsSuitableClass($class)
    {
        if (!$class)
            return false;
        $age = date('Y') - $this->birthyear;

        $problems = 0;
        if ($class->gender && $class->gender != $this->gender)
            $problems++;
        if ($class->minAge && $class->minAge > $age)
            $problems++;
        if ($class->maxAge && $class->maxAge < $age)
            $problems++;

        return $problems == 0;
    }
}

/* ****************************************************************************
 * End of file
 * */
