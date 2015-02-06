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

    $getId = $_GET['id'];
    if (is_numeric($getId) && is_a(GetUserDetails($getId), 'User'))
        $userid = $getId;
    else
        $userid = GetUserId($getId);

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

    if (IsAdmin() || $itsme) {
        if ($settings['SFL_ENABLED'] == true) {
            $fees = array('membership' => array(), 'aLicense' => array(), 'bLicense' => array());

            $year = date('Y');
            $data = SFL_getPlayer($user->id, $year);
            $smarty->assign('data', $data);

            $fees['membership'][$year] = $data['membership'];
            $fees['aLicense'][$year] = $data['a_license'];
            $fees['bLicense'][$year] = $data['b_license'];
            $smarty->assign('fees', $fees);
        }

        if (@$settings['PDGA_ENABLED'] && isset($player->pdga) && $player->pdga > 0) {
            $smarty->assign('pdga', $player->pdga);
            $pdga_data = pdga_getPlayer($player->pdga);

            // Display an error if connection fails
            if ($pdga_data == null)
                $smarty->assign('pdga_error', 'pdga_server_error');
            else {
                $smarty->assign('pdga_rating', $pdga_data['rating']);
                $smarty->assign('pdga_classification', $pdga_data['classification'] == "P" ? "Pro" : "Am");
                $smarty->assign('pdga_birth_year', $pdga_data['birth_year']);
                $smarty->assign('pdga_gender', $pdga_data['gender']);
                $smarty->assign('pdga_membership_status', $pdga_data['membership_status']);
                $smarty->assign('pdga_membership_expiration_date', $pdga_data['membership_expiration_date']);
                $smarty->assign('pdga_official_status', $pdga_data['official_status']);
                $smarty->assign('pdga_country', strtoupper($pdga_data['country']));
            }
        }
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
