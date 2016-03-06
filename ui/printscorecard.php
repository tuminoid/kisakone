<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Printable score card
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
    $event = GetEventDetails($_GET['id']);

    $smarty->assign('event', $event);

    if (is_a($event, 'Error'))
        return $event;

    if (!IsAdmin() && $event->management == '')
        return Error::AccessDenied();

    if (!$event)
        return Error::NotFound('event');

    if (!isAdmin() && !$event->isTD() && !$event->isActive) {
        $error = new Error();
        $error->isMajor = true;
        $error->title = 'error_event_not_active';
        $error->description = translate('error_event_not_active_description');
        $error->source = 'PDR:Event:InitializeSmartyVariables';

        return $error;
    }

    $rounds = $event->GetRounds();

    foreach ($rounds as $index => $round) {
        if ($_GET['round'] == $index + 1) {
            $round->roundNumber = $index + 1;
            break;
        }
    }
    if (!$round->roundNumber)
        return Error::NotFound('round');

    if (!$round->course) {
        $error = new Error();
        $error->isMajor = true;
        $error->title = 'error_round_no_course';
        $error->description = translate('error_round_no_course_description');
        $error->source = 'PDR:Event:InitializeSmartyVariables';

        return $error;
    }

    $holes = $round->GetHoles();
    $smarty->assign('holes', $holes);
    $smarty->assign('round', $round);
    $smarty->assign('numHoles', count($holes));
    $smarty->assign('out_hole_index', ceil(count($holes) / 2));

    $smarty->assign('groups', pdr_GroupByGroup($round->GetAllGroups()));
}

function pdr_GroupByGroup($data)
{
    $out = array();

    $currentGroup = array();
    $currentNum = - 1;
    foreach ($data as $row) {
        if ($row['GroupNumber'] != $currentNum) {
            if (count($currentGroup))
                $out[] = $currentGroup;
            $currentGroup = array();
            $currentNum = $row['GroupNumber'];
        }

        $currentGroup[] = $row;
    }
    if (count($currentGroup))
        $out[] = $currentGroup;
    return $out;
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'events';
}
