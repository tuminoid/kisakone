<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Event class quotas.
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

require_once 'data/event_queue.php';


/**
 * Processes the login form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $event = GetEventDetails($_GET['id']);

    if ($event->resultsLocked)
        return Error::AccessDenied();

    if (!IsAdmin() && $event->management != 'td')
        return Error::AccessDenied('eventquotas');

    $strategy = @$_POST['strategy'];
    $valid_strategies = GetQueuePromotionStrategies();
    if (!in_array($strategy, $valid_strategies))
        $strategy = 'signup';
    SetQueuePromotionStrategy($_GET['id'], $strategy);

    foreach ($_POST as $key => $value) {
        // Process minimum quota
        if (substr($key, 0, 9) == "minquota_") {
            $qid = substr($key, 9);
            SetEventClassMinQuota($event->id, $qid, $value);
        }
        // Process maximum quota
        elseif (substr($key, 0, 9) == "maxquota_") {
            $qid = substr($key, 9);
            SetEventClassMaxQuota($event->id, $qid, $value);
        }
    }

    // Promote queuers if playerlimit changed
    CheckQueueForPromotions($event->id);

    $dummy = null;
    redirect(url_smarty(array('page' => 'manageevent', 'id' => $event->id), $dummy));
}
