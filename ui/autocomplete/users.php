<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Autocomplete listing for users
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

function page_Autocomplete($query)
{
    $users = GetUsers($query);
    $display = array();
    $data = array();

    //print_r($users);

    foreach ($users as $user) {
        $display[] = $user->fullname . " (" . $user->username . ")";
        $data[] = $user->username . " (" . $user->fullname . ")";
    }

    return array('suggestions' => $display,
                 'data' => $data,
                 'useKeys' => false);

}
