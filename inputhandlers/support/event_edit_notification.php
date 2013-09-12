<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Helped for displaying notification after various types of
 * event editing
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

function input_EditNotification($round = null) {
    if ($round) {
        if (!$round->GroupsAvailabled()) {
            // no need for notification, just redirect
            header("Location: " . url_smarty(array('page' => 'manageevent', 'id' => @$_GET['id']), $_GET));
            die();
        }
    }
    
    header("Location: " . url_smarty(array('page' => 'manageevent', 'notify' => true, 'id' => @$_GET['id']), $_GET));
    die();
}

?>