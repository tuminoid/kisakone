<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm�
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'core/event_management.php';


/**
 * Processes the form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $nothing = null;
    if (@$_POST['cancel'])
        redirect("Location: " . url_smarty(array('page' => 'event', 'id' => @$_GET['id']), $nothing));

    global $user;
    if (!$user)
        return Error::AccessDenied();
    if ($user->role == 'admin')
        return Error::AccessDenied();

    $event = GetEventDetails(@$_GET['id']);
    if (!$event)
        return Error::NotFound('event');

    if ($event->approved !== null)
        redirect("Location: " . url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'payment'), $nothing));

    if (!$event->signupPossible())
        return Error::AccessDenied();

    $player = $user->GetPlayer();
    $class = GetClassDetails(@$_POST['class']);

    if (!$player->IsSuitableClass($class)) {
        $error = new Error();
        $error->title = 'invalid_class_selection';
        $error->function = 'InputProcessing:sign_up:processForm';
        $error->description = translate('invalid_class_selection_description');
        $error->isMajor = true;

        return $error;
    }

    $fees = $event->FeesRequired();
    if ($fees) {
        if (!$user->FeesPaidForYear(date('Y', $event->startdate), $fees))
            return Error::AccessDenied();
    }

    $result = SignUpUser($event->id, $user->id, $class->id);
    if (is_a($result, 'Error')) {
        $result->errorPage = 'error';

        return $result;
    }

    $signup = $result ? 1 : 0;
    if ($result) {
        // Show payment if signup true
        redirect("Location: " . url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'payment', 'signup' => $signup), $nothing));
    }
    else {
        // Show queue if signup false
        redirect("Location: " . url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'signupinfo', 'signup' => $signup), $nothing));
    }
    die();
}
