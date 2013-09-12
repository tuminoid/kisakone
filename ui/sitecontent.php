<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Global text content editor
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
    require_once('core/textcontent.php');
    if (!IsAdmin()) return Error::AccessDenied();
    
    $GLOBALS['disable_xhtml'] = true;
    
    
    
    if (is_a($error, 'TextContent')) {
        $evp = $error;   
    } else {
        $evp = GetGlobalTextContent(@$_GET['id']);
    }
    
    if (is_a($error, 'Error')) {
        $smarty->assign('error', $error->title);        
    }
    if (!$evp || is_a($evp, 'Error')) {
        $evp = new TextContent(array());
        $evp->type = htmlentities(substr(@$_GET['id'], 0, 12));
        
        if (!is_numeric($evp->type)) {
            //$evp->content = "<h2>" . $evp->GetProperTitle() . "</h2><br /><br />";
        } else{
            $evp->type = 'custom';
        }
    }
    
    $smarty->assign('custom', @$_GET['mode'] == 'custom');
    $smarty->assign('global', true);
    $smarty->assign('page', $evp);
}



/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection() {
    return 'administration';
}
?>
