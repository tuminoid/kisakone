<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file is the handler for "new competitor" form
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

require_once 'data/class.php';
require_once 'core/event_management.php';
require_once 'core/user_operations.php';


/**
 * Processes the form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $problems = array();

    $eventid = @$_GET['id'];
    $event = GetEventDetails($eventid);

    if (!IsAdmin() && $event->management != 'td')
        return Error::AccessDenied('newcompetitor');
    if ($event->resultsLocked)
        return Error::AccessDenied();

    if (@$_POST['cancel'])
        redirect(url_smarty(array('page' => 'newcompetitor', 'id' => $eventid), $_GET));

    // we have a pdga number
    $pdga_post = @$_POST['pdga_preview'];
    $pdga_preview = (is_numeric($pdga_post) && $pdga_post > 0) ? $pdga_post : null;
    if ($pdga_preview)
        redirect(url_smarty(array('page' => 'newcompetitor', 'id' => $eventid, 'pdga' => $pdga_preview), $_GET));

    // we have a sflid number
    $sflid_post = @$_POST['sflid_preview'];
    $sflid_preview = (is_numeric($sflid_post) && $sflid_post > 0) ? $sflid_post : null;
    if ($sflid_preview)
        redirect(url_smarty(array('page' => 'newcompetitor', 'id' => $eventid, 'sflid' => $sflid_preview), $_GET));

    // If its not a preview page, nor lastname is submitted from the main form, throw it back
    if (!$sflid_preview && !$pdga_preview && !@$_POST['lastname'])
        redirect(url_smarty(array('page' => 'newcompetitor', 'id' => $eventid), $_GET));

    // Here we have the form to be checked
    $lastname = $_POST['lastname'];
    if ($lastname == '')
        $problems['lastname'] = translate('FormError_NotEmpty');

    $firstname = $_POST['firstname'];
    if ($firstname == '')
        $problems['firstname'] = translate('FormError_NotEmpty');

    $email = $_POST['email'];
    if (!preg_match('/^.+@.+\..+$/', $email))
        $problems['email'] = translate('FormError_InvalidEmail');

    $pdga = $_POST['pdga'];
    if ($pdga == '')
        $pdga = null;
    else {
        $num = (int) $pdga;
        if ($num <= 0)
            $problems['pdga'] = translate('FormError_PDGA');
    }

    $gender = @$_POST['gender'];
    if ($gender != 'male' && $gender != 'female')
        $problems['gender'] = translate('FormError_NotEmpty');

    $dobYear = $_POST['dob_Year'];
    if ($dobYear != (int) $dobYear)
        $problems['dob'] = translate('FormError_NotEmpty');

    $class = (int) @$_POST['class'];

    if (count($problems)) {
        $error = new Error();
        $error->title = 'Add_Competitor form error';
        $error->function = 'InputProcessing:Add_Competitor:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;

        return $error;
    }

    $u = RegisterPlayer(null, null, $email, $firstname, $lastname, $gender, $pdga, $dobYear);
    if (is_a($u, 'Error'))
        return $u;

    redirect(url_smarty(array('page' => 'addcompetitor', 'id' => $eventid, 'signup' => 1), $_GET));
}
