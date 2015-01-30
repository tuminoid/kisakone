<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * UI backend for change password dialog
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
 * Initializes the variables and other data necessary for showing the matching template
 * @param Smarty $smarty Reference to the smarty object being initialized
 * @param Error $error If input processor encountered a minor error, it will be present here
 */
function InitializeSmartyVariables(&$smarty, $error)
{
    language_include('admin');
    if (@$_GET['mode'] == 'recover') {
        require_once 'data/login.php';

        // Recover password mode: using a token instead of using the current password
        $user = GetUserDetails(@$_GET['id']);
        $token = GetUserSecurityToken(@$_GET['id']);

        // If the token is incorrect, we dont even want to show the form
        if (!$user || $token != @$_GET['token'])
            redirect("Location: " . url_smarty(array('page' => 'recover_password_info', 'id' => @$_GET['id'], 'failed' => 'yes'), $user));

        $smarty->assign('username', $user->username);
    }
    else {
        // Normal "change password" form
        $user = @$_SESSION['user'];
        if (!$user)
            return error::AccessDenied();

        if (@$_GET['id']) {
            // Only admins are allowed to change the password of other users
            if (!IsAdmin())
                return Error::AccessDenied();
        }

        if ($error)
            $smarty->assign('error', $error->data);

        $smarty->assign('adminmode', @$_GET['id'] != '');
    }
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    if (@$_GET['mode'] == 'recover')
        return 'special';
    return 'users';
}
