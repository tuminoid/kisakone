<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Tournament editing/creation
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
require_once 'core/scorecalculation.php';


/**
 * Processes the edit tournament form
 * @return Nothing or Error object on error
 */
function processForm()
{
    if (!IsAdmin())
        return error::AccessDenied();
    $problems = array();

    if (@$_POST['cancel'])
        redirect(url_smarty(array('page' => 'managetournaments'), $problems));

    if (@$_POST['delete']) {
        $outcome = DeleteTournament($_GET['id']);
        if (is_a($outcome, 'Error'))
            return $outcome;
        redirect(url_smarty(array('page' => 'managetournaments'), $outcome));
    }

    $name = $_POST['name'];
    if ($name == '')
        $problems['name'] = translate('FormError_NotEmpty');

    $year = $_POST['year'];
    if ((int) $year == '')
        $problems['year'] = translate('FormError_NotEmpty');

    $method = $_POST['scoreCalculationMethod'];
    if (is_a(GetScoreCalculationMethod('tournament', $method), 'Error'))
        $problems['scoreCalculationMethod'] = translate('FormError_InternalError');

    $level = (int) $_POST['level'];
    if (GetLevelDetails($level) === null)
        $problems['level'] = translate('FormError_InternalError');

    $description = @$_POST['description'];

    $available = (bool) @$_POST['available'];

    if (count($problems)) {
        $error = new Error();
        $error->title = 'Tournament Editor form error';
        $error->function = 'InputProcessing:Edit_Tournament:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;

        return $error;
    }

    if ($_GET['id'] != 'new')
        $result = EditTournament($_GET['id'], $name, $method, $level, $available, (int) $year, $description);
    else
        $result = CreateTournament($name, $method, $level, $available, (int) $year, $description);

    if (is_a($result, 'Error'))
        return $result;

    $variableNeededAsItsReference = null;
    redirect(url_smarty(array('page' => 'managetournaments'), $variableNeededAsItsReference));
}
