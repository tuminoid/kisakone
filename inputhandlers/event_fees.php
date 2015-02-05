<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm�
 *
 * Event fee change handler
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
    require_once 'core/event_management.php';

    $event = GetEventDetails($_GET['id']);
    if ($event->resultsLocked)
        return Error::AccessDenied();

    if (!IsAdmin() && $event->management != 'td') {
        return Error::AccessDenied('eventfees');
    }

    $reminds = array();
    $payments = array();
    foreach ($_POST as $key => $value) {
        if (substr($key, 0, 7) == 'oldfee_') {
            list($ignore, $userid, $partid) = explode('_', $key);
            $newfee = @$_POST['newfee_' . $userid . '_' . $partid];

            $newfee = (bool) $newfee;
            $value = (bool) $value;

            if ($newfee != $value) {

                $payments[] = array('participationId' => $partid, 'payment' => $newfee);
            }
        }
        elseif (substr($key, 0, 7) == 'remind_') {
            $reminds[] = substr($key, 7);
        }
    }

    if (count($payments)) {
        MarkEventFeePayments($_GET['id'], $payments);
    }

    if (count($reminds)) {
        if (in_array('all', $reminds))
            $reminds = GetAllToRemind($event->id);
        //redirect("Location: " . url_smarty(array('page' => 'eventfeereminder', 'id' => $_GET['id'], 'users' => implode($reminds, ',')), $reminds));
        $error = new Error();
        $error->internalDescription = 'redirecting, not a real error';
        $error->errorPage = 'remind';
        $error->data = $reminds;

        return $error;
    }
    else {
        require_once 'inputhandlers/support/event_edit_notification.php';

        return input_EditNotification();
    }
}
