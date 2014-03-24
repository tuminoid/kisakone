<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm�
 *
 * Logs user out
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
 * Logs out the user. As a side-effect, redirects the user to the index page.
 * @return Nothing or Error object on error
 */
function ProcessAction()
{
    // Clearing the session
    @session_destroy();
    $_SESSION = array();
    setcookie('kisakone_login', 0);
    setcookie('kisakone_autologin_as');
    setcookie('kisakone_autologin_key');

    redirect("Location: " . baseurl());
}
