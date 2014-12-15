<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file contains the User class.
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

// TODO: Is there need to check the password minimum length

/* *****************************************************************************
 * Configuration
 *
 * */

// Valid User->role attribute values
define('USER_ROLE_PLAYER', 'player'); // Default role
define('USER_ROLE_ADMIN', 'admin');

// Valid User->username field length
define('USER_USERNAME_MIN_LENGTH', 3);
define('USER_USERNAME_MAX_LENGTH', 40);

// User access levels
$user_access_level_none         = '';
$user_access_level_login        = 'login';
$user_access_level_official     = 'official';
$user_access_level_officialonly = 'officialonly';
$user_access_level_td           = 'td';
$user_access_level_admin        = 'admin';

/* *****************************************************************************
 * This class represents a single user in the system.
 */
class user
{
    var $id;
    var $username;
    var $role;      // $user_role_player or $user_role_admin
    var $firstname;
    var $lastname;
    var $fullname;  // derived attribute
    var $email;
    var $gender;    // Player class attribute, repeated here for convenience
    var $pdga;      // Player class attribute, repeated here for convenience
    var $birthyear; // Player class attribute, repeated here for convenience
    var $password;  // password as hash
    var $hash;      // what type of hash password is
    var $salt;      // salt for the password

    /** ************************************************************************
     * Class constructor
     */
    function User($id = null,
                   $uname = "",
                   $role = null,
                   $fname = "",
                   $lname = "",
                   $email = "",
                   $player = "none")
    {
        if ($email && $player === 'none')
            die('Invalid user initialization' . print_r(debug_backtrace()));
        if ($player === 'none')
            $player = null;

        if (is_array($id)) {
            $this->InitializeFromArray($id);
        }
        else {
            $this->id = $id;
            $this->username = $uname;
            $this->SetRole($role);
            $this->SetNames($fname, $lname);
            $this->email = $email;
        }

        $this->gender = null;
        $this->pdga = null;
        $this->birthyear = null;
        $this->password = null;
        $this->hash = null;
        $this->salt = null;
        $this->player = $player;

        return;
    }

    /**
     * Initialize user data from array
     */
    function InitializeFromArray($data)
    {
        $this->id = $data[0];
        $this->username = $data[1];
        $this->SetRole($data[2]);
        $this->SetNames($data[3], $data[4]);
        $this->email = $data[5];
    }

    /** ************************************************************************
     * Method for setting the role attribute
     *
     * Returns null
     */
    function SetRole($role)
    {
        $this->role = isset($role) ? $role : USER_ROLE_PLAYER;
        return null;
    }

    /** ************************************************************************
     * Method for setting the name attributes
     *
     * Returns null
     */
    function SetNames($firstname, $lastname)
    {
        $this->firstname = trim($firstname);
        $this->lastname = trim($lastname);
        $this->fullname = trim("$firstname $lastname");

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

        if (!isset($this->id)) {
            $this->id = $id;
        }
        else {
            if ($this->id !== $id) {
                // Attempt to change valid id, report internal error
                $err = new Error();
                $err->title = "error_internal";
                $err->description = translate("error_internal_description");
                $err->internalDescription = "Attempt to change valid User->id.";
                $err->function = "User->SetId()";
                $err->IsMajor = true;
                $err->data = "username:" . $this->username .
                             "; existing id:" . $this->id .
                             "; new id:" . $id;
            }
        }

        return $err;
    }

    /** ************************************************************************
     * Method for setting the user password.
     *
     * Returns null for success or
     * an Error object in case the argument is not valid.
     */
    function SetPassword($password)
    {
        $err = null;

        if (!empty($password)) {
            // TODO: Is there need to check the password minimum length
            require_once 'core/crypto.php';
            $this->password = GenerateHash($password, GetHashType(), $this->salt);
        }
        else {
            // Missing password, report error
            $err = new Error();
            $err->title = "error_missing_password";
            $err->description = translate("error_missing_password_description");
            $err->internalDescription = "User password argument is empty";
            $err->function = "User->SetPassword()";
            $err->IsMajor = false;
            $err->data = "username:" . $this->username;
        }

        return $err;
    }

    /** ************************************************************************
     * Method for getting a hash type
     *
     * Returns hash type or
     * null for error
     */
    function GetHashType()
    {
        if (empty($this->hash))
            return "md5";
        return $this->hash;
    }

    /** ************************************************************************
     * Method for setting the attributes related to player properties.
     *
     * Returns null
     */
    function SetPlayerFields($gender, $pdga, $birthyear)
    {
        // Set Player arguments
        // No validation here, it is done in the Player class instead
        $this->gender = $gender;
        $this->pdga = $pdga;
        $this->birthyear = $birthyear;

        return null;
    }

    /** ************************************************************************
     * Method for validating the correctness of the object attributes.
     *
     * Returns null for positive validation or
     * an Error object in case an attribute is not valid.
     */
    function ValidateUser()
    {
        $err = null;

        if (!$this->IsValidUsername($this->username)) {
            $err = new Error();
            $err->title = "error_invalid_username";
            $err->description = translate("error_invalid_username_description");
            $err->internalDescription = "User->username attribute is not valid.";
            $err->function = "User->ValidateUser()";
            $err->IsMajor = false;
            $err->data = "User->username:" . $this->username;
        }

        if (!isset($err) and !$this->IsValidEmail($this->email)) {
            $err = new Error();
            $err->title = "error_invalid_email";
            $err->description = translate("error_invalid_email_description");
            $err->internalDescription = "User->email attribute is not valid.";
            $err->function = "User->ValidateUser()";
            $err->IsMajor = false;
            $err->data = "User->username:" . $this->username .
                         "; User->email:" . $this->email;
        }

        return $err;
    }

    /** ************************************************************************
     * Method for validating the correctness of the username argument.
     *
     * Returns true if the username is valid, otherwise returns false.
     */
    static function IsValidUsername($username)
    {

        $retVal = false;
        if ($username === null) {

            // Accountless user (manually entered empty username shows up as an
            // empty string and will not reach this point)
            $retVal = true;
        }
        elseif (!empty($username)) {
            if ((is_string($username)) and
                    (strlen($username) >= USER_USERNAME_MIN_LENGTH) and
                    (strlen($username) <= USER_USERNAME_MAX_LENGTH))
                $retVal = true;

            if (!preg_match('/^[\pL\d_-]+$/', $username)) {
                $retVal = false;
            }
        }

        return $retVal;
    }

    /** ************************************************************************
     * Method for validating the correctness of the email argument.
     *
     * Returns true if the email is valid, otherwise returns false.
     * Unset or null argument is considered to be valid.
     */
    function IsValidEmail($email)
    {
        $retVal = false;

        if (!isset($email)) {
            $retVal = true;
        }
        elseif (!empty($email)) {
            $validEmailExpr = "^[0-9A-Za-z~!#$%&_-]([.]?[0-9A-Za-z~!#$%&_-])*" .
                              "@[0-9A-Za-z~!#$%&_-]([.]?[0-9A-Za-z~!#$%&_-])*$";
            if (eregi($validEmailExpr, $email)) {
                $retVal = true;
            }
        }

        return $retVal;
    }

    /** ************************************************************************
     * Method for checking if User role is admin
     *
     * Returns true if role is admin, otherwise returns false
     */
    function IsAdmin()
    {
        return $this->role == USER_ROLE_ADMIN;
    }

    /** ************************************************************************
     * Gets the Event objects that assiciate with the user id
     */
    function GetMyEvents($eventType)
    {
        return GetUserEvents(null,  $eventType);
    }

    /** ************************************************************************
     * Gets the Player object that associates with the user id
     *
     * Returns Player object in success or
     * null if there is no Player that corresponds with the user id or
     * an Error object in case there was an error in accessing the database.
     */
    function GetPlayer()
    {
        require_once 'core/player.php';
        return GetUserPlayer($this->id);
    }

    /** ************************************************************************
     * Send email to the user's email address containing a token which can be
     * used for changing one's password in case the user forgot it.
     *
     */
    function SendPasswordRecoveryEmail()
    {
        require_once 'core/email.php';

        $token = GetUserSecurityToken($this->id);
        $prototol = empty($_SERVER['HTTPS']) ? "http://" : "https://";

        global $settings;
        if ($settings['USE_MOD_REWRITE'])
            $url = $protocol . $_SERVER['HTTP_HOST'] . url_smarty(array('page' => 'changepassword', 'id' => $this->id, 'token' => $token, 'mode' => 'recover'), $_GET);
        else
            $url = $protocol . $_SERVER['HTTP_HOST'] . baseurl() .  url_smarty(array('page' => 'changepassword', 'id' => $this->id, 'token' => $token, 'mode' => 'recover'), $_GET);

        SendEmail(EMAIL_PASSWORD, $this->id, null, $url, $token);
    }

    /**
     * Determines membership and license payments for a given year
     * Returns true if player's licenses match the requirements
    */
    function FeesPaidForYear($year, $required)
    {
        if (!$required)
            return true;

        list($aLicense, $membership, $bLicense) = SFL_FeesPaidForYear($this->id, $year);

        // If there is any requirements for competition, membership is a must
        if ($required && !$membership)
            return false;
        // If A-license is required, we require that strictly
        if ($required == LICENSE_A && !$aLicense)
            return false;
        // If B-license is required, both A- and B-license quality, obviusly
        if ($required == LICENSE_B && !($aLicense || $bLicense))
            return false;

        return true;
    }
}

/* *****************************************************************************
 * Function for checking if users access rights for an event are adequate for
 * a given level.
 *
 * Returns true if user has adequate rights for the level,
 * otherwise returns false
 */
function access($level)
{
    global $user_access_level_none;
    global $user_access_level_login;
    global $user_access_level_official;
    global $user_access_level_officialonly;
    global $user_access_level_td;
    global $user_access_level_admin;
    $retVal = false;

    $eventid = @$_GET['id'];

    if ($level == $user_access_level_none) {
        // No level requirements, all users have access
        $retVal = true;
    }
    else {
        // Check user access rights against required level
        $user = @$_SESSION['user'];
        if (isset($user)) {
            $admin_user = IsAdmin();

            switch ($level) {
                case $user_access_level_login:
                    // All logged users have access to 'login' level
                    $retVal = true;
                    break;

                case $user_access_level_official:
                    $event = GetEventDetails($eventid);
                    if ($event && ($admin_user or $event->management == $user_access_level_td
                       or $event->management == $user_access_level_official))
                    {
                        $retVal = true;
                    }
                    break;

                case $user_access_level_officialonly:
                    // Only officials have access to features with this type of protection, no-one else
                     $event = GetEventDetails($eventid);
                    if ($event && $event->management == $user_access_level_official) {
                        $retVal = true;
                    }
                    break;

                case $user_access_level_td:
                     $event = GetEventDetails($eventid);


                    if ($event && ($admin_user || $event->management == $user_access_level_td)) {
                        $retVal = true;
                    }
                    break;

                case $user_access_level_admin:
                    if ($admin_user) {
                        $retVal = true;
                    }
                    break;

                default:
                    // Invalid access level, report internal error
                    $err = new Error();
                    $err->title = "error_internal";
                    $err->description = translate("error_internal_description");
                    $err->internalDescription = "Unexpected access level as argument.";
                    $err->function = "access()";
                    $err->IsMajor = true;
                    $err->data = "level:" . $level .
                                 "; user id:" . $this->id .
                                 "; username:" . $this->username;
                    break;
            }
        }
    }

    return $retVal;
}

/* *****************************************************************************
 * Function for checking if the current user has admin rights
 *
 * Returns true if user has admin rights, othrwise returns false.
 */
function IsAdmin()
{
    $retVal = false;

    $user = @$_SESSION['user'];
    if (isset($user))
        $retVal = $user->isAdmin();

    return $retVal;
}
