<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2017 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Event listing
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

require_once 'core/textcontent.php';


/**
 * Initializes the variables and other data necessary for showing the matching template
 * @param Smarty $smarty Reference to the smarty object being initialized
 * @param Error $error If input processor encountered a minor error, it will be present here
 */
function InitializeSmartyVariables(&$smarty, $error)
{
    $user = @$_SESSION['user'];
    $events = array();

    global $event_sort_mode;
    $event_sort_mode = @$_GET['sort'];

    $tc = GetGlobalTextContent('index');
    if ($tc)
        $smarty->assign('content', $tc->formattedText);

    if ($user) {
        $plr = $user->GetPlayer();

        if (pdga_enabled() && $plr && $plr->pdga > 0) {
            require_once 'pdga/pdga_integration.php';
            $smarty->assign('pdga_data', pdga_getPlayer($plr->pdga));
            $smarty->assign('player', $plr);
        }
    }


    $id = @$_GET['id'];
    switch ($id) {
        case 'mine':
            if (!$user)
                return Error::AccessDenied();

            if (!$user->GetPlayer())
                $smarty->assign('error', translate('admins_dont_participate'));

            $events = $user->GetMyEvents('participant');
            $title = 'myevents_title';
            break;


        case 'manage':
            // FIXME: User is sometimes empty and call fails, find out when
            if ($user)
                $events = $user->GetMyEvents('manager');
            $title = 'manage_events_title';
            break;


        case 'relevant':
            $events = GetRelevantEvents();
            $title = 'relevant_events';
            break;


        case '':
        case 'default':
            global $fullTemplateName;
            $fullTemplateName = "index.tpl";
            $current = GetRelevantEvents();
            $upcoming = GetUpcomingEvents(true);
            $registering = GetRegisteringEvents();
            $registeringsoon = GetRegisteringSoonEvents();
            $past = GetPastEvents(true);
            $smarty->assign('lists', array($current, $registering, $registeringsoon, $upcoming, $past));
            $title = 'index_title';
            break;


        case 'past':
            $events = GetPastEvents(false, date("Y"));
            $title = 'past_events';
            break;


        case 'upcoming':
            $events = GetUpcomingEvents(false);
            $title = 'upcoming_events';
            break;


        case 'currentYear':
            $events = GetEventsByYear(date('Y'));
            $title = 'current_year_events_title';
            break;

        case 'level':
            $levelid = @$_GET['level'];
            $year = date('Y');
            $level = GetLevelDetails($levelid);
            $events = GetEventsByLevel($levelid, $year);
            $title = "!" . $level->name;
            break;

        case 'byUser':
            global $user;
            $uid = GetUserId(@$_GET['username']);
            if (is_a($uid, 'Error'))
                return $uid;
            $theuser = GetUserDetails($uid);
            if (is_a($theuser, 'Error'))
                return $theuser;
            if (!$theuser)
                return Error::Notfound('user');

            $loginUser = $user;
            $user = $theuser;
            $events = $user->GetMyEvents('participant');
            $user = $loginUser;
            $title = '!' . translate('user_events_title', array('eventuser' => htmlentities(@$_GET['username'])));
            break;


        default:
            if (!is_numeric($id))
                return Error::AccessDenied();

            $events = GetEventsByYear((int) $id);
            $title = '!' . translate('events_by_year', array('year' => (int) $id));
            break;
        }

        if (is_a($events, 'Error')) {
            return $events;
    }

    if ($title[0] != '!')
        $title = translate($title);
    else
        $title = substr($title, 1);

    $smarty->assign('title', $title);
    $smarty->assign('events', $events);
    $smarty->assign('events_count', count($events));
    $smarty->assign('loggedon', isset($_SESSION['user']));
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'events';
}
