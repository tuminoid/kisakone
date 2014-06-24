<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Maps forms and actions to their handler units
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
 * Chooses the right input handler for sent form data, and calls it.
 * @return Nothing or Error object on error
 */
function gate_ProcessInputData()
{
    $actionresult = gate_ProcessActionRequest();
    if (is_a($actionresult, 'Error')) return $actionresult;

    // If anything sensible was returned, skip form processing entirely
    if ($actionresult) return $actionresult;
    if (count($_POST) == 0) return;

    // Verify that a form id is defined, and that it's valid

    $formid = @$_POST['formid'];
    if (!$formid) return gate_InvalidForm($formid);

    $formid = basename($formid);
    if (!file_exists("inputhandlers/$formid.php")) return gate_InvalidForm($formid);

    // Include the form handler, and call it. The function is defined in the
    // included file.

    include("inputhandlers/$formid.php");

    return ProcessForm();


}

/**
 * Chooses the right handler for a selected action, and calls it.
 * @return Nothing or Error object on error
 */
function gate_ProcessActionRequest()
{
    if (!array_key_exists('action', $_GET)) return;

    $action = $_GET['action'];

    $action = basename($action);
    if (!file_exists("inputhandlers/action_$action.php")) return gate_InvalidForm($action);

    // Include the action handler, and call it. The function is defined in the
    // included file.

    include("inputhandlers/action_$action.php");

    return ProcessAction();
}

/**
 * Returns an Error object for the error of invalid form.
 */
function gate_InvalidForm($formid)
{
    $e = new Error();
    $e->title = 'error_invalidform';
    $e->description = translate('error_invalidform_description');
    $e->cause = $formid;
    $e->internalDescription = 'No handler exists for the specified form or action id';
    $e->isMajor = true;

    return $e;
}
