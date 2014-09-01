<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Group editor
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
 * Initializes the variables and other data necessary for showing the matching template
 * @param Smarty $smarty Reference to the smarty object being initialized
 * @param Error $error If input processor encountered a minor error, it will be present here
 */
function InitializeSmartyVariables(&$smarty, $error)
{
    language_include('errors');
    $event = GetEventDetails($_GET['id']);

    if (!IsAdmin() && $event->management != 'td') {
        return Error::AccessDenied('eventfees');
    }

    if ($event->resultsLocked) {
        $smarty->assign('locked' , true);
    }

    if (!@$_REQUEST['round'] && @$_GET['round']) {
        $_REQUEST['round'] = $_GET['round'];
    }

    if (!@$_REQUEST['round']) {
        require_once 'ui/support/roundselection.php';
        return page_SelectRound($event, $smarty);
    }

    $round = GetRoundDetails(@$_REQUEST['round']);
    if (!$round || $round->eventId != $event->id) {
        return Error::Notfound('round');
    }

    if (@$_GET['regenerate']) {
        $round->RegenerateGroups();
        redirect("Location: " . url_smarty(array('page' => 'editgroups', 'id' => @$_GET['id'], 'round' => @$_GET['round']), $_GET));

    } else {
        if ($round->InitializeGroups()) {
            $smarty->assign('suggestRegeneration', true);
        }
    }

    $smarty->assign('round', $round);
    $smarty->assign('data', GetSections($round->id));

    if ($round->starttype == 'simultaneous') {
        $holes = $round->GetHoles();
        $smarty->assign('numHoles', count($holes));
    }
}

/**
* Determines which main menu option this page falls under.
* @return String token of the main menu item text.
*/
function getMainMenuSelection()
{
    return 'events';
}

/** WTF? */
function GetPlayersByGroup($class)
{
    die();
    return array();
}
