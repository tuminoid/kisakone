<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file contains the Tournament class.
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

require_once 'data/tournament.php';



class Tournament
{
    var $id;
    var $level;
    var $name;
    var $scoreCalculationMethod;
    var $available;
    var $year;
    var $description;

    function Tournament($id = 0, $level = null, $name = null, $year = null, $scoreCalculationMethod = null, $available, $description = '')
    {
      $this->id = $id;
      $this->level = $level;
      $this->name = $name;
      $this->scoreCalculationMethod = $scoreCalculationMethod;
      $this->available = $available;
      $this->year = $year;
      $this->description = $description;
    }

    /**
     * Returns the number of participants in this tournament
    */
    function GetNumParticipants()
    {
        return GetTournamentParticipantCount($this->id);
    }

    /**
     * Returns number of held events in the tournament
    */
    function GetEventsHeld()
    {
        $e = $this->GetEvents();
        $count = 0;
        foreach ($e as $event) {

            if ($event->resultsLocked) $count++;
        }

        return $count;
    }

    /**
     * Returns total number of events in this tournament
    */
    function GetNumEvents()
    {
        $e = $this->GetEvents();

        return count($e);
    }

    /**
     * Returns the level of this tournament
     */
    function GetLevel()
    {
        return GetLevelDetails($this->level);
    }

    /**
     * Returns the score calculation used in this tournament
    */
    function GetScoreCalculation()
    {
        require_once 'core/scorecalculation.php';

        return GetScoreCalculationMethod('tournament', $this->scoreCalculationMethod);
    }

    /**
     * Returns all the events in this tournament.
    */
    function GetEvents()
    {
        return GetTournamentEvents($this->id);
    }

    /**
     * Returns all the results of this tournament.
    */
    function GetResults()
    {
        return GetTournamentResults($this->id);
    }

    function GetResultsByClass()
    {
        $results = $this->GetResults();
        if (is_a($results,' Error'))
            return $results;

        $out = array();
        foreach ($results as $result) {
            $class = $result['ClassName'];
            if (!isset($out[$class]))
                $out[$class] = array();
            $out[$class][] = $result;
        }
        uasort($out, 'core_sort_by_count');

        return $out;
    }
}

/**
 * Updates the tournament scores and standings of the given tournament
 */
function UpdateTournamentPoints($tournamentId)
{
    $tournament = GetTournamentDetails($tournamentId);
    if (!$tournament)
        return;

    $sc = $tournament->GetScoreCalculation();
    $sc->UpdateTournamentPoints($tournamentId, $tournament);
}
