<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Email verification input handler
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

require_once 'data/config.php';
require_once 'core/user.php';
require_once 'core/email.php';


/**
 * Processes the edit tournament form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $user = @$_SESSION['user'];
    if (!$user)
        error_log("no user");

    $email = @$_POST['email'];
    $send_token = @$_POST['send_token'];
    $token = @$_POST['token'];

    // If token was requested
    if ($send_token) {
        $user->SendEmailVerificationEmail();
        redirect(url_smarty(array('page' => 'emailverification', 'email' => $email), $_GET));
    }

    // If token was input
    if ($token) {
        error_log("verify token");
        if ($user->VerifyEmailToken($token)) {
            $user->SetEmailVerified(true);
            redirect(url_smarty(array('page' => 'emailverification', 'email' => $email, 'verified' => 1), $_GET));
        }

        redirect(url_smarty(array('page' => 'emailverification', 'email' => $email, 'failed' => 1), $_GET));
    }

    error_log("DO NOT COME HERE!");
    // This is the token prefill
    redirect(url_smarty(array('page' => 'emailverification', 'email' => $email, 'token' => $token), $_GET));
}
