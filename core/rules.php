<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
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
require_once 'sfl/pdga_integration.php';


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
    $eventid = (int) $eventid;
    $classid = (int) $classid;
    $playerid = (int) $playerid;

    $classrules = GetEventRules($eventid, $classid);
    $commonrules = GetEventRules($eventid, 0);
    $player = GetPlayerDetails($playerid);
    $pdga = @$player->pdga;
    $pdgadata = pdga_getPlayer($pdga);

    $rules = array_merge($commonrules, $classrules);
    if (!count($rules)) {
        error_log("no rules, true");
        return true;
    }

    foreach ($rules as $index => $rule) {
        $id = $rule['id'];
        $type = $rule['Type'];
        $op = $rule['Op'];
        $value = $rule['Value'];
        $action = $rule['Action'];
        $valid = $rule['Valid'];

        if (!$valid) {
            //error_log("rule $id is not valid (expired $valid)");
            continue;
        }

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
        //error_log(sprintf("type: %-8s op: %-2s value: %-5s action: %-6s -> result: %-5s", $type, $op, $value, $action, $pass ? "true" : "false"));

        if ($pass == false) {
            //error_log("failed, taking action: $action");
            return $action;
        }
    }

    return true;
}
