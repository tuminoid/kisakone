<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Main menu definition
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
 * Returns the main menu as an array for arrays. Each item has 'url' and 'title' subitems.
 * @return array
*/
function page_initializeMainMenu() {
    
    $mainmenu = array(        
        array('title' => 'events', 'url' => 'events'),
        array('title' => 'tournaments', 'url' => 'tournaments'),
        array('title' => 'users', 'url' => 'users')        
        
    );
    
    if (IsAdmin()) $mainmenu[] = array('title' => 'administration', 'url' => 'admin');
    
    return $mainmenu;
}

include('submenu.php');

?>
