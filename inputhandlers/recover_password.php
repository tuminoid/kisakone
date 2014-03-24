<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm�
 * Copyright 2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Password recovery handler
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
    $username = @$_POST['username'];

    $userid = GetUserId($username);
    if (!$userid)
        $userid = GetUserIdByEmail($username);
    if (!$userid)
        return new Error();

    $user = GetUserDetails($userid);
    $user->SendPasswordRecoveryEmail();

    $x = null;
    redirect("Location: " . url_smarty(array('page' => 'recover_password_info', 'id' => $userid), $x));
}
