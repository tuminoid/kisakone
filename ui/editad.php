<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * AD editor UI backend
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
function InitializeSmartyVariables(&$smarty, $data) {
    
    $id = @$_GET['id'];
    if ($id == 'default') $id = null;
    if ($id) {
        $event = GetEventDetails($id);
        if (!IsAdmin() && $event->management != 'td') return Error::AccessDenied();
    } else {    
        if (!IsAdmin()) return Error::AccessDenied();
    }
        

    if (is_a($data, 'Ad')) {
        $ad = $data;
    } else {
        
                
        $ad = GetAd($id, @$_GET['adType']);
        
        // If there's no ad initially, create one
        if (!$ad) {
            $ad = new Ad(null, @$_GET['adType'], null, AD_DEFAULT, null, null, null, null);
        }
    }
    

    $adTypes = explode(' ', GLOBAL_AD_TYPES);    
    $smarty->assign('globalReferenceOptions', $adTypes);
    
    if ($id ) {
        $eventAds = explode( ' ', EVENT_AD_TYPES);
        $smarty->assign('eventReferenceOptions', $eventAds);
    }
    
    $smarty->assign('event', $id);
    
    $smarty->assign('images', pdr_FileArray(GetFilesOfType('ad')));
    
    $smarty->assign('ad', $ad);
}

/**
 * Convert files from a regular array into an array that maps file id to the display name
 */
function pdr_FileArray($files) {
    $out = array();
    foreach ($files as $file) {
        $out[$file->id] = $file->displayName;
    }
    return $out;
}


/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection() {
    
    // This is a special page, as it can be under 2 different branches
    $id = @$_GET['id'];
    if ($id && $id != 'default') {
        return 'events';
    } else {
        return 'administration';
    }
}
?>
