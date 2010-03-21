<?php
/*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * RSS feed for events
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
function InitializeSmartyVariables(&$smarty, $error) {
    language_include('rss');
    
    
    $event = GetEventDetails(@$_GET['id']);
    
    if (!$event) return Error::NotFound('event');
    
    $smarty->assign('event', $event);
    $items = array();
    
    $items[] = page_EventStartRSS($event);
    
    if ($event->signupStart) {
        $items[] = page_SignupStartItem($event);
        if ($event->signupStart < time()) {
            if ($event->signupEnd) $items[] = page_SignupEndItem($event);
        }
    }
    
    /*
     User-specific items; not supported at this time, only event-specific items
    if ($event->approved !== null) $items[] = page_SignedUp($event);
    if ($event->eventFeePaid !== null) $items[] = page_Paid($eventFeePaid);
   */
    $rounds  = $event->GetRounds();
    foreach($rounds as $ind => $round) {
        if ($round->groupsFinished) {
            $items[] = page_GroupsFinished($ind + 1, $round);
        }
    }
    
    if ($event->resultsLocked) $items[] = page_Locked($event);
    
    $news = $event->GetNews(0, 99999999);
    foreach ($news as $newsitem) {
        $items[] = page_News($event, $newsitem);
    }
    
    $items = array_map('page_fix_rss_fields', $items);
    usort($items, 'page_Rss_Date_Sort');    
    
    
    $smarty->assign('items', $items);
    
    
    
    SetContentType("text/xml; charset=utf-8");
    //SetContentType("text/plain");
}




/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection() {
    
    // No menu is show on this page
    return 'irrelevant';
}

function page_EventStartRSS($event) {
    $date = $event->startdate;
    if (page_isToday($date)) {
        return array('type' => 'event_start_today', 'date' => $date);
    }
    else if ($date < time()) {
        return array('type' => 'event_started', 'date' => $date, 'dataDate' => $date);
    } else if ($date < time() + 7 * 24 * 60 * 60) {
        return array('type' => 'event_starting_1_week', 'date' => $date - 7 * 24 * 60 * 60, 'dataDate' => $date);
    } else {
        return array('type' => 'event_will_start', 'date' => $event->activationDate, 'dataDate' => $date);
    }
}

function page_SignupStartItem($event) {
    $date = $event->signupStart;
    
    if ($date < time()) {
        return array('type' => 'signup_started', 'date' => $date, 'dataDate' => $date, 'template' => 'signup', 'link' => true);
    } else if ($date < time() + 7 * 24 * 60 * 60) {
        return array('type' => 'signup_starting_1_week', 'date' => $date - 7 * 24 * 60 * 60, 'dataDate' => $date, 'template' => 'signup');
    } else {
        return array('type' => 'signup_will_start', 'date' => $event->activationDate, 'dataDate' => $date, 'template' => 'signup');
    }
}

function page_SignupEndItem($event) {
    $date = $event->signupEnd;
    
    if ($date < time()) {
        return array('type' => 'signup_over', 'date' => $date, 'dataDate' => $date, 'template' => 'signupend');
    } else if ($date < time() + 7 * 24 * 60 * 60) {
        return array('type' => 'signup_end_1_week', 'date' => $date - 7 * 24 * 60 * 60, 'dataDate' => $date, 'template' => 'signupend', 'link' => true);
    } else if ($date < time() +  24 * 60 * 60) {
        return array('type' => 'signup_end_1_day', 'date' => $date - 7 * 24 * 60 * 60, 'dataDate' => $date, 'template' => 'signupend', 'link' => true);
    } else {
        return array('type' => 'signup_will_end', 'date' => $event->activationDate, 'dataDate' => $date, 'template' => 'signupend', 'link' => true);
    }
}

function page_News($event, $item) {
    return array('type' => 'news', 'title' => htmlspecialchars($item->title),
                 'content' => htmlspecialchars($item->formattedText), 'date' => $item->date,
                 'newsid' => $item->id);
    
}

function page_fix_rss_fields($item) {
    if ($item === null) return $item;
    
    $item['rssDate'] =  date('D, d M Y H:i:s T', $item['date']);
    if (isset($item['dataDate'])) $item['dataDate'] = date('d.m.Y', $item['dataDate']);
    if (!isset($item['template'])) $item['template'] = $item['type'];
    return $item;
}


function page_isToday($date) {
    $today = strtotime(date('Y-m-d', time()));
    $tomorrow = strtotime(date('Y-m-d', time() + 60 * 60 * 24));
    
    return $date >= $today && $date < $tomorrow;    
                       
}

function page_rss_date_sort($a, $b) {
    if ($a['date'] < $b['date']) return -1;
    if ($a['date'] > $b['date']) return 1;
    return 0;
}


function page_GroupsFinished($index, $round) {
    return array('type' => 'groups', 'roundNum' => $index, 'date' => strtotime($round->groupsFinished));
}

function page_locked($event) {
    return array('type' => 'event_over', 'date' => strtotime($event->resultsLocked), 'dataDate' => strtotime($event->resultsLocked));
}


?>