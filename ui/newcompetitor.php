<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file is the UI backend for creating a competitor
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

require_once 'data/configs.php';
require_once 'sfl/sfl_integration.php';
require_once 'sfl/pdga_integration.php';
require_once 'data/event.php';


/**
 * Initializes the variables and other data necessary for showing the matching template
 * @param Smarty $smarty Reference to the smarty object being initialized
 * @param Error $error If input processor encountered a minor error, it will be present here
 */
function InitializeSmartyVariables(&$smarty, $error)
{
    $event = GetEventDetails(@$_GET['id']);
    $pdga = @$_GET['pdga'];
    $sflid = @$_GET['sflid'];
    $user = @$_GET['user'];

    if ($event->resultsLocked)
        $smarty->assign('locked', true);
    if (!IsAdmin() && $event->management != 'td')
        return Error::AccessDenied('newcompetitor');

    $smarty->assign('id_entered', $pdga || $sflid);
    $smarty->assign('fail', @$_GET['fail']);

    if ($pdga && pdga_enabled())
        return pdga_competitor($smarty, $pdga);
    if ($sflid && sfl_enabled())
        return sfl_competitor($smarty, $sflid);

    // show empty form
}


function pdga_competitor(&$smarty, $pdga)
{
    $smarty->assign('pdga', $pdga);
    $smarty->assign('edit_email', 1);
    $pdga_data = pdga_getPlayer($pdga);

    // Display an error if connection fails
    if ($pdga_data == null) {
        $smarty->assign('pdga_error', 'pdga_server_error');
    }
    else {
        if (strtoupper($pdga_data['country']) == 'FI') {
            $smarty->assign('pdga_error', 'pdga_shouldnt_add_finnish');
        }
        $smarty->assign('firstname', $pdga_data['first_name']);
        $smarty->assign('lastname', $pdga_data['last_name']);
        $smarty->assign('birthyear', $pdga_data['birth_year']);
        $smarty->assign('gender', $pdga_data['gender']);
    }
}


function sfl_competitor(&$smarty, $sflid)
{
    $smarty->assign('sflid', $sflid);
    $sfl_data = sfl_api_get_by_id($sflid);

    if ($sfl_data == null) {
        $smarty->assign('sfl_error', 'sfl_server_error');
    }
    else {
        $smarty->assign('firstname', $sfl_data['firstname']);
        $smarty->assign('lastname', $sfl_data['lastname']);
        $smarty->assign('birthyear', $sfl_data['birthyear']);
        $smarty->assign('gender', $sfl_data['gender']);
        $smarty->assign('email', $sfl_data['email']);
        $smarty->assign('pdga', $sfl_data['pdga']);
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
