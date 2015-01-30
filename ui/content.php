<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * UI backend for custom text content page
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
    // Can't ensure the validity of custom content
    $GLOBALS['disable_xhtml'] = true;

    require_once 'core/textcontent.php';

    $evp = GetGlobalTextContent(@$_GET['id'], true );


    if (is_a($evp, 'Error')) return $evp;
    if (!$evp) return Error::NotFound('textcontent');

    // The actualy type of the content determines access people have to the page

    switch ($evp->type) {
        case 'custom':
            // default case, everyone has access
            break;
        case 'custom_man':
            global $user;

            if (!IsAdmin() && (!$user || !UserIsManagerAnywhere($user->id)) ) return Error::AccessDenied();
            break;
        case 'custom_adm':
            if (!IsAdmin() ) return Error::AccessDenied();
            break;
        default:
            break;
    }

    $smarty->assign('page', $evp);
}



/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'administration';
}
