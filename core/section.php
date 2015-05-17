<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file contains the Section class.
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
class Section
{
    var $id;
    var $classification;
    var $name;
    var $round;

    var $startTime;
    var $priority;
    var $present;

    var $userStartTime;


    /** ************************************************************************
     * Class constructor
     */
    function Section($row)
    {
        $this->id = $row['id'];
        $this->name = $row['Name'];
        $this->classification = $row['Classification'];
        $this->round = $row['Round'];
        $this->startTime = $row['StartTime'];
        $this->priority = $row['Priority'];
        $this->present = $row['Present'];
    }


    /**
     * Returns the name of the class for which this section was created
    */
    function GetClassName()
    {
        if ($this->classification) {
            $class = GetClassDetails($this->classification);
            return $class->name;
        }
        else
            return translate('combined_group_name');
    }


    /**
     * Returns all members of this sectoin
    */
    function getPlayers()
    {
        static $data = array();
        if (isset($data[$this->id]))
            return $data[$this->id];

        $data[$this->id] = GetSectionMembers($this->id);

        return $data[$this->id];
    }


    // Returns the number of groups this section can form
    function EstimateNumberOfGroups()
    {
        $all = $this->getPlayers(@$_GET['id']);

        $num = count($all);
        if ($num == 5)
            return 1;
        if ($num == 9)
            return 2;
        return ceil($num / 4);
    }


    /**
     * Returns all the groups in this section
    */
    function GetGroups()
    {
        return GetGroups($this->id);
    }


    /**
     * Initializes this section's groups
    */
    function InitializeGroups($round, &$start, &$changes)
    {
        $players = $this->GetPlayers();
        if ($this->startTime && $round->starttype == 'sequential')
            $start = $this->startTime;

        $playersById = array();
        foreach ($players as $player)
            $playersById[$player['PlayerId']] = $player;

        $groups = GetGroups($this->id);
        foreach ($groups as $group) {
            foreach ($group['People'] as $player)
                unset($playersById[$player['PlayerId']]);

            if ($this->AdjustStart($group, $start, $round))
                $changes = true;
        }

        core_UpdateGroups($groups);
        $this->CreateGroupsFor($playersById, $start, $round);

        return $changes || count($playersById);
    }


    /**
     * Creates group for given list of players, start can be either starting time or
     * starting hole depending on $round->starttype
    */
    function CreateGroupsFor($players, &$start, &$round)
    {
        if (!count($players))
            return;

        $GLOBALS['RemovePlayersDefinedforAnySectionRound'] = array($round->id, $this->id);
        $players = array_filter($players, 'RemovePlayersDefinedforAnySection');

        if ($round->IsFirstRound())
            shuffle($players);

        $groupsizes = core_GetGroupSizes(count($players));
        foreach ($groupsizes as $size => $groups) {
            while ($groups--) {
                $group = array('StartingTime' => 0, 'GroupNumber' => 0, 'Section' => $this->id, 'StartingHole' => null, 'People' => array());

                $leftForThis = $size;
                while ($leftForThis--)
                    $group['People'][] = array_shift($players);

                $this->AdjustStart($group, $start, $round);
                $group['People'] = array_reverse($group['People']);
                InsertGroup($group);
            }
        }
    }

    /**
     * Adjust the stating time and/or hole of the given group to match what it's
     * supposed to be
    */
    function AdjustStart(&$group, &$start, &$round)
    {
        global $running_group_number;
        $changes = false;
        if (!$running_group_number)
            $running_group_number = 1;

        if ($group['GroupNumber'] != $running_group_number) {
            $group['GroupNumber'] = $running_group_number;
            $changes = true;
        }
        $running_group_number++;

        switch ($round->starttype) {
            case 'simultaneous':
                if ($group['StartingHole'] != $start) {
                    $group['StartingHole'] = $start;
                    $changes = true;
                }
                $start = $start + 1;
                if ($group['StartingTime'] != $round->starttime) {
                    $group['StartingTime'] = $round->starttime;
                    $changes = true;
                }
                break;

            case 'sequential':
                if ($group['StartingTime'] != $start) {
                    $group['StartingTime'] = $start;
                    $changes = true;
                }
                if ($group['StartingHole'] != null) {
                    $group['StartingHole'] = null;
                    $changes = true;
                }

                $start = $start + $round->interval * 60;
                break;

            default:
                fail();
        }

        if ($changes)
            $group['changed'] = true;

        return $changes;
    }
}


/**
 * Returns the number and size of groups which will be done for the given number of players
 */
function core_GetGroupSizes($people)
{
    $groupsof = array(3 => 0, 4 => 0, 5 => 0);

    switch ($people) {
        case 6:
            $groupsof[3] = 2;
            break;

        case 9:
            $groupsof[4] = 1;
            $groupsof[5] = 1;
            break;

        default:
            if ($people <= 5)
                $groupsof[$people] = 1;
            else {
                $four = floor($people / 4);
                $three = $people % 4 ? 1 : 0;

                while ($four * 4 + $three * 3 != $people) {
                    if ($four * 4 + $three * 3 > $people)
                        $four--;
                    else
                        $three++;
                }
                $groupsof[4] = $four;
                $groupsof[3] = $three;
            }
    }

    return $groupsof;
}

function core_UpdateGroups($groups)
{
    foreach ($groups as $group)
        if (isset($group['changed']))
            UpdateGroup($group);
}
