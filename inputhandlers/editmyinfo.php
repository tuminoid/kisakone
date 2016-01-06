<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Edit my info ui backend
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

require_once 'data/configs.php';
require_once 'core/url.php';


/**
 * Processes the login form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $user = @$_SESSION['user'];
    if (!$user)
        return error::AccessDenied();

    $username = @$_GET['id'];
    if ($username) {
        if (!IsAdmin())
            return Error::AccessDenied();
        if (is_numeric($username) && is_a(GetUserDetails($username), 'User'))
            $uid = $username;
        else
            $uid = GetUserId($username);
        $eduser = GetUserDetails($uid);
    }
    else {
        $uid = $user->id;
        $eduser = $user;
    }
    $problems = array();

    $lastname = $_POST['lastname'];
    if ($lastname == '')
        $problems['lastname'] = translate('FormError_NotEmpty');

    $firstname = $_POST['firstname'];
    if ($firstname == '')
        $problems['firstname'] = translate('FormError_NotEmpty');

    $email = $_POST['email'];
    if (!preg_match('/^.+@.+\..+$/', $email))
        $problems['email'] = translate('FormError_InvalidEmail');
    $email_old = $_POST['email_old'];

    $player = $eduser->GetPlayer();
    if ($player) {
        $pdga = $_POST['pdga'];
        if ($pdga == '') {
            $pdga = null;
        }
        else {
            $pdga = (int) $pdga;
            if (!$pdga)
                $problems['pdga'] = translate('FormError_NotPositiveInteger');
        }

        $gender = @$_POST['gender'];
        if ($gender != 'M' && $gender != 'F')
            $problems['gender'] = translate('FormError_NotEmpty');

        $dobYear = $_POST['dob_Year'];
        if ($dobYear != (int) $dobYear)
            $problems['dob'] = translate('FormError_NotEmpty');
    }
    else {
        $pdga = null;
        $gender = null;
        $dobYear = null;
    }

    if (count($problems)) {
        $error = new Error();
        $error->title = 'Edit My Info failed';
        $error->function = 'InputProcessing:EditMyInfo:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;
        $error->errorPage = 'editmyinfo';

        return $error;
    }

    $result = EditUserInfo($uid, $email, $firstname, $lastname, $gender, $pdga, $dobYear);
    if (!is_a($result, 'Error')) {
        if (!$username) {
            $user->birthyear = $dobYear;
            $user->gender = $gender;
            $user->lastname = $lastname;
            $user->firstname = $firstname;
            $user->fullname = $firstname . ' ' . $lastname;
            $user->email = $email;
        }

        if (@$_GET['id'])
            redirect(url_smarty(array('page' => 'user', 'id' => $_GET['id']), $user));
        elseif ($email != $email_old && GetConfig(EMAIL_VERIFICATION)) {
            $user->SetEmailVerified(false);
            $user->SendEmailVerificationEmail();
            redirect(url_smarty(array('page' => 'emailverification', 'id' => $email), $user));
        }
        redirect(url_smarty(array('page' => 'myinfo'), $user));
    }

    return $result;
}
