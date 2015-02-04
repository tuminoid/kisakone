<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * This file defines a class which represents and official or tournament
 * director of an event
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
 * Normally this type of thing wouldn't have an entire class to itself, but
 * this one does. 1:1 mapping with the matching database table.
 */
class EventOfficial
{
    var $id;
    var $eventid;
    var $user;
    var $role;

    /** ************************************************************************
     * Class constructor
     */
    function EventOfficial($id = 0, $eventId = 0, $user = null, $role = "")
    {
        $this->id = $id;
        $this->eventid = $eventId;
        $this->user = $user;
        $this->role = $role;
    }
}
