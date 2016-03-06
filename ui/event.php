<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Event main page -- this contains all the other user-visible pages
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

require_once 'data/event_quota.php';
require_once 'data/event_queue.php';
require_once 'sfl/sfl_integration.php';
require_once 'sfl/pdga_integration.php';
require_once 'data/calendar.php';
require_once 'data/configs.php';


/**
 * Initializes the variables and other data necessary for showing the matching template
 * @param Smarty $smarty Reference to the smarty object being initialized
 * @param Error $error If input processor encountered a minor error, it will be present here
 */
function InitializeSmartyVariables(&$smarty, $error)
{
    global $user;

    if (!@$_GET['id'])
        return Error::NotFound('event');

    $event = GetEventDetails($_GET['id']);

    if (!$event)
        return Error::NotFound('event');
    if (is_a($event, 'Error'))
        return $event;

    $smarty->assign('event', $event);
    $smarty->assign('eventid', $event->id);

    $player = $user ? $user->GetPlayer() : null;
    $smarty->assign('user', $user);
    $smarty->assign('player', $player);

    $smarty->assign('pdga_enabled', pdga_enabled());
    $smarty->assign('sfl_enabled', sfl_enabled());
    $smarty->assign('pdgaUrl', $event->getPDGAUrl());
    $smarty->assign('payment_enabled', payment_enabled());

    $textType = '';
    $evp = null;

    if (!isAdmin() && !$event->isTD() && !$event->isActive) {
        $error = new Error();
        $error->isMajor = true;
        $error->title = 'error_event_not_active';
        $error->description = translate('error_event_not_active_description');
        $error->source = 'PDR:Event:InitializeSmartyVariables';

        return $error;
    }

    switch ((string) @$_GET['view']) {
        case '':
            $view = 'index';

            list($ci_html, $ci_js) = page_ObfuscateContactInfo($event->contactInfo);
            $smarty->assign('news', $event->GetNews(0, 5));
            $smarty->assign('contactInfoHTML', $ci_html);
            $smarty->assign('contactInfoJS', $ci_js);
            $smarty->assign('rounds', $event->GetRounds());
            SmartifyCalendar($smarty, $event->id);

            if ($player)
                $smarty->assign('groups', GetUserGroupSummary($event->id, $player->id));

            // The index page has an extra text content area for schedule,
            // must be taken care of manually
            $scheduleText = $event->GetTextContent('index_schedule');
            $index_schedule_content = '';

            if ($scheduleText)
                $index_schedule_content = $scheduleText->formattedText;

            $smarty->assign('index_schedule_text', $index_schedule_content);
            break;

        case 'competitors':
            $view = 'competitors';
            language_include('users');

            // make sure we have lifted valid people
            CheckQueueForPromotions($event->id);

            $participants = $event->GetParticipants(@$_GET['sort'], @$_GET['search']);
            $smarty->assign('participants', $participants);
            break;

        case 'queue':
            $view = 'queue';
            language_include('users');

            // make sure we have lifted valid people off the list
            CheckQueueForPromotions($event->id);

            $queue = $event->GetQueue(); // @$_GET['sort'], @$_GET['search']);
            $smarty->assign('queue', $queue);
            break;

        case 'quotas':
            $view = 'quotas';
            $smarty->assign('playerlimit', $event->playerLimit);
            $smarty->assign('quotas', GetEventQuotas($event->id));
            $smarty->assign('counts', GetEventParticipantCounts($event->id));
            $smarty->assign('queues', GetEventQueueCounts($event->id));
            break;

        case 'schedule':
            $view = 'schedule';
            $rounds = $event->GetRounds();
            $roundId = @$_GET['round'];
            if ($rounds && isset($rounds[$roundId - 1]))
                $smarty->assign('holes', $rounds[$roundId - 1]->GetHoles());
            $smarty->assign('rounds', $rounds);
            $smarty->assign('allow_print', IsAdmin() || $event->management != '');
            break;

        case 'course':
            $view = 'course';
            $smarty->assign('courses', pdr_GetCourses($event));
            break;

        case 'cancelsignup':
            $view = 'cancelsignup';
            $smarty->assign('signupOpen', $event->SignupPossible());
            $smarty->assign('paid', $event->eventFeePaid);
            $smarty->assign('queued', $event->GetPlayerStatus(@$player->id) == 'queued');
            break;

        case 'signupinfo':
            $view = 'signupinfo';
            $status = null;

            if ($user && $player) {
                $status = $event->GetPlayerStatus($player->id);
                $smarty->assign('queued', $status == 'queued');
            }

            if ($status == 'notsigned') {
                $pdga_data = (pdga_enabled() && isset($player) && $player->pdga) ? pdga_getPlayer($player->pdga) : null;
                SmartifyPDGA($smarty, $pdga_data);

                $year = date('Y');
                $data = SFL_getPlayer(@$user->id);
                $smarty->assign('sfl_membership', @$data['membership'][$year]);
                $smarty->assign('sfl_license', @$data['license'][$year]);

                $classes = $event->GetClasses();
                $unsuited_classes = array();
                foreach ($classes as $key => $class) {
                    if ($player && !$player->IsSuitableClass($class, $pdga_data)) {
                        $unsuited_classes[] = $class;
                        unset($classes[$key]);
                    }
                }

                $smarty->assign('classes', $classes);
                $smarty->assign('unsuited', $unsuited_classes);

                if ($user) {
                    if (!$user->LicensesPaidForYear(date('Y', $event->startdate), $event->LicensesRequired()))
                        $smarty->assign('feesMissing', $event->LicensesRequired());
                }
            }

            $smarty->assign('rules', $event->getRules(-1));
            $smarty->assign('ruletypes', GetRuleTypes());
            $smarty->assign('ruleops', GetRuleOps());
            $smarty->assign('ruleactions', GetRuleActions());

            $smarty->assign('signedup', $event->approved !== null);
            $smarty->assign('paid', $event->eventFeePaid);
            $smarty->assign('signupOpen', $event->SignupPossible());

            if ($event->signupStart) {
                $smarty->assign('signupStart', date('d.m.Y H:i', $event->signupStart));
                $smarty->assign('signupEnd', date('d.m.Y H:i', $event->signupEnd));
            }
            break;

        case 'payment':
            $view = 'payment';
            $smarty->assign('classes', $event->GetClasses());
            $smarty->assign('signedup', $event->approved !== null);
            $smarty->assign('paid', $event->eventFeePaid);
            $smarty->assign('signupOpen', $event->SignupPossible());
            $smarty->assign('queued', $event->GetPlayerStatus(@$player->id) == 'queued');
            break;

        case 'newsarchive':
            $view = 'newsarchive';
            $smarty->assign('news', $event->GetNews(0, 9999));
            break;

        case 'results':
        case 'liveresults':
            $view = 'results';
            $rounds = $event->GetRounds();
            $smarty->assign('rounds', $rounds);
            $smarty->assign('classes', $event->GetClasses());

            $roundnum = @$_GET['round'];
            if (!$roundnum)
                $roundnum = 1;

            $roundid = @$rounds[$roundnum - 1]->id;
            $theround = @$rounds[$roundnum - 1];
            if ($theround) {
                $smarty->assign('the_round', $theround);

                $r = $theround->GetFullResults('resultsByClass');
                foreach ($r as $k => $v)
                    $r[$k] = pdr_IncludeStanding($v);

                $smarty->assign('resultsByClass', $r);
                $holes = $theround->GetHoles();
                $smarty->assign('holes', $holes);
                $smarty->assign('out_hole_index', ceil(count($holes) / 2));
                $smarty->assign('live', $_GET['view'] == 'liveresults');
                $smarty->assign('roundid', $roundid);
            }
            break;

        case 'leaderboard':
            $view = 'leaderboard';
            $results_tmp = GetEventResultsWithoutHoles($event->id);
            $results = pdr_GroupByClasses($results_tmp);

            $scoresAssigned = null;
            foreach ($results as $class) {
                foreach ($class as $item) {
                    $scoresAssigned = $item['TournamentPoints'] != 0;
                    break;
                }
                break;
            }

            $smarty->assign('includePoints', $scoresAssigned && $event->tournament);
            $smarty->assign('resultsByClass', $results);
            $rounds = $event->GetRounds();
            $smarty->assign('rounds', $rounds);
            $smarty->assign('numRounds', count($rounds));
            break;

        case 'leaderboard_csv':
            if (!isAdmin() && !$event->isTD())
                return Error::AccessDenied('leaderboard_csv');

            $view = 'leaderboard_csv';
            $results = pdr_GroupByClasses(GetEventResultsWithoutHoles($event->id));
            $scoresAssigned = null;
            foreach ($results as $class) {
                foreach ($class as $item) {
                    $scoresAssigned = $item['TournamentPoints'] != 0;
                    break;
                }
                break;
            }

            $smarty->assign('includePoints', $scoresAssigned && $event->tournament);
            $smarty->assign('resultsByClass', $results);
            $rounds = $event->GetRounds();
            $smarty->assign('numRounds', count($rounds));
            $smarty->assign('rounds', $rounds);
            break;

        case 'participant_csv':
            if (!isAdmin() && !$event->isTD())
                return Error::AccessDenied('participant_csv');

            $view = 'participant_csv';
            $results = pdr_GroupByClasses($event->GetParticipants());
            $smarty->assign('resultsByClass', $results);
            break;

        default:
            // If we have a numeric view we are to show a custom content page
            if (is_numeric(@$_GET['view'])) {
                $evp = $event->GetTextContent(@$_GET['view']);
                $view = 'custom';
            }
            else
                return Error::NotFound('page');
            break;
    }

    // Views can override text contnet type, normally it matches the view
    if (!$textType)
        $textType = $view;

    if (!$evp)
        $evp = $event->GetTextContent($textType);

    if (!$evp || is_a($evp, 'Error')) {
        $evp = new TextContent(array());
        $evp->type = $textType;
    }

    if (!$evp->title)
        $evp->title = translate('pagetitle_' . $textType);

    if (!$evp->content) {
        $evp->content = "<h2>" . htmlentities($evp->title) . "</h2>";
        $evp->FormatText();
    }

    // Event pages have their own ads
    $ad = GetAd($event->id, $view);
    $smarty->assign('ad', $ad ? $ad : GetAd($event->id, 'eventdefault'));

    $smarty->assign('view', 'eventviews/' . $view . '.tpl');
    $smarty->assign('page', $evp);
    $smarty->assign('title', $evp);
    $smarty->assign('textcontent', $evp);
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'events';
}

/**
 * Provides obfuscated version of contact info, suitable for use on a web page
 * with less risk of bots finding it
 */
function page_ObfuscateContactInfo($contactInfo)
{
    return array(page_ObfuscateContactInfo_HTML($contactInfo), page_ObfuscateContactInfo_JS($contactInfo));
}

/**
 * HTML version; reverse order with relative positioning used to
 * restore the order on-screen; the downside is that browsers can't really
 * select the text either.
 */
function page_ObfuscateContactInfo_HTML($ci)
{
    preg_match_all('/(.)/us', $ci, $characters);
    $reversed = array_reverse($characters[0]);
    ob_start();

    $pos = count($reversed) * 0.65;
    foreach ($reversed as $character) {
        echo sprintf('<span style="position: relative; left: %Fem">%s</span>', $pos, $character);
        $pos -= 1.25;
    }

    return ob_get_clean();
}

/**
 * Simple javascript-based string construction
 */
function page_ObfuscateContactInfo_JS($ci)
{
    preg_match_all('/(.)/us', $ci, $characters);
    $characters = $characters[0];
    ob_start();

    foreach ($characters as $character) {
        if ($character == "'")
            $character = "\\'";
        elseif ($character == "\\")
            $character == "\\\\";
        echo "ci.push('$character');\n";
    }

    return ob_get_clean();
}

function pdr_GetCourses($event)
{
    $rounds = $event->GetRounds();
    $courses = array();
    foreach ($rounds as $index => $round) {
        $course = $round->GetCourse();

        if (!$course)
            continue;

        if (is_a($course, 'Error'))
            return $course;
        $cid = $course['id'];
        if (isset($courses[$cid])) {
            $courses[$cid]['Rounds'][] = $index + 1;
            continue;
        }
        else {
            $course['Rounds'] = array($index + 1);
        }
        $course['Holes'] = $round->GetHoles();
        $courses[$course['id']] = $course;
    }


    foreach ($courses as $id => $course) {
        $rounds = $course['Rounds'];
        if (count($rounds) == 1) {
            $courses[$id]['Rounds'] = translate('round_title', array('number' => $rounds[0]));
        }
        else {
            $courses[$id]['Rounds'] = translate('many_round_title', array('rounds' => pdr_nice_implode($rounds)));
        }
    }
    //print_r($courses);
    return $courses;
}

/**
 * Groups results by the classes of the players
 */
function pdr_GroupByClasses($data)
{
    $out = array();
    foreach ($data as $row) {
        // A little hack as we added PDGA participant lists as well
        $class = isset($row['ClassName']) ? $row['ClassName'] : @$row['className']; // FIXME: Neither is necessarily existing
        if (!isset($out[$class]))
            $out[$class] = array();
        $out[$class][] = $row;
    }

    // Shouldn't really call a function internal to core, but it does the exact thing
    // we need here
    uasort($out, 'core_sort_by_count');

    return $out;
}

/**
 * Combines strings "nicely"; that is, commas between all items, except the last 2
 * which have "and" between them
 */
function pdr_nice_implode($text)
{
    $and = translate('and');
    $list = array();
    foreach ($text as $item) {
        $list[] = $item;
        $list[] = ", ";
    }

    if (count($list)) {
        unset($list[count($list) - 1]);
        if (count($list) > 1) {
            $list[count($list) - 2] = " $and ";
        }
    }

    return implode("", $list);
}

/**
 * Adds a standing field to result data
 */
function pdr_IncludeStanding($d)
{
    $out = array();
    $lastResult = - 999;
    $lastStanding = 0;
    $step = 1;

    foreach ($d as $item) {
        $result = $item['CumulativePlusminus'];

        if ($item['DidNotFinish'])
            $result = 999;

        if ($result == $lastResult) {
            $item['Standing'] = $lastStanding;
            ++$step;
        }
        else {
            $lastStanding += $step;
            $step = 1;
            $item['Standing'] = $lastStanding;
            $lastResult = $result;
        }

        $out[] = $item;
    }
    return $out;
}
