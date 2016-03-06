<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Manage event quotas for event
 *
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

require_once 'data/event.php';
require_once 'data/event_queue.php';


/* Initializes the variables and other data necessary for showing the matching template
* @param Smarty $smarty Reference to the smarty object being initialized
* @param Error $error If input processor encountered a minor error, it will be present here
*/
function InitializeSmartyVariables(&$smarty, $error)
{
    $event = GetEventDetails($_GET['id']);
    $view = isset($_GET['view']) ? $_GET['view'] : 0;

    if (!IsAdmin() && $event->management != 'td') {
        return Error::AccessDenied('eventfees');
    }

    $smarty->assign('playerlimit', $event->playerLimit);
    $smarty->assign('quotas', GetEventQuotas($event->id));
    $smarty->assign('counts', GetEventParticipantCounts($event->id));
    $smarty->assign('queues', GetEventQueueCounts($event->id));
    $smarty->assign('oldstrategy', GetQueuePromotionStrategy($event->id));
    $smarty->assign('strategies', GetQueuePromotionStrategies());
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'events';
}
