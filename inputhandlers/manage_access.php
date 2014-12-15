<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Access management form handler
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
    if (!IsAdmin())
        return Error::AccessDenied('eventfees');

    if (!@$_POST['cancel']) {
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 7) == 'oldban_') {
                list($ignore, $userid) = explode('_', $key);
                $newban = @$_POST['ban_' . $userid];

                $newban = (bool) $newban;
                $value = (bool) $value;

                if ($newban != $value) {
                    $user = GetUserDetails($userid);
                    Ban($user->id, $newban);
                }
            } elseif (substr($key, 0, 7) == 'delete_') {
                // Note: user removal is not supported in this version; the UI
                // will never enter this code path and $user->Remove is not implemented90
                list($ignore, $userid) = explode('_', $key);
                $user = GetUserDetails($userid);
                $user->Remove();
            }
        }
    }

    redirect("Location: " . url_smarty(array('page' => 'manage_users'), $_GET));
}
