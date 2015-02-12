<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Event registration rules input handler.
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


/**
 * Processes the rules form
 *
 * @return Nothing
 */
function processForm()
{
    $eventid = (int) $_POST['eventid'];

    foreach ($_POST as $key => $val) {
        if (substr($key, 0, 4) != "rule")
            continue;

        $rule = explode('_', $key);
        $ruleid = isset($rule[2]) ? "new" . $rule[1] : $rule[1];
        $rules[$ruleid][$rule[0]] = $val;
    }

    DeleteEventRules($eventid);

    foreach ($rules as $ruleid => $rule) {
        $ruleid = substr($ruleid, 0, 3) == "new" ? null : $ruleid;
        list($classid, $type, $op, $value, $action, $until) = parseRule($rule);
        SaveRule($ruleid, $eventid, $classid, $type, $op, $value, $action, $until);
    }

    $dummy = null;
    redirect("Location: " . url_smarty(array('page' => 'manageevent', 'id' => $eventid), $dummy));
}


function parseRule($rule)
{
    $classid = $rule['ruleclass'] == 0 ? null : $rule['ruleclass'];
    $type = $rule['ruletype'];
    $op = $rule['ruleop'];
    $value = $rule['rulevalue'];
    $action = $rule['ruleaction'];
    $until = $rule['rulevaliduntil'];

    return array($classid, $type, $op, $value, $action, $until);
}
