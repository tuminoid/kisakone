<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Adjust tournament tie breaking
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
function processForm()
{
    if (!Isadmin())
        return Error::AccessDenied();

    $tid = @$_GET['id'];
    foreach ($_POST as $key => $value) {
        if (substr($key, 0, 3) == 'tb_') {
            $pid = substr($key, 3);
            SetTournamentTieBreaker($tid, $pid, $value);
        }
    }

    require_once 'core/tournament.php';

    UpdateTournamentPoints((int) $tid);
}
