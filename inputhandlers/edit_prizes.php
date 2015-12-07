<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Prizes editor input handler
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
 * Processes the edit tournament form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $problems = array();

    if (!isAdmin())
        return Error::AccessDenied();

    // Don't save if there is errors
    if (count($problems)) {
        $error = new Error();
        $error->title = 'Prizes form error';
        $error->function = 'InputProcessing:Prizes:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;

        return $error;
    }

    // Go to main admin page after success
    redirect(url_smarty(array('page' => 'admin'), $_GET));
}
