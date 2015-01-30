<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Course editor UI backend
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
    language_include('events');
    require_once 'core/hole.php';

    if (is_string($error))
        $smarty->assign('error', $error);

    if (@$_GET['id'] == 'new') {
        if (!IsAdmin()) {
            $eventid = @$_GET['event'];
            if (!$eventid)
                return Error::AccessDenied();

            $event = GetEventDetails($eventid);
            if ($event->management != 'td')
                return Error::AccessDenied();
        }

        if (!(int) @$_GET['holes'] && !@$_GET['template'] ) {
            // New item, no holes defined, no template either
            $smarty->assign('holeChooser', true);
            return;
        }

        if (@$_GET['template']) {
            // Initialize data from template
            $course =  GetCourseDetails(@$_GET['template']);
            $course['id'] = 'new';
            $smarty->assign('course', $course);
            $oh = GetCourseHoles(@$_GET['template']);
            $holes = array();
            foreach ($oh as $hole) {
                $hole->id = null;
                $holes[] = $hole;
            }
            $smarty->assign('holes', $holes);
        }
        else {
            // Number of holes defined, create blank holes
            $smarty->assign('course', array('Name' => '', 'Link' => '', 'Map' => '', 'Description' => '', 'id' => 'new'));
            $holes = (int) @$_GET['holes'];
            $h = array();
            $ind = 1;
            do {
                $h[] = new Hole(array('holeNumber' => $ind, 'par' => 0, 'length' => 0));
            }
            while ($ind++ != $holes);
            $smarty->assign('holes', $h);
        }
    }
    else {
        // Edit mode
        $course =  GetCourseDetails(@$_GET['id']);
        if (!IsAdmin()) {
            $eventid = $course['Event'];
            if (!$eventid)
                return Error::AccessDenied();

            $event = GetEventDetails($eventid);
            if ($event->management != 'td')
                return Error::AccessDenied();
        }

        $smarty->assign('course',$course);
        $smarty->assign('holes', GetCourseHoles(@$_GET['id']));

        if (CourseUsed($course['id'])) {
            $smarty->assign('warning', true);
        }
    }
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    if (@$_GET['id'])
        return 'unique';
    else
        return 'administration';
}
