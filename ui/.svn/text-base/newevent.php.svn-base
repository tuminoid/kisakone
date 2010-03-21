<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * "Create new event" page
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
    language_include('formvalidation');
    if (!IsAdmin()) return Error::AccessDenied('newEvent');
    
    require_once('ui/support/eventform_init.php');
    
    $e = array();
    if ($error) {
        $smarty->assign('error', $error->data);
        $e['name'] = $_POST['name'];
        $e['contact'] = $_POST['contact'];
        $e['venue'] = $_POST['venue'];
        $e['tournament'] = $_POST['tournament'];
        $e['level'] = $_POST['level'];
        $e['start'] = $_POST['start'];
        $e['duration'] = @$_POST['duration'];
        $e['signup_start'] = $_POST['signup_start'];
        $e['signup_end'] = $_POST['signup_end'];
        
        $e['classes'] = $error->data['classList'];
        $e['rounds'] = $error->data['roundList'];
        $e['officials'] = $error->data['officialList'];
                
        
        $e['td'] = $_POST['td'];
    }
    
    
    $smarty->assign('event', $e);
    
    page_InitializeEventFormData($smarty, true);
    
    
    
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection() {
    return 'events';
}
?>