<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Custom event page listing backend
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
    
     $event = GetEventDetails($_GET['id']);
    if (!$event) return Error::NotFound('event');
    
    if (!IsAdmin() && !$event->IsTD()) {
        return Error::AccessDenied();
    }

    $menuitem = page_GetSelectedMenuItem($smarty->get_template_vars('submenu'));
    $pages = GetAllTextContent(@$_GET['id']);
    
    // Filtering is done here, as there's not all that much data that needs to be ignored
    $links = array();
    foreach ($pages as $page) {
        if ($page->type != 'custom') continue;
        
        $links[] = array('title' => $page->title, 'link' => array('page' => 'editeventpage', 'id' => @$_GET['id'], 'mode' => 'custom', 'content' => $page->id));
    }

    $smarty->assign('links', $links);
}



/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection() {
    return 'events';
}
?>
