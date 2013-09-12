<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * License and membership payment management
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
 * Processes the login form
 * @return Nothing or Error object on error
 */
function processForm() {
    if (!IsAdmin()) {
        return Error::AccessDenied('manage_fees');
    }
    $reminds = array();
        
    if (!@$_POST['cancel']) {
        
        $payments = array();
        
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 8) == 'oldlfee_') {
                list($ignore, $userid, $year) = explode('_', $key);
                $newfee = @$_POST['newlfee_' . $userid . '_' . $year];
                
                $newfee = (bool)$newfee;
                $value = (bool)$value;
                
                if ($newfee != $value) {
                    if (!array_key_exists($userid, $payments)) $payments[$userid] = array();
                    if (!array_key_exists('license', $payments[$userid])) $payments[$userid]['license'] = array();
                    $payments[$userid]['license'][$year] = $newfee;
                }            
            } else if (substr($key, 0, 8) == 'oldmfee_') {
                list($ignore, $userid, $year) = explode('_', $key);
                $newfee = @$_POST['newmfee_' . $userid . '_' . $year];
                
                $newfee = (bool)$newfee;
                $value = (bool)$value;
                
                if ($newfee != $value) {
                    if (!array_key_exists($userid, $payments)) $payments[$userid] = array();
                    if (!array_key_exists('membership', $payments[$userid])) $payments[$userid]['membership'] = array();
                    $payments[$userid]['membership'][$year] = $newfee;
                }            
            } else if (substr($key, 0, 7) == 'remind_') {
                $reminds[] = substr($key, 7);
            }
        }
            
        if (count($payments)) StorePayments($payments);
    }
    
    if (count($reminds)) {
        header("Location: " . url_smarty(array('page' => 'eventfeereminder', 'users' => implode($reminds, ',')), $_GET));
    } else {
        header("Location: " . url_smarty(array('page' => 'manage_users'), $_GET));
    }
    
    
   
}

?>