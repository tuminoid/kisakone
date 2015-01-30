<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Course editor input handler
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

require_once 'data/course.php';
require_once 'data/hole.php';


function processForm()
{
    require_once 'core/hole.php';

    if (@$_POST['cancel']) {
        if (@$_GET['event']) {
            redirect("Location: " . url_smarty(array('page' => 'managecourses', 'id' => @$_GET['event']), $_POST));
        }
        else {
            redirect("Location: " . url_smarty(array('page' => 'managecourses'), $_POST));
        }
    }

    $course['Name'] = @$_POST['name'];
    if (!$course['Name']) {
        return translate("error_name_must_be_defined");
    }

    $course['Link'] = @$_POST['link'];
    $course['Map'] = $_POST['map'];
    $course['Description'] = $_POST['description'];

    if (@$_GET['id'] != 'new') {
        $course['id'] = $_GET['id'];
        $id = (int) @$_GET['id'];

        if (!IsAdmin()) {
            $oldcourse = GetCourseDetails($id);
            if (is_a($oldcourse, 'Error'))
                return $oldcourse;
            if (!$oldcourse || !$oldcourse['Event'])
                return Error::AccessDenied();

            $event = GetEventDetails($oldcourse['Event']);
            if ($event->management != 'td')
                return Error::AccessDenied();
        }

        if (@$_POST['delete']) {
            if (CourseUsed($course['id'])) {
                return translate("cant_delete_this_course");
            }
            else {
                DeleteCourse($course['id']);
                redirect("Location: " . url_smarty(array('page' => 'managecourses'), $_GET));
            }
        }
        SaveCourse($course);
    }
    else {
        if (!IsAdmin()) {
            $event = GetEventDetails(@$_GET['event']);
            if (!$event || $event->management != 'td')
                return Error::AccessDenied();
        }

        if (@$_GET['event'])
            $course['Event'] = $_GET['event'];

        if (@$_POST['delete']) {
            redirect("Location: " . url_smarty(array('page' => 'managecourses'), $_GET));
        }

        $course['id'] = null;
        $id = SaveCourse($course);
    }

    if (is_a($id, 'Error'))
        return $id;

    foreach ($_POST as $key => $value) {
        if (substr($key, -4) == '_par') {
            list($ignored, $number, $holeid, $alsoignored) = explode('_', $key);

            if (!$holeid) {
                $hole = new Hole(
                    array(
                        'Course'     => $id,
                        'HoleNumber' => $number,
                        'id'         => null,
                        'Par'        => $value,
                        'Length'     => $_POST['h_'.$number.'_'.$holeid.'_len'],
                        'HoleText'   => $_POST['h_'.$number.'_'.$holeid.'_text']
                    ));
            }
            else {
                $hole = GetHoleDetails($holeid);

                if (is_a($hole, 'Error'))
                    return $hole;
                if (!$hole)
                    return Error::NotFound('hole');
                if ($hole->course != $id) {
                    echo $hole->course,' -- ', $id;
                    return Error::InternalError('Child-container mismatch');
                }

                $hole->par        = (int) $value;
                $hole->length     = (int) @$_POST['h_'.$number.'_'.$holeid.'_len'];
                $hole->holeText   = @$_POST['h_'.$number.'_'.$holeid.'_text'];
            }

            $outcome = SaveHole($hole);
            if (is_a($outcome, 'Error'))
                return $outcome;
        }
    }

    if (@$_GET['event']) {
        redirect("Location: " . url_smarty(array('page' => 'managecourses', 'id' => @$_GET['event']), $_POST));
    }
    else {
        redirect("Location: " . url_smarty(array('page' => 'managecourses'), $_POST));
    }
}
