<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'data/configs.php';
require_once 'sfl/sfl_integration.php';
require_once 'sfl/pdga_integration.php';


function InitializeSmartyVariables(&$smarty, $error)
{
    $userid = GetUserId($_GET['id']);
    if ($userid) {
        $user = GetUserDetails($userid);
        if (is_a($user, 'Error'))
            return $user;
    }
    else {
        $user = GetUserDetails($_GET['id']);
        if (is_a($user, 'Error'))
            return $user;
        if ($user)
            $userid = $user->id;
    }

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

    $smarty->assign('sfl_enabled', sfl_enabled());
    $smarty->assign('pdga_enabled', pdga_enabled());

    if (sfl_enabled()) {
        $fees = array('membership' => array(), 'aLicense' => array(), 'bLicense' => array());

        $data = SFL_getPlayer($userid);
        $smarty->assign('data', $data);

        $year = date('Y');
        $licenses['membership'][$year] = @$data['membership'][$year];
        $licenses['license'][$year] = @$data['license'][$year];
        $smarty->assign('licenses', $licenses);

        if (GetConfig(EMAIL_VERIFICATION)) {
            // Only players with username's can be verified
            $smarty->assign('emailverification_enabled', true && $user->username);
            $smarty->assign('emailverified', $user->IsEmailVerified());
            $smarty->assign('email', $user->email);
            $smarty->assign('email_user', $user->username);
            $smarty->assign('emailverification_token', $user->GetEmailVerificationToken());
        }
    }

    if (pdga_enabled()) {
        // $force = ($itsme || @$_SESSION['user']->role == "admin") ? true : false;
        $force = false; // no forced reasons to go get it from pdga api
        $pdga_data = pdga_getPlayer(@$player->pdga, $force);
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
