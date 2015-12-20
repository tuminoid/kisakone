<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Event tax edit handler
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
    $problems = array();

    if (!IsAdmin()) {
        $event = GetEventDetails(@$_GET['id']);
        if ($event->management != 'td')
            return Error::AccessDenied();
    }

/*
    $name = $_POST['name'];
    if ($name == '')
        $problems['name'] = translate('FormError_NotEmpty');


    if (count($problems)) {
        $problems['classList'] = $classes;
        $problems['roundList'] = $rounds;
        $problems['officialList'] = $officials;

        $error = new Error();
        $error->title = 'New event form error';
        $error->function = 'InputProcessing:Edit_Event:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;

        return $error;
    }
*/

    $dummy = null;
    redirect(url_smarty(array('page' => 'manageevent', 'id' => $eventid), $dummy));
}
