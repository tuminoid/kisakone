<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * New event creation handler
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
    if (!IsAdmin())
        return Error::AccessDenied();
    $problems = array();

    if (@$_POST['cancel']) {
        redirect("Location: " . BaseURL());
    }

    $name = $_POST['name'];
    if ($name == '')
        $problems['name'] = translate('FormError_NotEmpty');

    $venue = $_POST['venue'];
    if ($venue == '')
        $problems['venue'] = translate('FormError_NotEmpty');

    $tournament = $_POST['tournament'];
    if (!$tournament)
        $tournament = null;
    $level = $_POST['level'];

    if (!$level)
        $problems['level'] = translate('FormError_NotEmpty');

    if ($tournament && $level) {
        $tobj = GetTournamentDetails($tournament);
        if ($tobj->level != $level) {
            $problems['tournament'] = translate('FormError_TournamentLevelMismatch');
        }

    }

    $licenseReq = @$_POST['requireFees_license'];
    $requireFees = 0;
    if (@$_POST['requireFees_member'])
        $requireFees = LICENSE_MEMBERSHIP;
    if ($licenseReq == "requireFees_license_A")
        $requireFees = LICENSE_A;
    if ($licenseReq == "requireFees_license_B")
        $requireFees = LICENSE_B;

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
    if ($signup_start == 0)
        $signup_start = null;

    $signup_end_raw = $_POST['signup_end'];
    if (strpos($signup_end_raw, ':') === false)
        $signup_end_raw .= " 23:59";

    $signup_end = input_ParseDate($signup_end_raw);
    if ($signup_end == 0)
        $signup_end = null;

    $contact = $_POST['contact'];

    $classes = array();
    $classOperations = input_CombinePostArray('classOperations');
    if (count($classOperations)) {
        foreach ($classOperations as $op) {
            list($operation, $class) = explode(':', $op, 2);
            if ($operation == 'add') {
                $classes[] = $class;
            }
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
    if (count($roundOperations)) {
        foreach ($roundOperations as $op) {
            @list($operation, $index, $roundid, $date, $time) = explode(':', $op, 5);
            if ($operation == 'add') {
                preg_match('/\s(\d+)$/', $date, $parts);
                $rdate = $start + 60 * 60 * 24 * ((int) $parts[1] - 1);
                $rounds[$index] = array('date' => input_ParseDate(date("Y-m-d", $rdate) . " " . $time), 'time' => $time, 'datestring' => $date, 'roundid' => $roundid);
            }
            elseif ($operation == 'remove') {
                unset($rounds[$index]);
            }
        }
    }

    $td = input_GetUser($_POST['td']);
    if ($td === null) {
         $problems['td'] = translate('FormError_InvalidUser');
    }

    $officials = array();
    $officialOperations = input_CombinePostArray('officialOperations');
    if (count($officialOperations)) {
        foreach ($officialOperations as $op) {
            list($operation, $official) = explode(':', $op, 2);
            if ($operation == 'add') {
                $officials[] = $official;
            }
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
        $officialIds[] = $oid;
    }

    if (count($problems)) {
        $problems['classList'] = $classes;
        $problems['roundList'] = $rounds;
        $problems['officialList'] = $officials;

        $error = new Error();
        $error->title = 'New event form error';
        $error->function = 'InputProcessing:New_Event:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;
        $error->errorPage = 'newevent';

        return $error;
    }

    $result = NewEvent($name, $venue, $duration, $playerlimit, $contact, $tournament, $level,
        $start, $signup_start, $signup_end, $classes, $td, $officialIds, $rounds, $requireFees, $pdgaId);

    if (is_a($result, 'Error')) {
        $result->errorPage = 'error';
        return $result;
    }

    require_once 'core/email.php';
    SendEmail(EMAIL_YOU_ARE_TD, $td, GetEventDetails($result));

    redirect("Location: " . BaseURL() . "events");
}
