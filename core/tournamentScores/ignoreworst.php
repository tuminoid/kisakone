<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Tournament overall score calculation: worst event ignored
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

class scorecalc_tournament_ignoreworst
{
    var $name;
    var $id;
    var $numEvents;

    function scorecalc_tournament_ignoreworst()
    {
        $this->id = substr(get_class($this), 21);
        $this->name = translate('tournament_scores_ignoreworst');
    }

    /**
     * Assings overall tournament scores to the players in data
    */
     function AssignScores(&$data, $numEvents)
     {
        foreach ($data as $pid => $pdetails) {
            $score = 0;
            $minScore = null;
            foreach ($pdetails['Events'] as $event) {
                if (!$event['ResultsLocked']) {
                    continue;
                }
                $s =  (int) $event['TournamentPoints'];
                $score += $s;
                if ($minScore === null || $s < $minScore)
                    $minScore = $s;
            }

            if (count($pdetails['Events']) < $numEvents)
                $minScore = 0;

            $score -= $minScore; // ignore lowest

            if ($pdetails['OverallScore'] != $score) {
                $data[$pid]['OverallScore'] = $score;
                $data[$pid]['changed'] = true;
            }
        }
    }

    function UpdateTournamentPoints($tournamentId, $tournament)
    {
        $data = GetTournamentData($tournamentId);

        $events = $tournament->GetEvents();
        $this->numEvents = count($events);
        $this->AssignScores($data, count($events));
        usort($data, array($this, 'tournament_sort'));

        // Ensure top 3 aren't tied (if possible)
        $this->BreakTop3Ties($data);

        // Assign a standing to everybody
        $previous_player = array();
        $counters = array();
        foreach ($data as $player) {
            $player_class = $player['Classification'];
            $player_score = $player['OverallScore'];
            $player_tiebreak = $player['TieBreaker'];
            if (!$player_class)
                continue;

            if (!isset($previous_player[$player_class])) {
                $player['Standing'] = 1;
                $counters[$player_class] = 1;
            } else {
                $prev_player = $previous_player[$player_class];
                $prev_score = $prev_player['OverallScore'];
                $prev_tiebreak = $prev_player['TieBreaker'];
                $counters[$player_class]++;

                if (($player_score != $prev_score) || ($player_tiebreak != $prev_tiebreak)) {
                    $player['Standing'] = $counters[$player_class];
                } else {
                    $player['Standing'] = $prev_player['Standing'];
                }
            }

            $previous_player[$player_class] = $player;
            SaveTournamentStanding($player);
        }
    }

    function BreakTop3Ties(&$data)
    {
        $top3byclass = array();
        $top3 = array();

        // Get potentials for top 3 positions for each class
        foreach ($data as $id => $item) {
            $top3 = @$top3byclass[$item['Classification']];

            if (!is_array($top3))
                $top3 = array();
            if (count($top3) >= 3) {
                $done = true;
                $last = $top3[count($top3) - 1];
                if ($item['OverallScore'] == $last['OverallScore']) {
                    if ($item['TieBreaker'] == $last['TieBreaker']) {
                        $done = false;
                    }
                }
                if ($done)
                    break;
            }
            $item['original_index'] = $id;
            $top3[] = $item;
            $top3byclass[$item['Classification']] = $top3;
        }

        foreach ($top3byclass as $class => $top3) {
            // If only 3 candidates for top 3, don't bother with anything else
            if (count($top3) == 3) {
                $last = -1;
                $allok = true;
                foreach ($top3 as $item) {
                    if ($item['OverallScore'] == $last)
                        $allok = false;
                    $last = $item['OverallScore'];
                }
                if ($allok)
                    continue;
            }

            foreach ($top3 as $key => $item) {
                $top3[$key]['Positions'] = $this->GetTournamentPositions($item);
                $top3[$key]['OTieBreaker'] = $item['TieBreaker']; // Original tie breaker
            }

            // Sort them in the proper order
            usort($top3, array($this, 'top3_sort'));

            $last = null;
            foreach ($top3 as $key => $item) {
                if ($last && $this->top3_sort($last, $item) == 0) {
                    // Could not determine which one is better, true tie
                    $item['TieBreaker'] = $last['TieBreaker'];
                } else {
                    $item['TieBreaker'] = /*$key*/ $item['TieBreaker'] + 99;
                }

                $data[$item['original_index']] = $item;
                $last = $item;
            }
        }
    }

    // Basic sort for tournaments; overall score, tie breaker or tie
    function tournament_sort($a, $b)
    {
        $as = $a['OverallScore'];
        $bs = $b['OverallScore'];

        if ($as > $bs) return -1;
        if ($as < $bs) return 1;

        if ($a['TieBreaker'] != $b['TieBreaker']) {
            if ($a['TieBreaker'] < $b['TieBreaker'])
                return -1;
            return 1;
        }

        return 0;
    }

    // More advanced sort for top 3 positions
    function top3_sort($a, $b)
    {
        $as = $a['OverallScore'];
        $bs = $b['OverallScore'];

        if ($as > $bs)
            return -1;
        if ($as < $bs)
            return 1;

        if ($a['OTieBreaker'] != $b['OTieBreaker']) {
            if ($a['OTieBreaker'] < $b['OTieBreaker'])
                return -1;
            return 1;
        }

        // Test the number of wins
        $wa = @$a['Positions'][1];
        $wb = @$b['Positions'][1];

        if ($wa != $wb) {
            if ($wa > $wb)
                return -1;
            return 1;
        }

        // Test number of 2nd, 3rd, ... positions
        $ap = array_keys($a['Positions']);
        $bp = array_keys($b['Positions']);
        $keys = array_merge($ap, $bp);
        sort($keys);
        foreach ($keys as $key) {
            $av = @$a['Positions'][$key];
            $bv = @$b['Positions'][$key];

            if ($av != $bv) {
                if ($av > $bv)
                    return -1;
                return 1;
            }
        }
        return 0;
    }

    // Number of positions the player has had;
    // ie. winner once, 2nd three times would be array(1=> 1, 2 => 3);
    function GetTournamentPositions($row)
    {
        $positions = array();
        foreach ($row['Events'] as $event) {
            if (!$event['EventStanding'])
                continue;
            $positions[] = $event['EventStanding'];
        }
        if (count($positions)) {
            sort($positions);
            $last = $positions[count($positions) - 1];
            if ($last != 1)
                unset($positions[count($positions) - 1]);
        }
        return array_count_values($positions);
    }

}
