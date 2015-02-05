<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file is the handler for "add competitor" form
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

/**
 * Processes the form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $problems = array();
    require_once 'core/event_management.php';
    require_once 'core/user_operations.php';

    $godmode = false;
    $eventid = @$_GET['id'];
    $userid = @$_GET['user'];
    $event = GetEventDetails($eventid);

    if (!IsAdmin() && $event->management != 'td')
        return Error::AccessDenied('addcompetitor');
    else
        $godmode = true;

    if ($event->resultsLocked)
        return Error::AccessDenied();

    if (@$_POST['cancel']) {
        $empty = null;
        redirect("Location: " . url_smarty(array('page' => 'addcompetitor', 'id' => $eventid), $empty));
    }

    // Simply selecting a user, not creating a new one
    if ($userid != 'new') {
        // Adding player to competition check only competition, queue will be erased if promoted to competition
        if (UserParticipating($eventid, $userid))
            return translate("player_already_participating");

        // Adding player to queue checks also the queue
        if (@$_POST['accept_queue'] && UserQueueing($eventid, $userid))
            return translate("player_already_queueing");

        $u = GetUserDetails($userid);
        $player = $u->GetPlayer();
        $class = GetClassDetails($_POST['class']);

        if (!$player->IsSuitableClass($class))
            return translate("error_invalid_class");

        $retVal = SignupUser($_GET['id'], $userid, $_POST['class'], @$_POST['accept_queue'] ? false : $godmode);
        if (is_a($retVal, 'Error'))
            return $retVal;
        redirect("Location: " . url_smarty(array('page' => 'addcompetitor', 'id' => $eventid, 'signup' => $retVal), $_GET));
    }
    else {
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
        if ($pdga == '') {
            $pdga = null;
        }
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
    }

    $u = RegisterPlayer(null, null, $email, $firstname, $lastname, $gender, $pdga, $dobYear);
    if (is_a($u, 'Error'))
        return $u;

    redirect("Location: " . url_smarty(array('page' => 'addcompetitor', 'id' => $eventid, 'signup' => 1), $_GET));
}
