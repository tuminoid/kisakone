<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2017 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Stores an entered result
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
require_once 'core/event.php';

function ProcessAction()
{
    language_include('events');

    $event = GetEventDetails(@$_GET['id']);
    if (!$event)
        return Error::NotFound('event');
    if ($event->resultsLocked)
        return Error::AccessDenied();

    $value = @$_GET['value'];
    $round = GetRoundDetails(@$_GET['round']);

    if (!$round)
        return Error::NotFound('round');
    if ($round->eventId != $event->id)
        return translate('access_denied');

    $bits = explode('_', substr(@$_GET['field'], 1));
    $playerid = $bits[0];
    $holeid = $specialid = null;

    if ($bits[1] == 'p')
        $specialid = 'Penalty';
    elseif ($bits[1] == 'sd')
        $specialid = 'Sudden Death';
    elseif (is_numeric($bits[1]))
        $holeid = $bits[1];
    else
        error_log("unknown bit: " . print_r($bits, true) . (0 / 0));

    if (!$event->canEnterScores($user, $round->id, $playerid))
        return Error::AccessDenied();

    $result = SaveResult($round->id, $playerid, $holeid, $specialid, $value);
    if (is_a($result, 'Error'))
        return translate('save_failed');

    return $playerid;
}
