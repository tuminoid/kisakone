<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm�
 *
 * Creates an admin or another manager user
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
 * Processes the add admin form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $problems = array();

    if (@$_POST['cancel']) {
        redirect("Location: " . BaseURL());
    }

    if (!IsAdmin()) return Error::AccessDenied();

    $lastname = $_POST['lastname'];
    if ($lastname == '') $problems['lastname'] = translate('FormError_NotEmpty');

    $firstname = $_POST['firstname'];
    if ($firstname == '') $problems['firstname'] = translate('FormError_NotEmpty');

    $email = $_POST['email'];
    if (!preg_match('/^.+@.+\..+$/', $email)) $problems['email'] = translate('FormError_InvalidEmail');

    $username = $_POST['username'];
    if (!User::IsValidUsername($username))  $problems['username'] = translate('FormError_InvalidUsername');
    if (GetUserId($username) !== null)  $problems['username'] = translate('FormError_DuplicateUsername', array('username' => $username));

    $password = $_POST['password'];
    if ($password == '') $problems['password'] = translate('FormError_NotEmpty');

    $password2 = $_POST['password2'];
    if ($password != $password2) $problems['password2'] = translate('FormError_PasswordsDontMatch');

    $role = @$_POST['access'];
    if ($role != USER_ROLE_ADMIN) {
        $problems['access'] = translate('FormError_NotEmpty');

    }
    if (count($problems)) {
        $error = new Error();
        $error->title = 'Add Admin form error';
        $error->function = 'InputProcessing:Add_admin:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;
        $error->errorPage = 'newadmin';

        return $error;
    }

    $admin = new User( null, $username, $role,
                      $firstname, $lastname, $email, null);
    $err = $admin->ValidateUser();

    if ( !isset( $err)) {
        if ($admin->username !== null) {
            $err = $admin->SetPassword( $password);
        }

        if ( !isset( $err)) {
            $admin = SetUserDetails( $admin);
            if ( is_a( $admin, "Error")) {
                $err = $admin;
                $admin = null;
            }
        }
    }

    if ($err) {
        $err->isMajor= true;

        return $err;
    } else

        return true;
}
