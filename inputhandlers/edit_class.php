<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Class editor input handler
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


function processForm() {



    if (!IsAdmin()) return error::AccessDenied();
    $problems = array();


    if (@$_POST['cancel']) {

        $empty = null;
        header("Location: " . url_smarty(array('page' => 'manageclasses'), $empty));
        die();
    }

    if (@$_POST['delete']) {
        $outcome = DeleteClass($_GET['id']);
        if (is_a($outcome, 'Error')) return $outcome;

        header("Location: " . url_smarty(array('page' => 'manageclasses'), $_POST));
        die();
    }

    $name = $_POST['Name'];
    if ($name == '') $problems['Name'] = translate('FormError_NotEmpty');

    $minage = $_POST['MinimumAge'];
    if ($minage != '' && !is_numeric($minage)) $problems['MinimumAge'] = translate('FormError_NotPositiveInteger');

    $maxage = $_POST['MaximumAge'];
    if ($maxage != '' && !is_numeric($maxage)) $problems['MaximumAge'] = translate('FormError_NotPositiveInteger');

    $gender = $_POST['GenderRequirement'];
    if (!in_array($gender, array('', 'M', 'F'))) $problems['GenderRequirement'] = translate('FormError_InternalError');

    $available = (bool)@$_POST['Available'];

    if(count($problems)) {
        $error = new Error();
        $error->title = 'Class Editor form error';
        $error->function = 'InputProcessing:Edit_Class:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;
        return $error;
    }


    if (!$minage) $minage = null;
    if (!$maxage) $maxage = null;

    if ($_GET['id'] != 'new') {
        $result = EditClass($_GET['id'], $name, $minage, $maxage, $gender, $available);
    } else {
        $result = CreateClass($name, $minage, $maxage, $gender, $available);
    }

    if (is_a($result, 'Error')) {
        $result->errorPage = 'error';
        return $result;
    }

    $variableNeededAsItsReference = null;
    header("Location: " . url_smarty(array('page' => 'manageclasses'), $variableNeededAsItsReference));
    die();
}

?>