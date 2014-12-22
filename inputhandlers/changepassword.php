<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Password change handler
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

require 'data/authentication.php';

/**
 * Processes the login form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $recover = @$_GET['mode'] == 'recover';

    if (@$_POST['cancel'])
        redirect("Location: " . url_smarty(array('page' => 'myinfo'), $_POST));

    if ($recover) {
        // Password recovery mode; ensure the provided token is the correct one
        $user = GetUserDetails(@$_GET['id']);
        $token = GetUserSecurityToken(@$_GET['id']);

        if (!$user || $token != @$_GET['token']) {
           return Error::AccessDenied();
        }
        $uid = $user->id;
    }
    else {
        $user = @$_SESSION['user'];
        if (!$user)
            return error::AccessDenied();
        $problems = array();

        if (@$_GET['id']) {
            if (!IsAdmin())
                return Error::AccessDenied();

            $getId = @$_GET['id'];
            $uid = is_numeric($getId) ? $getId : GetUserId($getId);
        }
        else
            $uid = $user->id;
    }

    $problems = array();
    if (!@$_GET['id'] && !$recover) {
        $current = $_POST['current'];
        $userob = new User(CheckUserAuthentication($user->username, $current));
        if ($userob === null || is_a($userob, 'Error'))
            $problems['current_password'] = translate('FormError_WrongPassword');
    }

    $password = $_POST['password'];
    if ($password == '')
        $problems['password'] = translate('FormError_NotEmpty');

    $password2 = $_POST['password2'];
    if ($password != $password2)
        $problems['password2'] = translate('FormError_PasswordsDontMatch');

    if (count($problems)) {
        $error = new Error();
        $error->title = 'Password form error';
        $error->function = 'InputProcessing:ChangePassword:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;
        $error->errorPage = 'changepassword';

        return $error;
    }

    $e = ChangeUserPassword($uid, $password);
    if (is_a($e, 'Error'))
        return $e;

    if ($recover)
        redirect("Location: " . url_smarty(array('page' => 'login'), $uid));

    redirect("Location: " . url_smarty(array('page' => 'user_edit_done', 'id' => @$_GET['id']), $uid));
}
