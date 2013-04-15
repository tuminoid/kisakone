<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Finnish Championship style tournament score calculation
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

class scorecalc_level_sm {
    var $name;
    var $id;
    
    function scorecalc_level_sm() {
        $this->id = $this->id = substr(get_class($this), 16);
        $this->name = 'SM';
    }
    
    function CalculateScores(&$participants, $totalHoles, $event ,$active) {
        if (!count($participants)) return;
        
        $className = $participants[0]['Name'];
        if (stripos($className, 'naiset') !== false) {
# Janne muutti, tapani pyyti
#            $scores = array(100,93,87,82,78,75,72,69,66,63,60,57,54,51,48,45,42,39,36,33,30,27,24,21,18,15,12,9,6,3);
            $scores = array(100,80,65,52,40,30,20,10);

        } else {
            $scores = array(100,93,87,82,78,75,72,69,66,63,60,57,54,51,48,45,42,39,36,33,30,27,24,21,18,15,12,9,6,3);
# Janne muutti, tapani pyyti, vain naisill vähän pisteitä, muilla sarjoilla täydet
#            $scores = array(100,80,65,52,40,30,20,10);
        }
        
        $participantCount = $active;

        foreach ($participants as $index => $participant) {
            $done = 0;
            foreach ($participant['Rounds'] as $round) {
                $done += $round['Completed'];
            }
            
            /*if ($done == 0) {
                $score = 0;
            } else {*/
                $standing = $participant['Standing'];
                $same = 0;                
                for ($i = $index - 1; $i >= 0; --$i) {
                    if ($participants[$i]['Standing'] == $standing) $same++;
                    else break;
                }
                
                for ($i = $index + 1; $i < count($participants); ++$i) {
                    if ($participants[$i]['Standing'] == $standing) $same++;
                    else break;
                }
                
                if ($same == 0) {
                    $score = 0;
                    $score = @$scores[$standing - 1];
                } else {
                    $score = 0;
                    
                    $left = $same + 1;
                    while ($left--) {
                        $score += @$scores[$standing + $left - 1];
                    }
                    $score = round($score * 10 / ($same + 1)) / 10;
                    
                }
                
            //}
            $score *= 10;
            
            if ($score != $participant['TournamentPoints']) {
                $participants[$index]['TournamentPoints'] = $score;
                $participants[$index]['Changed'] = true;
            }

        }
    }
    
    
}
?>