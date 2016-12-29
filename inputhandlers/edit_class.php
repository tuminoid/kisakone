<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2015-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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
function processForm()
{
    if (!IsAdmin())
        return error::AccessDenied();
    $problems = array();

    if (@$_POST['cancel']) {
        $empty = null;
        redirect("Location: " . url_smarty(array('page' => 'manageclasses'), $empty));
    }

    if (@$_POST['delete']) {
        $outcome = DeleteClass($_GET['id']);
        if (is_a($outcome, 'Error'))
            return $outcome;

        redirect("Location: " . url_smarty(array('page' => 'manageclasses'), $_POST));
    }

    $name = $_POST['Name'];
    if ($name == '')
        $problems['Name'] = translate('FormError_NotEmpty');

    $short = $_POST['Short'];
    if ($short == '')
        $problems['Short'] = translate('FormError_NotEmpty');

    $minage = $_POST['MinimumAge'];
    if ($minage != '' && !is_numeric($minage))
        $problems['MinimumAge'] = translate('FormError_NotPositiveInteger');

    $maxage = $_POST['MaximumAge'];
    if ($maxage != '' && !is_numeric($maxage))
        $problems['MaximumAge'] = translate('FormError_NotPositiveInteger');

    $gender = $_POST['GenderRequirement'];
    if (!in_array($gender, array('', 'M', 'F')))
        $problems['GenderRequirement'] = translate('FormError_InternalError');

    $available = (bool) @$_POST['Available'];

    $status = $_POST['Status'];
    if (!in_array($status, array('', 'A', 'P')))
        $problems['Status'] = translate('FormError_InternalError');

    $priority = $_POST['Priority'];
    if (!is_numeric($priority) || $priority <= 0)
        $problems['Priority'] = translate('FormError_NotPositiveInteger');

    $ratinglimit = $_POST['RatingLimit'];
    if ($ratinglimit != '' && !is_numeric($ratinglimit))
        $problems['RatingLimit'] = translate('FormError_NotPositiveInteger');

    $prosplayingamlimit = $_POST['ProsPlayingAmLimit'];
    if ($prosplayingamlimit != '' && !is_numeric($prosplayingamlimit))
        $problems['ProsPlayingAmLimit'] = translate('FormError_NotPositiveInteger');

    if (count($problems)) {
        $error = new Error();
        $error->title = 'Class Editor form error';
        $error->function = 'InputProcessing:Edit_Class:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;

        return $error;
    }

    if (!$minage)
        $minage = null;
    if (!$maxage)
        $maxage = null;
    if (!$ratinglimit)
        $ratinglimit = null;
    if (!$prosplayingamlimit)
        $prosplayingamlimit = null;

    if ($_GET['id'] != 'new') {
        $result = EditClass($_GET['id'], $name, $short, $minage, $maxage, $gender, $available, $status, $priority, $ratinglimit, $prosplayingamlimit);
    }
    else {
        $result = CreateClass($name, $short, $minage, $maxage, $gender, $available, $status, $priority, $ratinglimit, $prosplayingamlimit);
    }

    if (is_a($result, 'Error')) {
        $result->errorPage = 'error';

        return $result;
    }

    $variableNeededAsItsReference = null;
    redirect("Location: " . url_smarty(array('page' => 'manageclasses'), $variableNeededAsItsReference));
}
