<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * This file is UI baseholder for main ad management page
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
    if (!IsAdmin()) return Error::AccessDenied();
        
    require_once('core/ads.php');
    $ads = GetAllAds(null);
    
    $adTypes = explode(' ', GLOBAL_AD_TYPES);
    
    $adTypes = array_flip($adTypes);
    
    foreach ($ads as $ad) {
        $adTypes[$ad->contentId] = false;
    }
    
    foreach ($adTypes as $adType => $userd) {
        if ($userd === false) continue;
        
        $ads[] = new Ad(null, $adType, null, AD_DEFAULT, null, null, null, null);
    }
    
    $smarty->assign('ads', $ads);
}



/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection() {
    return 'administration';
}
?>
