<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Splitting classes into sections
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

function ProcessForm() {
    
    if (@$_POST['cancel']) {
        header("Location: " . url_smarty(array('page' => 'editrounds', 'id' => @$_GET['id']), $_GET));
        die();
    }
  
    
    $event = GetEventDetails($_GET['id']);
    
   if (!$event) return Error::NotFound('event');

     if ($event->resultsLocked) return Error::AccessDenied();

    
    if (!IsAdmin() && $event->management != 'td') {
        return Error::AccessDenied();
    }
    if (!@$_REQUEST['round'] && @$_GET['round']) $_REQUEST['round'] = $_GET['round'];
   
   $round = GetRoundDetails(@$_REQUEST['round']);
   if (!$round || $round->eventId != $event->id) return Error::Notfound('round');
   
   $newIds = array();




   
   foreach ($_POST as $key => $item) {
        if (substr($key, 0, 8) == "base_c_n") {
            if ($item == "") $item = null;
            $newIds[substr($key, 7)] = CreateSection($round->id, $item, @$_POST["cname_" . substr($key, 7)]);
            
        }
        
   }
   
   $confirmedSections = array();
   
   foreach ($_POST as $key => $item) {
        if (substr($key, 0, 6) == "cname_") {
            $id = substr($key, 6);
            
            
            if (array_key_exists($id, $newIds)) {
                $id = $newIds[$id];
            } else {
                if (!isset($confirmedSections[$id]) ) {
                    $section = GetSectionDetails($id);
                    if ($section->round != $round->id) fail();
                    $confirmedSections[$id] = true;
                }
                
            }
            
            RenameSection($id, $item);
        }
        
   }
   
   $assign = array();
   foreach ($_POST as $key => $item) {
        if (substr($key, 0, 1) == "p") {
            $pid = substr($key, 1);
            $gid = substr($item, 2);
            
            if (array_key_exists($gid, $newIds)) $gid = $newIds[$gid];
            else {
                if (!$confirmedSections[$gid]) fail();
            }
            
            if (!isset($assign[$gid])) $assign[$gid] = array();
            $assign[$gid][] = $pid;
        }
   }
   
   ResetRound($round->id, 'players');
   
   foreach ($assign as $sectId => $players)  {
        
        AssignPlayersToSection($round->id, $sectId, $players );
   }
   
   RemoveEmptySections($round->id);
   
   header("Location: " . url_smarty(array('page' => 'starttimes', 'id' => @$_GET['id'], 'round' => $round->id), $_GET));
   
   
}

?>