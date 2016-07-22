<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file includes the Classification class, which represents a single
 * classification in the system.
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

require_once 'data/rules.php';


class Classification
{
    var $id;
    var $name;
    var $minAge;
    var $maxAge;
    var $gender;
    var $available;
    var $status;
    var $priority;
    var $ratinglimit;

    /** ************************************************************************
     * Class constructor
     */
    function Classification($id = null, $name = null, $short = null, $minAge = 0, $maxAge = 0,
        $gender = null, $available = 0, $status = 'P', $priority = 0, $ratinglimit = null)
    {
        if (is_array($id)) {
            $this->initializeFromArray($id);
        }
        else {
            $this->id = $id;
            $this->name = $name;
            $this->short = $short;
            $this->minAge = $minAge;
            $this->maxAge = $maxAge;
            $this->gender = $gender;
            $this->available = $available;
            $this->status = $status;
            $this->priority = $priority;
            $this->ratinglimit = $ratinglimit;
        }
    }

    function initializeFromArray($array)
    {
        $this->id = $array['id'];
        $this->name = $array['Name'];
        $this->short = $array['Short'];
        $this->minAge = $array['MinimumAge'];
        $this->maxAge = $array['MaximumAge'];
        $this->gender = $array['GenderRequirement'];
        $this->available = $array['Available'];
        $this->status = $array['Status'];
        $this->priority = $array['Priority'];
        $this->ratinglimit = $array['RatingLimit'];
    }

    function getName()
    {
        if ($this->short)
            return $this->short . ' (' . $this->name . ')';

        return $this->name;
    }

    function getPlayers($event)
    {
        static $data;
        if ($data)
            return $data;

        $data = GetSignupsForClass($event, $this->id);

        return $data;
    }

    function getRules($event)
    {
        return GetEventRules($event, $this->id);
    }
}
