<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Page for modifying Configurations
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

require_once 'data/config.php';


/**
 * Initializes the variables and other data necessary for showing the matching template
 * @param Smarty $smarty Reference to the smarty object being initialized
 * @param Error $error If input processor encountered a minor error, it will be present here
 */
function InitializeSmartyVariables(&$smarty, $error)
{
    if (!IsAdmin())
        return Error::AccessDenied();

    if ($error)
        $smarty->assign('error', $error->data);

    $smarty->assign('configs', GetConfigs());
    $smarty->assign('bool_options', array('0' => translate('config_no'), '1' => translate('config_yes')));
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'administration';
}
