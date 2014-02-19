<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Event class quotas.
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
    $event = GetEventDetails($_GET['id']);

    if ($event->resultsLocked)
        return Error::AccessDenied();

    if (!IsAdmin() && $event->management != 'td') {
        return Error::AccessDenied('eventclasses');
    }
    if (@$_POST['cancel']) {
        header("Location: " . url_smarty(array('page' => 'manageevent', 'id' => $_GET['id']), $_GET));
        die();
    }
    $failures = false;

    foreach ($_POST as $key => $value) {
        // Process minimum quota
        if (substr($key, 0, 9) == "minquota_") {
            $qid = substr($key, 9);
            SetEventClassMinQuota($event->id, $qid, $value);
        }
        // Process maximum quota
        else if (substr($key, 0, 9) == "maxquota_") {
            $qid = substr($key, 9);
            SetEventClassMaxQuota($event->id, $qid, $value);
        }
    }

    if ($failures)
        return true;
}

?>
