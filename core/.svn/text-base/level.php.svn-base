<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * This file contains the Level class
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

/* *****************************************************************************
 * This class represents a single level in the system.
 */
class Level 
{
    var $id;
    var $name;
    var $scoreCalculationMethod;
    var $available;
    
    /** ************************************************************************
     * Class constructor
     */
    function Level( $id = null,
                    $name = "",
                    $scoreCalculationMethod = null, $available = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->scoreCalculationMethod = $scoreCalculationMethod;
        $this->available = $available;
        
        return;
    }
    
    /** ************************************************************************
     * Method for getting the score calculation method name.
     *
     * Returns the name of the score calculation method.
     */
    function getScoreCalculationName()
    {
        require_once('core/scorecalculation.php');
        $methodName = "";
        
        if( !($this->scoreCalculationMethod == ""))
        {
            $obj = GetScoreCalculationMethod('level', $this->scoreCalculationMethod);
            $methodName = $obj->name;
        }
        
        return $methodName;
    }
}

/* ****************************************************************************
 * End of file
 * */
?>