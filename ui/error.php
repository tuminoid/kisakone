<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Tournament editor ui backend for error display
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
if (!is_callable('InitializeSmartyVariables')) {
    // Some other page might already have been included, so these functions are
    // included conditionally
    function InitializeSmartyVariables(&$smarty, $error)
    {
        Error_InitializeSmartyVariables($smarty, $error);
    }

    /**
     * Determines which main menu option this page falls under.
     * @return String token of the main menu item text.
     */
    function getMainMenuSelection()
    {
        $GLOBAL['unique_title'] = translate('error_title');

        return 'unique';
    }
}

function Error_InitializeSmartyVariables(&$smarty, $error)
{
    $smarty->assign('error', $error);

    switch ($error->errorCode) {
        case 403:
            header("HTTP/1.1 403 Access Denied");
            break;

        case 404:
            header("HTTP/1.1 404 Not Found");
            break;

        case 500:
            header("HTTP/1.1 500 Internal Server Error");
            break;


        default:
            // No HTTP error
        }

        $smarty->assign('backtrace', print_r($error->backtrace, true));
    }
