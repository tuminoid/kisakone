<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm�
 * Copyright 2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * This file is the UI backend for adding competitors to an event
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
    $event = GetEventDetails(@$_GET['id']);

    if (!$event)
        return Error::NotFound('event');
    if ($event->resultsLocked)
        $smarty->assign('locked' , true);
    if (is_a($event, 'Error'))
        return $event;
    if (!IsAdmin() && $event->management != 'td')
        return Error::AccessDenied('addcompetitor');

    if (@$_GET['user']) {
        // User has been selected; show edit/confirmation form

        $classes = $event->GetClasses();
        $classOptions = array();

        foreach ($classes as $class) {
            $classOptions[$class->id] = $class->name;
        }

        $smarty->assign('classOptions', $classOptions);

        $uid = @$_GET['user'];
        if ($uid == 'new') {
            // We don't have an existing user, activate edit mode and initialize
            // the fields from an empty user
            $smarty->assign('userdata', new User());
            $smarty->assign('edit', true);
        } else {
            $smarty->assign('userdata', GetUserDetails($_GET['user'] ));
        }
    } elseif (@$_GET{'op_s'} || @$_GET['player']) {
        // "Search" button has been pressed

        $query = @$_GET['player'];

        // Due to autocomplete we have some extra characters which cause the search
        // to fail, remove them
        $query = preg_replace("/[\(\),]/", "", $query);
        $players = GetPlayerUsers($query);
        if (count($players) == 1) {
            // Single player, skip the listing
            redirect("Location: " . url_smarty(array('page' => 'addcompetitor', 'id' => @$_GET['id'], 'user' => $players[0]->id), $_GET));
        } else {
            $smarty->assign('many', $players);
        }
    }

    if (is_object($error)) {
        $smarty->assign('error', $error->data);
    } elseif (is_string($error)) {
        $smarty->assign('errorString', $error);
    }
}


/**
 * Determines which main menu option this page falls under.
 *
 * This function is required by the interface, alhtough this page doesn't have
 * the menu.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'events';
}
