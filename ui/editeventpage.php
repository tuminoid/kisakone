<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Event page editor UI backend
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
    $GLOBALS['disable_xhtml'] = true;

    $event = GetEventDetails($_GET['id']);

    if (is_a($error, 'TextContent')) {
        $evp = $error;
    }
    else {
        $evp = $event->GetTextContent(@$_GET['content']);
    }

    if (is_a($error, 'Error')) {
        $smarty->assign('error', $error->title);
    }
    if (!$evp || is_a($evp, 'Error')) {
        $evp = new TextContent(array());
        $evp->type = htmlentities(substr(@$_GET['content'], 0, 12));

        if (!is_numeric($evp->type)) {
            if (@$_GET['mode'] != 'news' && $evp->type != 'index_schedu') {

                $evp->content = "<h2>" . $evp->GetProperTitle() . "</h2><br /><br />";
            }
        }
        else {
            $evp->type = 'custom';
        }
    }

    if (!IsAdmin() && $event->management != 'td') {
        if ($evp->type == 'news' && $event->management == 'official' || (@$_GET['content'] == '*' && @$_GET['mode'] == 'news')) {
            // allowed in
        }
        else {
            return Error::AccessDenied('eventfees');
        }
    }

    $smarty->assign('custom', @$_GET['custom'] || @$_GET['mode'] == 'custom');
    $smarty->assign('custom', @$_GET['mode'] == 'custom');
    $smarty->assign('page', $evp);
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'events';
}
