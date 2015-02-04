<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Event fee reminder
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
function InitializeSmartyVariables(&$smarty, $data)
{
    require_once 'core/textcontent.php';
    require_once 'core/email.php';

    language_include('email');
    $event = GetEventDetails($_GET['id']);

    if (!IsAdmin() && $event->management != 'td')
        return Error::AccessDenied();

    if (is_a($data, 'TextContent')) {
        $evp = $data;
    }
    else {
        $evp = GetGlobalTextContent('email_fee');
    }

    if (is_a($data, 'Error')) {
        $smarty->assign('error', $data->title);
    }

    if (is_a($data, 'TextContent')) {
        $ids = explode(',', $_POST['ids']);
    }
    else {
        $ids = $data->data;
    }
    $u1 = GetUserDetails($ids[0]);
    $p1 = $u1->GetPlayer();

    if (!$evp || is_a($evp, 'Error')) {
        $evp = new TextContent(array());
        $evp->type = htmlentities(substr(@$_GET['id'], 0, 16));
    }

    if (@$_REQUEST['preview']) {
        $email = new Email($evp);
        $special['link'] = 'http://www.example.com';
        $email->Prepare($u1, $p1, $event, $special);
        $smarty->assign('preview_email', $email);
    }

    $smarty->assign('inline', false);
    $smarty->assign('tokens', GetEmailTokens());
    $smarty->assign('page', $evp);
    $smarty->assign('idlist', implode(',', $ids));
    $smarty->assign('numReminds', count($ids));
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'events';
}

// We need some functions to get data for the preview
function pdr_GetDemoPlayer()
{
    $us = GetUsers();
    $user = null;
    $player = null;
    foreach ($us as $u) {
        if (!$user && $u->firstname)
            $user = $u;
        if (!$player) {

            $p = $u->GetPlayer();
            if ($p) {
                $player = $p;
            }
        }
        if ($user && $player)
            return array($user, $player);
    }

    return array($user, $player);
}

function pdr_GetDemoEvent()
{
    $events = data_GetEvents("1");
    foreach ($events as $event) {
        if ($event->signupEnd)
            return $event;
    }
    if (count($events))
        return $events[0];
    return null;
}
