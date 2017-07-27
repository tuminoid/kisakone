<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2017 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Event editor UI backend
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

require_once 'ui/support/eventform_init.php';
require_once 'data/configs.php';
require_once 'sfl/sfl_licensetypes.php';
require_once 'data/event_queue.php';


/**
 * Initializes the variables and other data necessary for showing the matching template
 * @param Smarty $smarty Reference to the smarty object being initialized
 * @param Error $error If input processor encountered a minor error, it will be present here
 */
function InitializeSmartyVariables(&$smarty, $error)
{
    global $settings;

    language_include('formvalidation');

    $e = array();

    if (sfl_enabled()) {
        $smarty->assign('sfl_enabled', true);
        $smarty->assign('sfl_membership', LICENSE_MEMBERSHIP);
        $smarty->assign('sfl_license', LICENSE_COMPETITION);
    }

    $smarty->assign('ppa_enabled', ppa_enabled());

    if ($error) {
        if (!is_array($error->data)) {
            print_r($error);
            return $error;
        }

        $smarty->assign('error', $error->data);
        $e['name'] = $_POST['name'];
        $e['club'] = $_POST['club'];
        $e['contact'] = $_POST['contact'];
        $e['venue'] = $_POST['venue'];
        $e['tournament'] = $_POST['tournament'];
        $e['level'] = $_POST['level'];
        $e['start'] = $_POST['start'];
        $e['duration'] = @$_POST['duration'];
        $e['playerlimit'] = @$_POST['playerlimit'];
        $e['signup_start'] = $_POST['signup_start'];
        $e['signup_end'] = $_POST['signup_end'];

        $e['classes'] = $error->data['classList'];
        $e['rounds'] = $error->data['roundList'];
        $e['officials'] = $error->data['officialList'];
        $e['id'] = $_POST['eventid'];
        $e['event_state'] = @$_POST['event_state'];

        $e['requireFees'] = @$_POST['requireFees'];

        $e['td'] = $_POST['td'];
        $e['oldtd'] = $_POST['oldtd'];

        $e['pdgaeventid'] = @$_POST['pdgaeventid'];
        $e['oldpdgaeventid'] = @$_POST['oldpdgaeventid'];
        $e['prosplayingam'] = @$_POST['oldprosplayingam'];
        $e['livescoring'] = @$_POST['oldlivescoring'];
    }
    else {
        $event = GetEventDetails($_GET['id']);

        if (!$event)
            return Error::NotFound('event');

        $e['id'] = $event->id;
        $e['club'] = $event->club;
        $e['name'] = $event->name;
        $e['contact'] = $event->contactInfo;
        $e['venue'] = $event->venue;
        $e['tournament'] = $event->tournamentId;
        $e['level'] = $event->levelId;

        $e['start'] = date('Y-m-d', $event->startdate);
        $e['duration'] = $event->duration;
        $e['playerlimit'] = $event->playerLimit;

        $e['signup_start'] = $event->signupStart == null ? '' : date('Y-m-d H:i', $event->signupStart);
        $e['signup_end'] = $event->signupEnd == null ? '' : date('Y-m-d H:i', $event->signupEnd);
        $e['queue_strategy'] = $event->getQueueStrategy();

        if ($event->resultsLocked)
            $e['event_state'] = 'done';
        elseif ($event->isActive)
            $e['event_state'] = 'active';

        $licenses = $event->LicensesRequired();
        $e['requireFees'] = $licenses;

        $e['classes'] = array();
        foreach ($event->GetClasses() as $class)
            $e['classes'][] = $class->id;

        $e['rounds'] = array();
        foreach ($event->GetRounds() as $round) {
            $holes = $round->GetHoles();
            $numHoles = count($holes);
            $e['rounds'][] = array('holes' => $numHoles, 'datestring' => date('Y-m-d', $round->starttime), 'time' => date('H:i', $round->starttime), 'roundid' => $round->id);
        }

        $officials = $event->GetOfficials();
        $e['officials'] = array();
        foreach ($officials as $record) {
            if ($record->role == 'td') {
                $e['td'] = $record->user->username;
                $e['oldtd'] = $record->user->id;
            }
            else
                $e['officials'][] = $record->user->username;
        }

        $e['pdgaeventid'] = $event->pdgaEventId;
        $e['oldpdgaeventid'] = $event->pdgaEventId;

        $e['prosplayingam'] = $event->prosPlayingAm;
        $e['livescoring'] = $event->liveScoring;
    }

    global $user;
    $event = GetEventDetails($_GET['id']);
    if (!$event || (!IsAdmin() && $event->management != 'td')) {
        return Error::AccessDenied('newEvent');
    }

    $smarty->assign('event', $e);
    $smarty->assign('level', GetLevelDetails($event->levelId));
    $smarty->assign('queue_strategies', GetQueuePromotionStrategies());
    $smarty->assign('livescoring_enabled', livescoring_enabled());

    page_InitializeEventFormData($smarty, false);
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'events';
}
