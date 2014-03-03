<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Signup cancellation handler
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
 * Processes the form
 * @return Nothing or Error object on error
 */
function processForm()
{
    if (@$_POST['cancel']) {
        header("Location: " . url_smarty(array('page' => 'event', 'view' => 'signupinfo', 'id' => @$_GET['id']), $nothing));
        die();
    }

    global $user;
    if (!$user)
        return Error::AccessDenied();

    $event = GetEventDetails(@$_GET['id']);
    if (!$event)
        return Error::NotFound('event');

    /*
    // This is not needed, also block queue sign offs
    if ($event->approved === null) {
        header("Location: " . url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'signupinfo'), $nothing));
        die();
    }
    */
    $nothing = null;

    if (!$event->signupPossible()) {
        return Error::AccessDenied();
    }

    $player = $user->GetPlayer();
    if (!$player) {
        return Error::AccessDenied();
    }
    $result = CancelSignup($event->id, $player->id);

    if (is_a($result, 'Error')) {
        $result->errorPage = 'error';

        return $result;
    }

    $variableNeededAsItsReference = null;
    header("Location: " . url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'signupinfo'), $nothing));
    die();
}
