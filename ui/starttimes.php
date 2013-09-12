<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Section start time management
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
   
   
    if ($event->resultsLocked) $smarty->assign('locked' , true);
    
    if (!IsAdmin() && $event->management != 'td') {
        return Error::AccessDenied();
    }
    
    
if (!@$_REQUEST['round'] && @$_GET['round']) $_REQUEST['round'] = $_GET['round'];
   if (!@$_REQUEST['round']) {
      require_once('ui/support/roundselection.php');
      return page_SelectRound($event, $smarty);
   }

   
   $round = GetRoundDetails(@$_REQUEST['round']);
   if (!$round || $round->eventId != $event->id) return Error::Notfound('round');
   
   $sections =  GetSections($round->id);
   
   

   $smarty->assign('startTime', date('H:i', $round->starttime));
   $smarty->assign('eventid', $event->id);
   
   $smarty->assign('interval' , (int)$round->interval);
  
   $smarty->assign('sections', $sections);
   

            
   
}



/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection() {
    return 'events';
}
?>