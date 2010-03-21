<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Functionality used exclusively for Suomen Frisbeeliitto. 
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

// Not enabled at this time
define("OVERRIDE_PAYMENTS", true);

function SFL_FeesPaidForYear($user, $year) {
//if (!@$_GET['x']) return array(false, false);
    $query = data_query("SELECT license, sfl_player.pdga
                        FROM sfl_membership
                        INNER JOIN sfl_player ON (sfl_player.player_id = sfl_membership.player_id)
                        INNER JOIN :Player ON
                            ((:Player.pdga = sfl_player.pdga OR sfl_player.pdga = '' )
                            AND  cast( cast(:Player.firstname as binary) as char character set utf8) = sfl_player.firstname
                            AND  cast( cast(:Player.lastname as binary) as char character set utf8) = sfl_player.lastname                            
                            AND YEAR(:Player.birthdate) = YEAR(sfl_player.birthdate))
                        INNER JOIN :User ON :User.Player = :Player.player_id
                        WHERE :User.id = %d AND sfl_membership.year = %d ORDER BY sfl_player.pdga = ''"
                        , $user, $year);
    $result = mysql_query($query);
    echo mysql_error();
    
    $membership = false; $license = false;
    
    $pdgaFound = false;
    
    while (($row = mysql_fetch_assoc($result)) !== false){
        
        if ($row['pdga']) {
            $pdgaFound = true;
        } else {
            if ($pdgaFound) continue;
        }
        if ($row['license'] == 1) $membership = true;
        if ($row['license'] == 2) $license = true;
        
        
    }
    
    mysql_free_result($result);
    
    return array($license, $membership);
}
?>
