<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Score calculation unit for having no score calculation
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

class scorecalc_level_none {
    var $name;
    var $id;
    
    function scorecalc_level_none() {
        $this->id = $this->id = substr(get_class($this), 16);
        $this->name = translate('not_used');
    }
    
    function CalculateScores(&$participants, $totalHoles, $event ,$active) {
        $participantCount = $active;
        
        foreach ($participants as $index => $participant) {
           $score = 0;
            
            if ($score != $participant['TournamentPoints']) {
                $participants[$index]['TournamentPoints'] = $score;
                $participants[$index]['Changed'] = true;
            }

        }
    }
}
?>