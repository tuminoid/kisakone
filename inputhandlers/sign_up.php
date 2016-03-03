<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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
require_once 'sfl/pdga_integration.php';
require_once 'data/configs.php';


/**
 * Processes the form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $nothing = null;
    if (@$_POST['cancel'])
        redirect(url_smarty(array('page' => 'event', 'id' => @$_GET['id']), $nothing));

    global $user;
    if (!$user)
        return Error::AccessDenied();
    if ($user->role == 'admin')
        return Error::AccessDenied();

    $event = GetEventDetails(@$_GET['id']);
    if (!$event)
        return Error::NotFound('event');

    if ($event->approved !== null)
        redirect(url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'payment'), $nothing));

    if (!$event->signupPossible())
        return Error::AccessDenied();

    $player = $user->GetPlayer();
    $status = $event->GetPlayerStatus($player->id);
    if ($status != 'notsigned')
        redirect(url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'signupinfo'), $nothing));

    $pdga_data = (pdga_enabled() && isset($player) && $player->pdga) ? pdga_getPlayer($player->pdga) : null;

    $class = GetClassDetails(@$_POST['class']);
    if (!@$_POST['class'] || !$player->IsSuitableClass($class, $pdga_data)) {
        $error = new Error();
        $error->title = 'invalid_class_selection';
        $error->function = 'InputProcessing:sign_up:processForm';
        $error->description = translate('invalid_class_selection_description');
        $error->isMajor = true;

        return $error;
    }

    if (!$user->LicensesPaidForYear(date('Y', $event->startdate), $event->LicensesRequired()))
        return Error::AccessDenied();

    $result = SignUpUser($event->id, $user->id, $class->id);
    if (is_a($result, 'Error')) {
        $result->errorPage = 'error';
        return $result;
    }

    $signup = $result ? 1 : 0;
    if ($result && payment_enabled())
        redirect(url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'payment', 'signup' => $signup), $nothing));

    redirect(url_smarty(array('page' => 'event', 'id' => @$_GET['id'], 'view' => 'signupinfo', 'signup' => $signup), $nothing));
}
