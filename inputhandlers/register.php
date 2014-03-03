<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Registration screen handler
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
 * Processes the login form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $problems = array();

    if (@$_POST['cancel']) {
        header("Location: " . BaseURL());
        die();
    }

    $lastname = $_POST['lastname'];
    if ($lastname == '') $problems['lastname'] = translate('FormError_NotEmpty');

    $firstname = $_POST['firstname'];
    if ($firstname == '') $problems['firstname'] = translate('FormError_NotEmpty');

    $email = $_POST['email'];
    if (!preg_match('/^.+@.+\..+$/', $email)) $problems['email'] = translate('FormError_InvalidEmail');

    // String cast is there to turn a possibly missing username into an empty string,
    // to avoid confusion with accountless users
    $username = (string) @$_POST['username'];

    if (!User::IsValidUsername($username))  $problems['username'] = translate('FormError_InvalidUsername', array('username' => $username));
    if (GetUserId($username) !== null)  $problems['username'] = translate('FormError_DuplicateUsername', array('username' => $username));

    $password = $_POST['password'];
    if ($password == '') $problems['password'] = translate('FormError_NotEmpty');

    $password2 = $_POST['password2'];
    if ($password != $password2) $problems['password2'] = translate('FormError_PasswordsDontMatch');

    $pdga = $_POST['pdga'];
    if ($pdga == '') $pdga = null;
    else {
        $num = (int) $pdga;
        if ($num <= 0) $problems['pdga'] = translate('FormError_PDGA');

    }

    $gender = @$_POST['gender'];
    if ($gender != 'male' && $gender != 'female') $problems['gender'] = translate('FormError_NotEmpty');

    $dobYear = $_POST['dob_Year'];

    if ($dobYear != (int) $dobYear) $problems['dob'] = translate('FormError_NotEmpty');

    $terms = @$_POST['termsandconditions'];
    if (!$terms) $problems['termsandconditions'] =  translate('FormError_Terms');

    if (count($problems)) {
        $error = new Error();
        $error->title = 'Registration form error';
        $error->function = 'InputProcessing:Register:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;
        $error->errorPage = 'register';

        return $error;
    }

    require_once 'core/user_operations.php';

    $r = RegisterPlayer($username, $password, $email, $firstname, $lastname, $gender, $pdga, $dobYear );
    if (is_a($r, 'Error'))
        $r->errorPage = 'error';
    else {
        setcookie("kisakone_login", 1);
        $nuid = GetUserId($username);
        $newuser = GetUserDetails($nuid);

        if (!@$_COOKIE['kisakone_login']) {
            session_start();
        }

        $_SESSION['user'] = $newuser;
        header("Location: " . url_smarty(array('page' => 'registrationdone'), $r));
        die();
    }

    return $r;
}
