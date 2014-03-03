<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Round editing
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

function processForm()
{
    if (@$_POST['cancel']) {
        header("Location: " . url_smarty(array('page' => 'editrounds', 'id' => @$_GET['id']), $_POST));
        die();
    }

    $event = GetEventDetails(@$_GET['id']);

    if ($event->resultsLocked) return Error::AccessDenied();

    if (!IsAdmin() && $event->management != 'td') {
        return Error::AccessDenied();
    }

    $validRounds = array();

    foreach ($_POST as $key => $value) {

        if (substr($key, -5) == '_date') {
            // round
            $roundid = (int) $key;
            $round = GetRoundDetails($roundid);
            if ($round->eventId != $event->id) {
                return Error::InternalError('Child-container mismatch');
            }

            $validRounds[] = $roundid;

            $date = input_ParseDate($value);
            $startType = @$_POST[$roundid . "_starttype"];

            if ($startType != 'sequential' && $startType != 'simultaneous') {
                return Error::InternalError('Invalid selection with despite options');
            }

            $valid = false;
            if (isset($_POST[$roundid . '_valid'])) $valid = $_POST[$roundid . '_valid'];
            $interval = (int) @$_POST[$roundid . "_interval"];

            $course = $_POST[$roundid . '_course'];
            if (!$course) $course = null;

            $outcome = SetRoundDetails($roundid, $date, $startType, $interval, $valid, $course);
            if (is_a($outcome, 'Error')) return $outcome;

        }

    }

        require_once 'inputhandlers/support/event_edit_notification.php';

        return input_EditNotification();
}
