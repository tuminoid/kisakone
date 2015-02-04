<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Tournament overall score calculation: all events included
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
class scorecalc_tournament_full
{
    var $name;
    var $id;

    function scorecalc_tournament_full()
    {
        $this->id = substr(get_class($this), 21);
        $this->name = translate('tournament_scores_all');
    }

    function AssignScores(&$data)
    {
        foreach ($data as $pid => $pdetails) {
            $score = 0;
            $minScore = null;
            foreach ($pdetails['Events'] as $event) {
                if ($event['ResultsLocked'] === null) {
                    $minScore = 0;
                }
                else {
                    $s = (int) $event['TournamentPoints'];
                    $score += $s;
                    if ($minScore === null || $s < $minScore)
                        $minScore = $s;
                }
            }

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

        $this->BreakTop3Ties($data);

        $last_by_class = array();

        foreach ($data as $item) {
            $class = $item['Classification'];
            if (!isset($last_by_class[$class])) {
                $standing = 1;
            }
            else {
                $last = $last_by_class[$class];
                if ($last['OverallScore'] == $item['OverallScore'] && $last['TieBreaker'] == $item['TieBreaker']) {
                    $standing = $last['Standing'];

                    $item['Skipped'] = (int) @$last['Skipped'] + 1;
                }
                else {
                    $standing = $last['Standing'] + (int) @$last['Skipped'] + 1;
                }
            }

            if ($standing != $item['Standing']) {
                $item['changed'] = true;
                $item['Standing'] = $standing;
            }

            $last_by_class[$class] = $item;

            if (@$item['changed']) {
                SaveTournamentStanding($item);
            }
        }
    }

    function BreakTop3Ties(&$data)
    {
        $top3byclass = array();
        $top3 = array();
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
            if (count($top3) == 3) {
                $last = - 1;
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
                $top3[$key]['OTieBreaker'] = $item['TieBreaker'];
            }

            // Do sort them in the proper order
            usort($top3, array($this, 'top3_sort'));

            $last = null;
            foreach ($top3 as $key => $item) {

                if ($last && $this->top3_sort($last, $item) == 0) {
                    $item['TieBreaker'] = $last['TieBreaker'];
                }
                else {

                    $item['TieBreaker'] = $key + 99;
                }

                $data[$item['original_index']] = $item;
                $last = $item;
            }
        }
    }

    function tournament_sort($a, $b)
    {
        $as = $a['OverallScore'];
        $bs = $b['OverallScore'];

        if ($as > $bs)
            return - 1;
        if ($as < $bs)
            return 1;

        if ($a['TieBreaker'] != $b['TieBreaker']) {
            if ($a['TieBreaker'] < $b['TieBreaker'])
                return - 1;
            return 1;
        }

        return 0;
    }

    function top3_sort($a, $b)
    {
        $as = $a['OverallScore'];
        $bs = $b['OverallScore'];

        if ($as > $bs)
            return - 1;
        if ($as < $bs)
            return 1;

        if ($a['OTieBreaker'] != $b['OTieBreaker']) {
            if ($a['OTieBreaker'] < $b['OTieBreaker'])
                return - 1;
            return 1;
        }

        $wa = @$a['Positions'][1];
        $wb = @$b['Positions'][1];

        if ($wa != $wb) {
            if ($wa > $wb)
                return - 1;
            return 1;
        }

        $ap = array_keys($a['Positions']);
        $bp = array_keys($b['Positions']);
        $keys = array_merge($ap, $bp);
        sort($keys);
        foreach ($keys as $key) {
            $av = @$a['Positions'][$key];
            $bv = @$b['Positions'][$key];

            if ($av != $bv) {

                if ($av > $bp)
                    return - 1;
                return 1;
            }
        }

        return 0;
    }

    function GetTournamentPositions($row)
    {
        $positions = array();
        foreach ($row['Events'] as $event) {
            if (!$event['EventStanding'])
                continue;
            $positions[] = $event['EventStanding'];
        }

        return array_count_values($positions);
    }
}
