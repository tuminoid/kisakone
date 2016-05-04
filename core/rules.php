<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Core module for Registration Rules
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

require_once 'data/rules.php';
require_once 'data/player.php';
require_once 'data/configs.php';


function RuleCheck($op, $a, $b)
{
    switch ($op) {
        case '>':
            return ($a > $b);
        case '>=':
            return ($a >= $b);
        case '<':
            return ($a < $b);
        case '<=':
            return ($a <= $b);
        case '==':
            return ($a == $b);
        case '!=':
            return ($a != $b);
        default:
            error_log("ruleop=$op not found");
            return false;
    }
}


function CheckEventRules($eventid, $classid, $playerid)
{
    // If PDGA API not enabled, we don't have any data for rule checking
    if (!pdga_enabled())
        return true;
    require_once 'pdga/pdga_integration.php';

    $eventid = (int) $eventid;
    $classid = (int) $classid;
    $playerid = (int) $playerid;

    $classrules = GetEventRules($eventid, $classid);
    $commonrules = GetEventRules($eventid, 0);
    $player = GetPlayerDetails($playerid);
    $pdga = @$player->pdga;
    $pdgadata = pdga_getPlayer($pdga);

    $rules = array_merge($commonrules, $classrules);
    if (!count($rules))
        return true;

    foreach ($rules as $index => $rule) {
        $id = $rule['id'];
        $type = $rule['Type'];
        $op = $rule['Op'];
        $value = $rule['Value'];
        $action = $rule['Action'];
        $valid = $rule['Valid'];

        if (!$valid)
            continue;

        switch ($type) {
            case 'rating':
                $data = $pdgadata['rating'];
                break;

            case 'country':
                $data = $pdgadata['country'];
                break;

            case 'player':
                $data = $pdgadata['pdga_number'];
                break;

            case 'status':
                $data = $pdgadata['classification'];
                break;

            case 'co':
                $data = $pdgadata['official_status'] == "yes" ? 1 : 0;
                break;

            default:
                error_log("ruletype=$type not matching");
                return 'reject';
        }

        $pass = RuleCheck($op, $data, $value);

        if ($pass == false)
            return $action;
    }

    return true;
}
