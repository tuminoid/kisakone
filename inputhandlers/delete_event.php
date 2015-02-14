<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Deletes an event permanently
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

require_once 'core/tournament.php';


/**
 * Processes the login form
 * @return Nothing or Error object on error
 */
function processForm()
{
    if (!IsAdmin())
        return Error::AccessDenied();

    if (@$_POST['cancel'])
        redirect("Location: " . url_smarty(array('page' => 'editevent', 'id' => @$_POST['id']), $_GET));

    $event = GetEventDetails(@$_POST['id']);
    if (!$event)
        return Error::NotFound('event');

    $tournament = $event->tournament;

    DeleteEvent($event);
    UpdateTournamentPoints($tournament);
}
