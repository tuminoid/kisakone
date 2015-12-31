<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Event edit handler
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
require_once 'data/round.php';
require_once 'core/tournament.php';
require_once 'core/email.php';
require_once 'sfl/sfl_integration.php';


/**
 * Processes the login form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $problems = array();

    language_include('formvalidation');

    if (!IsAdmin()) {
        $event = GetEventDetails(@$_GET['id']);
        if ($event->management != 'td')
            return Error::AccessDenied();
    }

    if (@$_POST['delete'])
        redirect("Location: " . url_smarty(array('page' => 'confirm_event_delete', 'id' => $_GET['id']), $_GET));

    $club = $_POST['club'];
    if (sfl_enabled() && !is_numeric($club))
        $problems['club'] = translate('FormError_MustHaveClub');
    elseif ($club && !is_numeric($club))
        $problems['club'] = translate('FormError_MustHaveClub');
    if ($club == 0)
        $club = null;

    $name = $_POST['name'];
    if ($name == '')
        $problems['name'] = translate('FormError_NotEmpty');

    $venue = $_POST['venue'];
    if ($venue == '')
        $problems['venue'] = translate('FormError_NotEmpty');

    $level = $_POST['level'];
    $tournament = $_POST['tournament'];
    if ($tournament) {
        $tobj = GetTournamentDetails($tournament);
        if ($tobj->level != $level)
            $problems['tournament'] = translate('FormError_TournamentLevelMismatch');
    }

    $duration = @$_POST['duration'];
    if ((int) $duration <= 0)
        $problems['duration'] = translate('FormError_NotPositiveInteger');

    $playerlimit = @$_POST['playerlimit'];
    if ((int) $playerlimit < 0)
        $problems['playerlimit'] = translate('FormError_NotPositiveInteger');

    $start = input_ParseDate($_POST['start']);
    if ($start === null)
        $problems['start'] = translate('FormError_InvalidDate');

    $signup_start = input_ParseDate($_POST['signup_start']);
    if ($signup_start === null)
        $problems['signup_start'] = translate('FormError_InvalidDate');
    if ($signup_start == 0)
        $signup_start = null;

    $signup_end_raw = $_POST['signup_end'];
    if (strpos($signup_end_raw, ':') === false)
        $signup_end_raw .= " 23:59";

    $signup_end = input_ParseDate($signup_end_raw);
    if ($signup_end == 0)
        $signup_end = null;

    $state = $_POST['event_state'];
    $contact = $_POST['contact'];

    $classes = array();
    $classOperations = input_CombinePostArray('classOperations');
    if (count($classOperations)) {
        foreach ($classOperations as $op) {
            list($operation, $class) = explode(':', $op, 2);
            if ($operation == 'add')
                $classes[] = $class;
            elseif ($operation == 'remove') {
                $index = array_search($class, $classes);
                if ($index !== false)
                    unset($classes[$index]);
            }
            else
                fail();
        }
    }

    $rounds = array();
    $roundOperations = input_CombinePostArray('roundOperations');

    // Contains id's of any rounds to be deleted
    $deletedRounds = array();
    if (count($roundOperations)) {
        foreach ($roundOperations as $op) {
            @list($operation, $index, $roundid, $date, $time) = explode(':', $op, 5);
            if ($operation == 'add') {
                preg_match('/\s(\d+)$/', $date, $parts);
                if (isset($parts[1]))
                    $rdate = $start + 60 * 60 * 24 * ((int) $parts[1] - 1);
                else
                    $rdate = 0;

                $rounds[$index] = array('date' => input_ParseDate(date("Y-m-d", $rdate) . " " . $time), 'time' => $time, 'datestring' => $date, 'roundid' => $roundid);
            }
            elseif ($operation == 'remove') {
                $deletedRounds[] = $rounds[$index]['roundid'];
                unset($rounds[$index]);
            }
        }
    }

    $requireFees = @$_POST['requireFees'];

    $td = input_GetUser($_POST['td']);
    if ($td === null)
        $problems['td'] = translate('FormError_InvalidUser');

    $pdgaId = @$_POST['pdgaeventid'];
    if (!empty($pdgaId)) {
        if (!is_numeric($pdgaId))
            $problems['pdgaeventid'] = translate('FormError_NotPositiveInteger');
        $pdgaId = (int) $pdgaId;
        if (!(is_int($pdgaId) && $pdgaId >= 0))
            $problems['pdgaeventid'] = translate('FormError_NotPositiveInteger');
    }

    $officials = array();
    $officialOperations = input_CombinePostArray('officialOperations');
    if (count($officialOperations)) {
        foreach ($officialOperations as $op) {
            list($operation, $official) = explode(':', $op, 2);
            if ($operation == 'add')
                $officials[] = $official;
            elseif ($operation == 'remove') {
                $index = array_search($official, $officials);
                if ($index !== false)
                    unset($officials[$index]);
            }
        }
    }

    $officialIds = array();
    foreach ($officials as $official) {
        $oid = input_GetUser($official);
        if ($oid === null)
            $problems['officials'] = translate('FormError_InvalidUser');
        if ($oid == $td)
            $problems['officials'] = translate('FormError_TDasOfficial');
        $officialIds[] = $oid;
    }

    $eventid = (int) $_GET['id'];
    $event = GetEventDetails($eventid);
    if ($event === null || is_a($event, 'Error'))
        return Error::NotFound('event');

    $oldTournament = $event->tournament;

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

    $result = EditEvent($eventid, $name, $club, $venue, $duration, $playerlimit, $contact, $tournament, $level, $start, $signup_start, $signup_end, $state, $requireFees, $pdgaId);
    if (is_a($result, 'Error'))
        return $result;

    if (IsAdmin()) {
        $result = SetEventTD($event->id, $td);
        if (is_a($result, 'Error'))
            return $result;

        if ($td != @$_POST['oldtd'])
            SendEmail(EMAIL_YOU_ARE_TD, $td, GetEventDetails($eventid));
    }

    $result = SetEventOfficials($eventid, $officialIds);
    if (is_a($result, 'Error'))
        return $result;

    $result = SetEventClasses($eventid, $classes);
    if (is_a($result, 'Error'))
        return $result;

    $result = SetRounds($eventid, $rounds, $deletedRounds);
    if (is_a($result, 'Error'))
        return $result;

    UpdateEventResults($eventid);

    UpdateTournamentPoints($tournament);
    if ($tournament != $oldTournament)
        UpdateTournamentPoints($oldTournament);

    // Promote queuers if playerlimit changed
    CheckQueueForPromotions($eventid);

    $dummy = null;
    redirect("Location: " . url_smarty(array('page' => 'manageevent', 'id' => $eventid), $dummy));
}
