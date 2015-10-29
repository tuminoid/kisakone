<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Class editor UI backend
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
    if (!IsAdmin())
        return Error::AccessDenied();

    if ($error) {
        $smarty->assign('error', $error->data);
        $smarty->assign('class', $_POST);
    }
    else {
        $class = GetClassDetails($_GET['id']);
        if (@$_GET['id'] != 'new' && !$class || is_a($class, 'Error')) {
            return Error::NotFound('class');
        }
        $smarty->assign('class', $class);
    }

    $smarty->assign('genderOptions', array('' => translate('noRestriction'), 'M' => translate('male'), 'F' => translate('female'),));
    $smarty->assign('statusOptions', array('' => translate('class_notdefined'), 'A' => translate('class_am'), 'P' => translate('class_pro'),));

    $smarty->assign('deletable', !ClassBeingUsed($_GET['id']));
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'administration';
}
