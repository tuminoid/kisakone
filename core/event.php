<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file contains the Event class, and other functionality for dealing
 * with events. Also see event_management.php.
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

require_once 'data/news.php';
require_once 'data/event_queue.php';
require_once 'data/payments.php';
require_once 'data/level.php';
require_once 'data/round.php';
require_once 'data/rules.php';
require_once 'core/textcontent.php';
require_once 'core/scorecalculation.php';


// Valid Event->signupState attribute values
$event_signupstate_disabled = 'disabled';
$event_signupstate_available = 'available';
$event_signupstate_signedup = 'signedup';
$event_signupstate_accepted = 'accepted';
$event_signupstate_participated = 'participated';

// Valid Event->management attribute values
$event_management_none = '';
$event_management_official = 'official';
$event_management_td = 'td';
$event_management_admin = 'admin';

// Days before and after current date within to include events as relevant
$relevant_events_days_before = 60 * 60 * 24 * 7;
$relevant_events_days_after = 60 * 60 * 24 * 7;

/* *****************************************************************************
 * This class represents a single event in the system.
 */
class Event
{
    var $id;
    var $name;

    // String, from database
    var $date;

    // Unixtime, from/to user
    var $startdate;

    var $venue;
    var $duration;
    var $signupStart;
    var $signupEnd;
    var $signupTimestamp;
    var $playerLimit;

    var $contactInfo;
    var $fulldate;
    var $management;
    var $isOngoing;

    var $activationDate;
    var $isActive;
    var $tournamentId;
    var $tournament;
    var $levelId;
    var $level;
    var $levelName;
    var $resultsLocked;
    var $tdId;

    var $pdgaEventId;

    var $approved;

    /** ************************************************************************
     * Class constructor
     */
    function Event($data_or_id = null, $name = null, $startdate = 0, $venue = null, $duration = 1)
    {
        if (is_array($data_or_id)) {
            $this->initializeFromArray($data_or_id);

            return;
        }
        $id = $data_or_id;

        global $event_signupstate_disabled;
        global $event_management_none;

        $this->id = $id;
        $this->name = $name;

        $this->startdate = $startdate;
        $this->venue = $venue;
        $this->duration = $duration;
        $this->signupStart = 0;
        $this->signupEnd = 0;
        $this->signupState = $event_signupstate_disabled;
        $this->contact = "";
        $this->fulldate = date('d.m.Y', $startdate);
        $this->management = $event_management_none;
        $this->isOngoing = false;
        $this->isActive = false;
        $this->tournamentId = null;
        $this->levelId = null;
        $this->resultslocked = false;
        $this->tdId = null;
        $this->playerLimit = 0;
        $this->pdgaEventId = null;

        if ($duration > 1) {
            $enddate = $startdate + ($duration - 1) * 60 * 60 * 24;
            if (date('m', $startdate) == date('m', $enddate)) {
                $this->fulldate = date('d', $startdate) . '. - ' . date('d.m.Y', $enddate);
            }
            else {
                $this->fulldate = date('d.m.Y', $startdate) . ' - ' . date('d.m.Y', $enddate);
            }
        }

        return;
    }

    function InitializeFromArray($array)
    {
        foreach ($array as $key => $value) {
            $fieldName = core_ProduceFieldName($key);
            $this->$fieldName = $value;
        }
        $this->startdate = $this->date;
        $this->fulldate = date('d.m.Y', $this->date);

        if ($this->duration > 1) {
            $enddate = $this->startdate + ($this->duration - 1) * 60 * 60 * 24;

            if (date('m', $this->startdate) == date('m', $enddate)) {
                $this->fulldate = date('d', $this->startdate) . '. - ' . date('d.m.Y', $enddate);
            }
            else {
                $this->fulldate = date('d.m.Y', $this->startdate) . ' - ' . date('d.m.Y', $enddate);
            }
        }

        $actDate = $this->activationDate;
        $this->isActive = ($actDate !== null && $actDate < time());
    }

    /** ************************************************************************
     * Method for getting all event classes.
     *
     * Returns an array of event classes.
     */
    function GetClasses()
    {
        return GetEventClasses($this->id);
    }

    /** ************************************************************************
     * Method for getting all event rounds.
     *
     * Returns an array of event rounds.
     */
    function GetRounds()
    {
        return GetEventRounds($this->id);
    }

    /** ************************************************************************
     * Method for getting all event officials.
     *
     * Returns an array of event officials.
     */
    function GetOfficials()
    {
        return GetEventOfficials($this->id);
    }

    /** ************************************************************************
     * Method for getting all event news.
     *
     * Returns an array of event news.
     */
    function GetNews($startIndex, $count)
    {
        return GetEventNews($this->id, $startIndex, $count);
    }

    /** ************************************************************************
     * Method for getting all event participants.
     *
     * Returns an array of event participants.
     */
    function GetParticipants($sortedBy = '', $search = '')
    {
        return GetEventParticipants($this->id, $sortedBy, $search);
    }

    /** ************************************************************************
     * Method for getting all event queuers.
     *
     * Returns an array of event queuers.
     */
    function GetQueue($sortedBy = '', $search = '')
    {
        return GetEventQueue($this->id, $sortedBy, $search);
    }

    /** ************************************************************************
     * Method for getting a single player's registration status
     *
     * Returns 'paid' for paid, 'signed' for signed up, not paid, 'queued' for queue, 'notsigned' for not signed
     *   or null for empty playerid
     */
    function GetPlayerStatus($playerId = null)
    {
        if ($playerId == null)
            return $playerId;

        $parts = $this->GetParticipants();
        foreach ($parts as $part) {
            $player = $part['player'];
            if ($player->id == $playerId) {
                if ($part['participationId']) {
                    if ($part['eventFeePaid'])
                        return 'paid';
                    else
                        return 'signed';
                }
            }
        }

        $queue = $this->GetQueue();
        foreach ($queue as $part) {
            $player = $part['player'];
            if ($player->id == $playerId)
                return 'queued';
        }

        return 'notsigned';
    }

    /** ************************************************************************
     * Method for checking if the current user is TD.
     *
     * Returns true if user is TD, otherwise returns false.
     */
    function IsTD()
    {
        return $this->management == 'td';
    }

    /** ************************************************************************
     * Method for getting the event's text content
     *
     * Returns text content or an error
     */
    function GetTextContent($contentId)
    {
        if (is_numeric($contentId)) {
            $content = GetTextContent($contentId);
            if (!$content || $content->event != $this->id) {
                return Error::AccessDenied();
            }
        }
        else {
            $content = GetTextContentByEvent($this->id, $contentId);
        }

        return $content;
    }

    /**
     * Returns true if the event is currently ongoing (or at least if it might be)
    */
    function EventOngoing()
    {
        $enddate = $this->startdate + ($this->duration) * 60 * 60 * 24;
        $retVal = (time() > $this->startdate && time() < $enddate);

        return $retVal;
    }

    /**
     * Returns all the holes that are used on this event
    */
    function GetAllHoles()
    {
        return GetEventHoles($this->id);
    }

    /**
     * Returns all the results from this event. See GetEventResults in data_access.php
    */
    function GetResults()
    {
        return GetEventResults($this->id);
    }

    /**
     * Returns true if it is, at this time, possible to sign up for the event.
     * This is not user-specific information; true is returned even if the user
     * is already signed up.
    */
    function SignupPossible()
    {
        if (!$this->IsAccessible())
            return false;
        if ($this->signupStart === null)
            return false;
        if ($this->signupStart > time())
            return false;
        if ($this->signupEnd != null && $this->signupEnd < time())
            return false;

        return true;
    }

    /**
     * Returns true if the details of this event are viewable by the current user
    */
    function IsAccessible()
    {
        return IsAdmin() || $this->isActive || $this->management == 'td';
    }

    /**
     * Returns true if license and membership fees must be paid before signing up
     * is possible
    */
    function LicensesRequired()
    {
        return EventRequiresLicenses($this->id);
    }

    /**
     * Returns URL to PDGA if EventId is set, null otherwise
    */
    function getPDGAUrl()
    {
        if ($this->pdgaEventId)
            return "http://www.pdga.com/tour/event/" . $this->pdgaEventId;
    }

    function getRules($class = -1)
    {
        return GetEventRules($this->id, $class);
    }
}

/* *****************************************************************************
 * Function for getting the relevant events for the main page
 *
 * Returns an array of relevant events
 */
function GetRelevantEvents()
{
    global $relevant_events_days_before;
    global $relevant_events_days_after;

    $current_time = time();

    return GetEventsByDate($current_time - $relevant_events_days_before, $current_time + $relevant_events_days_after);
}

/* *****************************************************************************
 * Function for creating a new event to the system.
 *
 * Returns an event id for success or
 * an Error object in case there was an error in creating a new event.
 *
 * @param string   $name         - event name
 * @param string   $venue        - event venue's name
 * @param int      $duration     - event duration in days
 * @param int      $playerlimit  - maximum players
 * @param string   $contact      - contact information
 * @param int      $tournament   - tournament id or null
 * @param unixtime $start        - first day of the event
 * @param unixtime $signup_start - signup open date
 * @param unixtime $signup_end   - signup close date
 * @param array    $classes      - array of class ids
 * @param int      $td           - tournament director's user id
 * @param array    $officialIds  - array of official user ids
 * @param array    $rounds       - array of rounds (date, time, holes, datestring, roundid)
 */
function NewEvent($name, $venue, $duration, $playerlimit, $contact, $tournament, $level, $start, $signup_start, $signup_end, $classes, $td, $officialIds, $rounds, $requiredLicenses, $pdgaId)
{
    $retvalue = null;

    $user = GetUserDetails($td);
    if (!is_a($user, 'Error')) {
        if (!empty($user)) {
            foreach ($officialIds as $official) {
                $user = GetUserDetails($official);
                if (!is_a($user, 'Error')) {
                    if (empty($user)) {
                        $retValue = new Error();
                        $retValue->title = "error_invalid_argument";
                        $retValue->description = translate("error_invalid_argument_description");
                        $retValue->internalDescription = "Invalid official user id";
                        $retValue->function = "NewEvent()";
                        $retValue->IsMajor = false;
                        $retValue->data = "Official user id: " . $official;
                        break;
                    }
                }
            }
        }
        else {
            // User details for TD returned null
            $retValue = new Error();
            $retValue->title = "error_invalid_argument";
            $retValue->description = translate("error_invalid_argument_description");
            $retValue->internalDescription = "Invalid TD user id";
            $retValue->function = "NewEvent()";
            $retValue->IsMajor = false;
            $retValue->data = "TD user id: " . $td;
        }
    }
    else {
        // User details for TD returned an Error
        $retValue = $user;
    }

    $venueid = GetVenueId($venue);
    if (is_a($venueid, 'Error')) {
        $retValue = $venueid;
        $venueid = null;
    }

    if (!isset($retValue)) {
        $eventId = CreateEvent($name, $venueid, $duration, $playerlimit, $contact, $tournament, $level, $start, $signup_start, $signup_end, $classes, $td, $officialIds, $requiredLicenses, $pdgaId);
        $retValue = $eventId;
        if (!is_a($eventId, 'Error')) {
            $err = SetRounds($eventId, $rounds);
            if (is_a($err, 'Error')) {
                $retValue = $err;
            }
        }
    }

    return $retValue;
}

/**
 * This function is called to update the results in the Participation field
 * for the given event.
 */
function UpdateEventResults($eventid)
{
    $event = GetEventDetails($eventid);

    $totalHoles = count($event->GetAllHoles());
    $scorecalc = core_EventScoreCalculation($event);
    $results = GetAllRoundResults($eventid);
    $parts = GetAllParticipations($eventid);

    $rounds = $event->GetRounds();
    $classMap = array();
    global $holes;

    // Preload hole information
    $holes = array();
    foreach ($rounds as $round) {
        $h = array();
        foreach ($round->GetHoles() as $hole) {
            $h[$hole->id] = $hole;
        }
        $holes[$round->id] = $h;
    }

    $partsByPlayerC = array();
    global $incompleteRounds;
    $incompleteRounds = array();

    // Map participation records by the player they're for
    foreach ($parts as $part) {
        $part['Rounds'] = array();
        $class = $part['Classification'];
        $classMap[$part['Player']] = $class;

        if (!isset($partsByPlayerC[$class]))
            $partsByPlayerC[$class] = array();

        $partsByPlayerC[$class][$part['Player']] = $part;
    }

    // Combine round results with the overall results of each player
    foreach ($results as $result) {
        $class = @$classMap[$result['Player']];

        if (!isset($partsByPlayerC[$class][$result['Player']])) {
            continue;
        }

        $partsByPlayerC[$class][$result['Player']]['Rounds'][] = $result;

        if ($result['Completed'] != count($holes[$result['Round']])) {
            // Determine which rounds have incomplete results
            // (that is, someone doesn't have result for all holes and is not
            // DNS either)
            $incompleteRounds[$result['Round']] = true;
        }
    }

    foreach ($partsByPlayerC as $partsByPlayer) {

        // Sort the results based on overall score
        usort($partsByPlayer, 'core_sortResults');

        $activePlayers = 0;
        $last = array('OverallResult' => - 1, 'SuddenDeath' => 0);
        // Assign standings to the players
        foreach ($partsByPlayer as $index => $player) {
            $newResult = array('DidNotFinish' => 0);
            $total = 0;
            $isActive = false;

            foreach ($player['Rounds'] as $round) {
                if ($round['DidNotFinish']) {
                    $newResult['DidNotFinish'] = 1;
                    $total = 999;
                    break;
                }
                else {
                    $total += $round['Result'];
                    // Already included in $round['Result'], don't add twice!
                    //$total += $round['Penalty'];
                }
            }
            if ($newResult['DidNotFinish']) {
                // Normally people with the same score share the standing of the first
                // one, but the opposite is true with DNF's
                $newResult['Standing'] = core_GetDnfStanding($partsByPlayer, $index);
            }
            elseif ($total == $last['OverallResult']) {
                $sdnow = core_SuddenDeathUsed($player);
                $sdlast = core_SuddenDeathUsed($last);
                if ($sdnow != $sdlast) {
                    // sudden death has ensured these 2 people are in the right order
                    $newResult['Standing'] = $index + 1;
                }
                else {
                    $newResult['Standing'] = $last['Standing'];
                }
            }
            else {
                $newResult['Standing'] = $index + 1;
            }
            $newResult['OverallResult'] = $total;

            if ($total != 0)
                $activePlayers++;

            $last = core_CombineResultArrays($player, $newResult);
            $partsByPlayer[$index] = $last;
        }

        // Now that we have final standings, we can calculate the tournament scores
        $scorecalc->CalculateScores($partsByPlayer, $totalHoles, $event, $activePlayers);

        // Lastly save any changes that have been made
        foreach ($partsByPlayer as $player) {
            if (isset($player['Changed'])) {
                SaveParticipationResults($player);
            }
        }
    }
}

/**
 * Returns true if sudden death field was used on the last round the player
 * participated in, false otherwise
 */
function core_SuddenDeathUsed($player)
{
    $rounds = $player['Rounds'];
    if (!count($rounds))
        return false;
    $round = $rounds[count($rounds) - 1];

    return $round['SuddenDeath'];
}

/**
 * This function is used for combining an array of data with an array that
 * contains changed data. The combined array is returned.
 */
function core_CombineResultArrays($old, $new)
{
    foreach ($new as $key => $value) {
        if ($old[$key] !== $value) {
            $old[$key] = $value;
            $old['Changed'] = true;
        }
    }

    return $old;
}

/**
 * This function takes care of sorting the results
 */
function core_SortResults($a, $b)
{
    // Note: some of the gathered data is needless due to changes that have
    // taken place
    $a_total = 0;
    $b_total = 0;
    $a_plusminus = 0;
    $b_plusminus = 0;
    $a_completed = 0;
    $b_completed = 0;
    $a_sd = 0;
    $b_sd = 0;
    $a_activeRounds = 0;
    $b_activeRounds = 0;
    $anythingIncomplete = false;

    global $incompleteRounds;

    $a_dnf = false;
    $b_dnf = false;

    // Gather data for each round
    foreach ($a['Rounds'] as $round) {
        $a_total += $round['Result'];
        $a_completed += $round['Completed'];
        $a_sd += $round['SuddenDeath'];

        if ($round['Result'] || $round['DidNotFinish'])
            $a_activeRounds++;
        $a_plusminus += $round['PlusMinus'];

        if (@$incompleteRounds[$round['Round']])
            $anythingIncomplete = true;
        if ($round['DidNotFinish'])
            $a_dnf = true;
    }

    foreach ($b['Rounds'] as $round) {
        $b_total += $round['Result'];
        $b_completed += $round['Completed'];
        $b_sd += $round['SuddenDeath'];

        if ($round['Result'] || $round['DidNotFinish'])
            $b_activeRounds++;
        $b_plusminus += $round['PlusMinus'];

        if (@$incompleteRounds[$round['Round']])
            $anythingIncomplete = true;
        if ($round['DidNotFinish'])
            $b_dnf = true;
    }

    // Of these 2, if one has participated in more rounds than the other, he'll
    // be above the other in the listing
    if ($a_activeRounds != $b_activeRounds) {
        if ($a_activeRounds < $b_activeRounds)
            return 1;
        return - 1;
    }


    if ($a_dnf != $b_dnf) {
        // Same number of rounds, but one did not finish; he'll be below the other
        if ($a_dnf)
            return 1;
        return - 1;
    }

    // We're past special cases now;
    // plusminus is the primary factor for sorting the players
    if ($a_plusminus != $b_plusminus) {
        if ($a_plusminus < $b_plusminus)
            return - 1;
        return 1;
    }

    // Sudden death field, if used, can be used as tie breaker
    if ($a_sd != $b_sd) {
        if (abs($a_sd) < abs($b_sd))
            return - 1;
        return 1;
    }

    // Otherwise we'll have to decide using other means
    return core_TieBreaker($a, $b);
}

function core_TieBreaker($a, $b)
{
    // What do dow when results appear identical?
    // TODO
    return 0;
}

/**
 * This function acts as shortcut for getting the level-based score calculation
 * for an event with only having the event object
 */
function core_EventScoreCalculation($event)
{
    $levelid = $event->levelId;
    $level = GetLevelDetails($levelid);

    return GetScoreCalculationMethod('level', $level->scoreCalculationMethod);
}

/**
 * Determine the standing for a player that did not finish;
 */
function core_GetDnfStanding($participants, $forIndex)
{
    while (array_key_exists($forIndex, $participants)) {
        $p = $participants[$forIndex];
        $dnf = false;
        foreach ($p['Rounds'] as $round)
            if ($round['DidNotFinish'])
                $dnf = true;
        if (!$dnf)
            return $forIndex;

        $forIndex++;
    }

    return $forIndex;
}
