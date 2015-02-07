<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'sfl/sfl_integration.php';
require_once 'data/event.php';


/**
 * Initializes the variables and other data necessary for showing the matching template
 * @param Smarty $smarty Reference to the smarty object being initialized
 * @param Error $error If input processor encountered a minor error, it will be present here
 */
function InitializeSmartyVariables(&$smarty, $error)
{
    $event = GetEventDetails(@$_GET['id']);
    $user = @$_GET['user'];
    $player = @$_GET['player'];

    if (!$event)
        return Error::NotFound('event');
    if ($event->resultsLocked)
        $smarty->assign('locked', true);
    if (is_a($event, 'Error'))
        return $event;
    if (!IsAdmin() && $event->management != 'td')
        return Error::AccessDenied('addcompetitor');

    if ($user) {
        // User has been selected; show edit/confirmation form
        $classes = $event->GetClasses();
        $classOptions = array();

        foreach ($classes as $class)
            $classOptions[$class->id] = $class->name;

        $userdata = GetUserDetails($user);
        $smarty->assign('userdata', $userdata);
        $player = GetUserPlayer($user);

        foreach ($classOptions as $cid => $cname) {
            $class = GetClassDetails($cid);
            if ($player && !$player->IsSuitableClass($class))
                unset($classOptions[$cid]);
        }

        $year = date('Y');
        $data = SFL_getPlayer($user);
        $smarty->assign('sfl_license_a', @$data['a_license'][$year]);
        $smarty->assign('sfl_license_b', @$data['b_license'][$year]);
        $smarty->assign('sfl_membership', @$data['membership'][$year]);

        $fees = $event->FeesRequired();
        $licenses_ok = $userdata->FeesPaidForYear($year, $fees);
        $smarty->assign('license_required', $fees);
        $smarty->assign('licenses_ok', $licenses_ok);

        // Get user's pdga data
        global $settings;
        $smarty->assign('pdga', false);

        // if PDGA API is enabled and player has PDGA number assigned, do the checks
        if (@$settings['PDGA_ENABLED'] && isset($player->pdga) && $player->pdga > 0) {
            $smarty->assign('pdga', true);
            $pdga_data = pdga_getPlayer($player->pdga);

            // Display an error if connection fails
            if ($pdga_data == null)
                $smarty->assign('pdga_error', 1);
            else {
                $smarty->assign('pdga_rating', $pdga_data['rating']);
                $smarty->assign('pdga_classification', $pdga_data['classification'] == "P" ? "Pro" : "Am");
                $smarty->assign('pdga_birth_year', $pdga_data['birth_year']);
                $smarty->assign('pdga_gender', $pdga_data['gender']);
                $smarty->assign('pdga_membership_status', $pdga_data['membership_status']);
                $smarty->assign('pdga_membership_expiration_date', $pdga_data['membership_expiration_date']);
                $smarty->assign('pdga_official_status', $pdga_data['official_status']);
                $smarty->assign('pdga_country', strtoupper($pdga_data['country']));

                // Remove classes from drop-down based on PDGA data
                foreach ($classOptions as $cid => $cname) {
                    /* pdga data is sometimes wrong, we already filter by local gender data
                    if ($pdga_data['gender'] == "M" && $pdga_data['gender'] != substr($cname, 0, 1))
                        unset($classOptions[$cid]);
                    */
                    $ama_or_junior = (substr($cname, 1, 1) == "A" || substr($cname, 1, 1) == "J");
                    if ($pdga_data['classification'] == "P" && $ama_or_junior)
                        unset($classOptions[$cid]);
                }
            }
        }
        $smarty->assign('classOptions', $classOptions);
    }
    elseif (@$_GET['op_s'] || $player) {
        // "Search" button has been pressed
        // Due to autocomplete we have some extra characters which cause the search to fail, remove them
        if (substr($player, - 4, 4) == ", 0)") {
            $has_pdga_number = false;
            $player = str_replace(", 0)", ")", $player);
        }
        else
            $has_pdga_number = true;

        $query = preg_replace("/[\(\),]/", "", $player);
        $players = GetPlayerUsers($query, '', $has_pdga_number);
        if (count($players) == 1) {
            // Single player, skip the listing
            redirect("Location: " . url_smarty(array('page' => 'addcompetitor', 'id' => @$_GET['id'], 'user' => $players[0]->id), $_GET));
        }
        else {
            $smarty->assign('many', $players);
        }
    }

    if (is_object($error)) {
        $smarty->assign('error', $error->data);
    }
    elseif (is_string($error)) {
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
