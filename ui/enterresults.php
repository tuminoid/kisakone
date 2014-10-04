<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Result entering UI backend
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

/**
 * Initializes the variables and other data necessary for showing the matching template
 * @param Smarty $smarty Reference to the smarty object being initialized
 * @param Error $error If input processor encountered a minor error, it will be present here
 */
function InitializeSmartyVariables(&$smarty, $error)
{
   $event = GetEventDetails($_GET['id']);
   if (!$event) return Error::NotFound('event');
   if ($event->resultsLocked) $smarty->assign('locked' , true);

   $smarty->assign('event', $event);

   $smarty->assign('eventid', $event->id);
   if (!IsAdmin() && $event->management == '') {
        return Error::AccessDenied('enterresults');

   }

   if (!@$_REQUEST['round']) {
      require_once 'ui/support/roundselection.php';

      return page_SelectRound($event, $smarty);
   }
   $round = GetRoundDetails(@$_REQUEST['round']);
   if ($round->eventId != $event->id) return Error::NotFound('round');
   $smarty->assign('holes', $round->GetHoles());
   $results = $round->GetFullResults('group');

   $groupResults = array();

   // Grouping results by the groups of the participants

   $last = null;
   $groupNum = -1;
   foreach ($results as $result) {
      if ($result['GroupNumber'] != $groupNum) {
         if ($groupNum != -1) {
            $groupResults[$groupNum] = $last;
         }
         $groupNum = $result['GroupNumber'];
         $last = array($result);
      } else {
         $last[] = $result;
      }

   }

   if ($last) {
      $groupResults[$groupNum] = $last;
   }

   $smarty->assign('results', $groupResults);
   $smarty->assign('roundid', $round->id);

}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'events';
}
