<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm�
 *
 * Group editing
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

function ProcessForm()
{
    if (@$_POST['cancel']) {
        redirect("Location: " . url_smarty(array('page' => 'manageevent', 'id' => @$_GET['id']), $_GET));
    }

    $event = GetEventDetails($_GET['id']);

   if (!$event) return Error::NotFound('event');
   if ($event->resultsLocked) return Error::AccessDenied();

    if (!IsAdmin() && $event->management != 'td') {
        return Error::AccessDenied();
    }
   if (!@$_REQUEST['round'] && @$_GET['round']) $_REQUEST['round'] = $_GET['round'];
   $round = GetRoundDetails(@$_REQUEST['round']);
   if (!$round || $round->eventId != $event->id) return Error::Notfound('round');

   ResetRound($round->id, 'groups');

   $groupTemplate = null;

   foreach ($_POST['e'] as $action) {
        switch ($action[0]) {
            case 's':
                $section = GetSectionDetails(substr($action, 3));
                if ($section->round != $round->id) fail();
                break;
            case 'h':
                $startingHole = substr($action, 1);
                break;
            case 'g':
                $groupTemplate = InitNewGroup($round, $section, $groupTemplate, $startingHole);
                break;
            case 'p':
                $groupTemplate['Player'] = substr($action, 3);
                InsertGroupmember($groupTemplate);
                break;
            case 'e':
                assert($action == "edit_groups");
                break;
            default:
                fail();

        }
   }

   SetRoundGroupsDone($round->id, (bool) @$_POST['done']);

   redirect("Location: " . url_smarty(array('page' => 'manageevent', 'id' => @$_GET['id']), $_GET));
}

function InitNewGroup($round, $section, $template, $startingHole)
{
        if (!$template) {
            $template = array(
                'PoolNumber' => 0,
                'StartingTime' => $round->starttime - $round->interval * 60,
                'StartingHole' => null,
                'Section' => null,
            );
        }

        if ($section->id != $template['Section']) {
            if ($section->startTime) {
                $template['StartingTime'] = $section->startTime - $round->interval * 60;
            }
            $template['Section'] = $section->id;
        }

        switch ($round->starttype) {
            case 'sequential':
                $template['StartingTime'] += 60 * $round->interval;
                break;
            case 'simultaneous':
                $template['StartingHole'] = $startingHole;
                break;
            default:
                fail();

        }
        $template['PoolNumber']++;

        return $template;

   }
