<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Signs user up for an event
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
    require_once 'core/event_management.php';

    if (@$_POST['cancel']) {
        header("Location: " . url_smarty(array('page' => 'event', 'id' => @$_GET['id']), $nothing));
        die();
    }

    global $user;
    if (!$user)
        return Error::AccessDenied();
    if ($user->role =='admin')
        return Error::AccessDenied();

    $event = GetEventDetails(@$_GET['id']);
    if (!$event) return Error::NotFound('event');

    if ($event->approved !== null) {
        header("Location: " . url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'payment'), $nothing));
        die();
    }

    // Wtf?
    $nothing = null;

    if (!$event->signupPossible()) {
        return Error::AccessDenied();
    }

    $player = $user->GetPlayer();
    $class = GetClassDetails(@$_POST['class']);

    if (!$player->IsSuitableClass($class)) {
        $error = new Error();
        $error->title = 'invalid_class_selection';
        $error->function = 'InputProcessing:sign_up:processForm';
        $error->description = translate('invalid_class_selection_description');
        $error->isMajor= true;

        return $error;
    }

    $fees = $event->FeesRequired();
    if ($fees) {
        if (!$user->FeesPaidForYear(date('Y', $event->startdate), $fees)) {
            return Error::AccessDenied();
        }
     }

    $result = SignupUser($event->id, $user->id, $class->id);
    if (is_a($result, 'Error')) {
        $result->errorPage = 'error';

        return $result;
    }

    $variableNeededAsItsReference = null;
    if ($result) {
        // Show payment if signup true
        header("Location: " . url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'payment', 'signup' => $result?1:0), $nothing));
    } else {
        // Show queue if signup false
        header("Location: " . url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'signupinfo', 'signup' => $result?1:0), $nothing));
    }
    die();
}
