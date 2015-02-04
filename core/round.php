<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file contains the Round class.
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

require_once 'data/round.php';
require_once 'data/group.php';
require_once 'data/section.php';

/* *****************************************************************************
 * This class represents a single round in the system.
 */
class Round
{
    var $id;
    var $eventId;
    var $starttype;
    var $starttime;
    // datetime in unixtime format
    var $holes;
    // number of holes on this round
    var $interval;
    var $validresults;
    var $course;
    var $groupsFinished;

    var $roundnumber;

    /** ************************************************************************
     * Class constructor
     */
    function Round($id = null, $eventId = null, $starttype = null, $starttime = "", $interval = 0, $validresults = false, $holes = 0, $course = null, $groupsFinished = null)
    {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->starttime = $starttime;
        $this->starttype = $starttype;
        $this->holes = $holes;
        $this->interval = $interval;
        $this->validresults = $validresults;
        $this->course = $course;
        $this->groupsFinished = $groupsFinished;

        return;
    }

    /**
     * Returns all the holes that belong to the course this round is using
    */
    function GetHoles()
    {
        return GetRoundHoles($this->id);
    }

    /**
     * Returns the number of holes on the course this round is using
     * (convenience function for Smarty)
    */
    function NumHoles()
    {
        if (!$this->holes)
            $this->holes = count($this->GetHoles());

        return $this->holes;
    }

    /**
     * Returns all the results for this round. See GetRoundResults in data_access.php
    */
    // $sortedBy one of 'group', 'position'
    function GetFullResults($sortedBy = 'group')
    {
        return GetRoundResults($this->id, $sortedBy);
    }

    /**
     * Returns true if this is the first round of the event it belongs to. False otherwise.
    */
    function IsFirstRound()
    {
        $event = GetEventDetails($this->eventId);
        $rounds = $event->GetRounds();

        return $rounds[0]->id == $this->id;
    }

    /**
     * Returns the round before this in the event
    */
    function GetPreviousRound()
    {
        $event = GetEventDetails($this->eventId);
        $rounds = $event->GetRounds();
        $last = null;
        foreach ($rounds as $round) {
            if ($round->id == $this->id) {
                return $last;
            }
            $last = $round;
        }

        return null;
    }

    /**
     * Returns true if any groups have been defined for the round
    */
    function GroupsAvailable()
    {
        return AnyGroupsDefined($this->id);
    }

    /**
     * Returns teh course this round is using
    */
    function GetCourse()
    {
        return GetRoundCourse($this->id);
    }

    /**
     * Returns all the groups on this round. See GetRoundGroups in data_access.php
    */
    function GetAllGroups()
    {
        return GetRoundGroups($this->id);
    }

    /**
     * Returns all the group of the currently logged in user
    */
    function GetUserGroup()
    {
        global $user;
        if (!$user) {
            return null;
        }

        $player = $user->GetPlayer();
        if (!$player) {
            return null;
        }

        return GetSingleGroup($this->id, $player->id);
    }

    /**
     * Resets the rounds and then reinitializes all the sections on it
    */
    function RegenerateSections()
    {
        ResetRound($this->id);
        $this->InitializeSections();
    }

    /**
     * Resets the groups on this round and regenerates them
    */
    function RegenerateGroups()
    {
        ResetRound($this->id, 'groups');
        $this->InitializeGroups();
    }

    /**
     * Initializes all the groups for this round.
    */
    function InitializeGroups()
    {
        $changes = false;
        $sections = GetSections($this->id);

        switch ($this->starttype) {
            case 'sequential':
                $start = $this->starttime;
                break;


            case 'simultaneous':
                $start = 1;
                break;


            default:
                fail();
        }

        foreach ($sections as $section) {
            $section->InitializeGroups($this, $start, $changes);
        }

        return $changes;
    }

    /**
     * Initializes all the sections for this round
    */
    function InitializeSections()
    {
        if ($this->IsFirstRound()) {
            return $this->InitializeFirstRound();
        }
        else {
            $lastRound = $this->GetPreviousRound();
            $event = GetEventDetails($this->eventId);
            $classes = $event->GetClasses();

            $changes = false;
            $sections = array();
            $sections_unmapped = GetSections($this->id);
            foreach ($sections_unmapped as $section) {
                $sections[$section->classification] = $section;
            }

            foreach ($classes as $class) {
                if (isset($sections[$class->id])) {
                    continue;
                }

                $id = CreateSection($this->id, $class->id, $class->name);
                if (is_a($id, 'Error')) {
                    die(print_r($id, true));
                }
                $sections[$class->id] = GetSectionDetails($id);
            }

            $assign = array();
            $remove = array();

            $data = GetRoundResults($lastRound->id, 'resultsByClass');
            foreach ($data as $classname => $participants) {
                foreach (array_reverse($participants) as $participant) {
                    $result = $participant['CumulativeTotal'];

                    // If player has score and did not DNF/DNS
                    if ($result != 0 && !$participant['DidNotFinish']) {
                        if (!$this->Participating($participant['PlayerId'])) {
                            $class = $participant['Classification'];
                            $s = $sections[$class];
                            if (!isset($assign[$s->id])) {
                                $assing[$s->id] = array();
                            }

                            $assign[$s->id][] = $participant['PlayerId'];
                            $changes = true;
                        }

                        // Player has DNS/DNF, remove him
                    }
                    else {
                        $class = $participant['Classification'];
                        $s = $sections[$class];
                        if (!isset($remove[$s->id])) {
                            $remove[$s->id] = array();
                        }

                        $remove[$s->id][] = $participant['PlayerId'];
                        $changes = true;
                    }
                }
            }

            if (count($assign)) {
                foreach ($assign as $section => $players) {
                    AssignPlayersToSection($this->id, $section, $players);
                }
            }

            if (count($remove)) {
                foreach ($remove as $section => $players) {
                    RemovePlayersFromRound($this->id, $players);
                }
            }
            return $changes;
        }
    }

    /**
     * Returns true if the provided player is participating on this round
    */
    function Participating($playerid)
    {
        return PlayerOnRound($this->id, $playerid);
    }

    /**
     * First round is special, so it has its own unique initialization. It uses
     * a combination class instead of real classes for players, and random order
    */
    function InitializeFirstRound()
    {
        $sections = GetSections($this->id);
        $changes = false;

        if (!count($sections)) {
            $id = CreateSection($this->id, null, translate('combined_group_name'));
            if (is_a($id, 'Error')) {
                die(print_r($id));
            }
            $classToUse = GetSectionDetails($id);
        }
        else {
            $classToUse = $sections[count($sections) - 1];
        }

        $assign = array();
        $remove = array();

        $event = GetEventDetails($this->eventId);
        foreach ($event->GetParticipants() as $participant) {
            if ($participant['eventFeePaid']) {
                if (!$this->Participating($participant['player']->id)) {
                    $assign[] = $participant['player']->id;
                    $changes = true;
                }
            }
            else {
                $remove[] = $participant['player']->id;
                $changes = true;
            }
        }

        if (count($assign)) {
            AssignPlayersToSection($this->id, $classToUse->id, $assign);
        }

        if (count($remove)) {
            RemovePlayersFromRound($this->id, $remove);
        }

        return $changes;
    }
}
