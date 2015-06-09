<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * User details page
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

require_once 'config.php';
require_once 'sfl/sfl_integration.php';
require_once 'sfl/pdga_integration.php';


function InitializeSmartyVariables(&$smarty, $error)
{
    global $settings;

    $userid = GetUserId($_GET['id']);

    if (!$userid)
        return Error::NotFound('user');

    $user = GetUserDetails($userid);
    if (is_a($user, 'Error'))
        return $user;

    if (!$user)
        return Error::NotFound('user_record');

    $player = $user->GetPlayer();

    $smarty->assign('userinfo', $user);
    $smarty->assign('player', $player);

    $itsme = $user->username == @$_SESSION['user']->username;
    $smarty->assign('itsme', $itsme);

    if ($itsme) {
        $ad = GetAd(null, 'myinfo');
        if ($ad)
            $smarty->assign('ad', $ad);
    }

    $smarty->assign('sfl_enabled', @$settings['SFL_ENABLED']);
    $smarty->assign('pdga_enabled', @$settings['PDGA_ENABLED']);

    if (@$settings['SFL_ENABLED'] == true) {
        $fees = array('membership' => array(), 'aLicense' => array(), 'bLicense' => array());

        $data = SFL_getPlayer($userid);
        $smarty->assign('data', $data);

        $year = date('Y');
        $fees['membership'][$year] = @$data['membership'][$year];
        $fees['aLicense'][$year] = @$data['a_license'][$year];
        $fees['bLicense'][$year] = @$data['b_license'][$year];
        $smarty->assign('fees', $fees);
    }

    if (@$settings['PDGA_ENABLED'] == true) {
        // $force = ($itsme || @$_SESSION['user']->role == "admin") ? true : false;
        $force = false; // no forced reasons to go get it from pdga api
        $pdga_data = pdga_getPlayer($player->pdga, $force);
        if ($pdga_data)
            SmartifyPDGA($smarty, $pdga_data);
    }

    $smarty->assign('isadmin', @$_SESSION['user']->role == "admin");
}


/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'users';
}
