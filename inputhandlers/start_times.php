<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Managing section start times
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


function ProcessForm()
{
    if (@$_POST['cancel'])
        redirect("Location: " . url_smarty(array('page' => 'manageevent', 'id' => @$_GET['id']), $_GET));

    $event = GetEventDetails($_GET['id']);
    if ($event->resultsLocked)
        return Error::AccessDenied();
    if (!$event)
        return Error::NotFound('event');
    if (!IsAdmin() && $event->management != 'td')
        return Error::AccessDenied();

    if (!@$_REQUEST['round'] && @$_GET['round'])
        $_REQUEST['round'] = $_GET['round'];

    $round = GetRoundDetails(@$_REQUEST['round']);
    if (!$round || $round->eventId != $event->id)
        return Error::Notfound('round');

    $priority = 1;
    $sections = GetSections($round->id);

    $validIds = array();
    foreach ($sections as $section)
        $validIds[] = $section->id;

    foreach ($_POST as $key => $value) {
        if (preg_match('/time_/', $key)) {
            $present = false;
            $id = substr($key, 5);
            if (!in_array($id, $validIds))
                fail();
            $present = (bool) @$_POST['present_' . $id];

            $roundStart = $round->starttime;
            if (!$value)
                $sectionTime = null;
            else {
                $time1 = strtotime(date('Y-m-d', $roundStart) . ' ' . $value);

                if (!$time1)
                    fail2();
                if ($time1 >= $roundStart)
                    $sectionTime = $time1;
                else {
                    $roundStart += 24 * 60 * 60;
                    $sectionTime = strtotime(date('Y-m-d', $roundStart) . ' ' . $value);
                }
            }

            AdjustSection($id, $priority++, $sectionTime, $present);
        }
    }

    redirect("Location: " . url_smarty(array('page' => 'editgroups', 'id' => @$_GET['id'], 'round' => $round->id), $_GET));
}
