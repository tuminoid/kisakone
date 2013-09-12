<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Backend for providing autocomplete functionality
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
function InitializeSmartyVariables(&$smarty, $error) {
    header("Content-Type: text/javascript");
    $id = basename(@$_GET['id']);
    
    if (!file_exists("ui/autocomplete/$id.php")) return new Error();
    
    
    include("ui/autocomplete/$id.php");
    
    $options = page_Autocomplete($_GET['query']);
    
    $suggestions = $options['suggestions'];
    
    $smarty->assign('query', str_replace('"', '\"', $_GET['query']));
    
    //$smarty->assign('suggestions', array_map('Page_JSDoubleQuotes', array_values($suggestions)));
    $smarty->assign('suggestions', $suggestions);
    
    if ($options['useKeys']) {
        $smarty->assign('data', array_keys($suggestions));
    } else {
        if (array_key_exists('data', $options)) {
            $smarty->assign('data', $options['data']);
        } else {
            $smarty->assign('data', false);
        }
    }    
    
    SetContentType("text/plain");
}

/**
 * Determines which main menu option this page falls under.
 *
 * This function is required by the interface, alhtough this page doesn't have
 * the menu.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection() {
    return 'unique';
}
?>
