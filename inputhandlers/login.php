<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Login form handler
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

require_once 'data/authentication.php';

function processForm()
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginAt = (int) @$_POST['loginAt'];
    if ($loginAt < time() - 60 * 5) {
        $error = new Error();
        $error->title = translate('error_expired_login_form');
        $error->description = translate('error_expired_login_form_description');
        $error->function = 'InputProcessing:Login:processForm';
        $error->errorPage = 'login';

        return $error;
    }

    $user = new User(CheckUserAuthentication($username, $password));
    if (is_a($user, 'Error'))
      return $user;

    if (is_null($user)) {
        $error = new Error();
        $error->title = translate('error_invalid_login_details');
        $error->description = translate('error_invalid_login_details_description');
        $error->function = 'InputProcessing:Login:processForm';
        $error->errorPage = 'login';

        return $error;
    }

    // Make sure a session is used from now on
    setcookie("kisakone_login", 1);
    if (!(@$_COOKIE['kisakone_login']))
        session_start();
    $_SESSION['user'] = $user;

    if (@$_POST['rememberMe']) {
        $expires = time() + 60 * 60 * 24 * 30 * 2; // about 2 months
        setcookie('kisakone_autologin_as', $user->username, $expires);
        setcookie('kisakone_autologin_key', GetAutoLoginToken($user->id), $expires);
    }



    // Normally we just redirect user to the next page using header() call, but
    // in this particular case we'd have to relay the url to return to, amogst other
    // things, so to make that work more nicely we'll just display the redirection
    // screen instead of the current page. This is not a properly supported mechanism
    // for anything except errors, so we treat it as if it was one.
    $retvalue = new Error();
    $retvalue->internalDescription = 'Login page redirect; nothing to be concerned about';
    $retvalue->errorPage = 'redirect';
    $retvalue->data = 'login';

    return $retvalue;
}
