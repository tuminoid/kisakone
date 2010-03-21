<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Level editing/creation
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
 * Processes the form
 * @return Nothing or Error object on error
 */
function processForm() {
    
    require_once('core/scorecalculation.php');
    
    
    if (!IsAdmin()) return error::AccessDenied();
    $problems = array();
    
    $nothing = null;
    if (@$_POST['cancel']) {
        
    
        header("Location: " . url_smarty(array('page' => 'managelevels'), $nothing));
        die();
    }
    
    if (@$_POST['delete']) {
        $outcome = DeleteLevel($_GET['id']);
        if (is_a($outcome, 'Error')) return $outcome;
        
        header("Location: " . url_smarty(array('page' => 'managelevels'), $nothing));
        die();
    }
    
    $name = $_POST['name'];
    if ($name == '') $problems['name'] = translate('FormError_NotEmpty');
    
    $method = $_POST['scoreCalculationMethod'];
    if (is_a(GetScoreCalculationMethod('level', $method), 'Error')) $problems['scoreCalculationMethod'] = translate('FormError_InternalError');
    
    $available = (bool)@$_POST['available'];
    
    if(count($problems)) {
        $error = new Error();
        $error->title = 'Level Editor form error';        
        $error->function = 'InputProcessing:Edit_Level:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;
        return $error;
    }
    
    
    if ($_GET['id'] != 'new') {
        $result = EditLevel($_GET['id'], $name, $method, $available);
    } else {
        $result = CreateLevel($name, $method, $available);
    }
    
    if (is_a($result, 'Error')) {
        $result->errorPage = 'error';
        return $result;
    }
    
    $variableNeededAsItsReference = null;
    header("Location: " . url_smarty(array('page' => 'managelevels'), $variableNeededAsItsReference));    
        
   
}

?>