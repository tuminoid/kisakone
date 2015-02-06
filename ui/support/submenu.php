<?php
/**
* Suomen Frisbeegolfliitto Kisakone
* Copyright 2009-2010 Kisakone projektiryhmä
* Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
*
* This file serves as the one and only interface users have for the PHP code. In fact,
* whenever mod_rewrite is enabled, access to other php files is explicitly made
* impossible.
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

require_once 'config.php';
require_once 'data/event.php';
require_once 'data/user.php';
require_once 'data/textcontent.php';
require_once 'data/tournament.php';


/**
 * This function defines and returns the submenu tree
 * @return submenu. The structure is fairly complicated, so it is ideal just to look at the implementation.
 */
function page_getSubMenu()
{
    global $settings;

    // Submenu format:
    // The submenu itself is an array which consists of items matching each of the main menu items
    // (irrelevant items can be left out, such as administration items when the user is viewing an event)
    // The keys of these items must match the tokens of the main menu items they stand for -- examples
    // include events, users and administration. These top level items are not displayed on the menu itself,
    // they're merely containers for the actual items. They should be filled in properly however, as the breadcrumb
    // navigation does use them.

    // Each item has the following mandatory fields:
    // - title: string, the text of the menu item as it's supposed to be shown (translated)
    // - link: array, which can be passed to url_smarty in order to generate the link of the menu item
    // - access: who gets to see this item? the actual definitions can be found in the function access in core/user.php, but
    //    here's a summary:
    //       null: everyone
    //       admin
    //       td (for currently shown event, includes admins)
    //       official (for currently shown event; includes td's and admins as they have official access)
    //       officialonly  (for currently shown event; does NOT include tds or admins)
    // - children array containing all subitems of this item. Subitems follow the item format

    // Items may also contain the following optional or special fields:

    // - condition: no effect if present and value evaluates to true; if present and value evaluates to false,
    //   the items is removed from the menu. Do note that the array returned from this function does not have such
    //   items, this field is only used while defining the items. The main purpose of this field is filtering out
    //   unnecessary items
    // - open: if set to true, the menu will be open; that is, its subitems will be shown. For selected item and its parents
    //   this field is set to true automatically, but it can be set manually as well for usability or other reasons.
    //   When set manually the value "auto" should be used, as otherwise breadcrumb bar might end up being confused
    // - selected: if set to true, the menu item will appear to represent the selected page; that is, it will not be clickable.
    //   this field should not be set manually, for the real selected page the field is set automatically

    // Some pages define themselves as being under the main menu item "unique"; this menu is not defined here, it's handled
    // as a special case in the submenu and breadcrumb templates.

    // First, gather any information we'll need for the menu
    $id = @$_GET['id'];

    // Event archive menu is an example of dynamic menu items; created here so that it can be appended to the actual menu later on
    $archivedEvents = array();
    foreach (GetEventYears() as $year) {
        $archivedEvents[] =
            array('title' => translate('submenu_past_events', array('year' => $year)), 'link' => array('page' => 'events', 'id' => $year), 'access' => null, 'children' => array());
    }

    global $user;
    $username = '(not_available)';
    if ($user)
        $username = $user->username;

    if (getmainmenuselection() == "users" && @$_GET['id']) {
        $selectedusername = @$_GET['id'];
        if (is_numeric($selectedusername)) {
            $selecteduser = GetUserDetails($selectedusername);
            if (!$selecteduser) {
                $selecteduser = GetUserDetails(GetUserId($selectedusername));
                if (!$selecteduser)
                    $selectedusername = "?";
            }
            else
                $selectedusername = $selecteduser->firstname . ' ' . $selecteduser->lastname;
        }
    } else {
        $selectedusername = "";
    }

    // The list of events one can manage is only shown if there is anything that can be managed
    $eventManagementAccess = $user && ($user->IsAdmin() || UserIsManagerAnywhere($user->id));

    // Defining the main submenu; note: items utilize access rights combined from it and all its parent items, so
    // as long as there is one item that requires correct rights in the chain, the actual access rights can be left
    // out (and won't have to be checked every single time)
    $submenu = array(


        'events' => array('title' => translate('events'), 'link' => array('page' => 'events'), 'children' => array(
            array('open' => 'auto', 'title' => translate('submenu_all_events'), 'link' => array('page' => 'events', 'id' => ''), 'access' => null, 'children' => array(
                array('title' => translate('submenu_relevant_events'), 'link' => array('page' => 'events', 'id' => 'relevant'), 'access' => null, 'children' => array()),
                array('title' => translate('submenu_upcoming_events'), 'link' => array('page' => 'events', 'id' => 'upcoming'), 'access' => null, 'children' => array()),
                array('title' => translate('submenu_season_past_events'), 'link' => array('page' => 'events', 'id' => 'past'), 'access' => null, 'children' => array()),
                array('title' => translate('submenu_current_year_events'), 'link' => array('page' => 'events', 'id' => 'currentYear'), 'access' => null, 'children' => array()),
                array('title' => translate('submenu_event_archive'), 'link' => array('page' => 'eventarchive'), 'access' => null, 'children' => $archivedEvents),
            )),
            array('open' => 'auto', 'title' => translate('submenu_my_events'), 'link' => array('page' => 'events', 'id' => 'mine'), 'access' => 'login', 'children' => array(
                array('title' => translate('submenu_events_competitor'), 'link' => array('page' => 'events', 'id' => 'mine'), 'access' => null, 'children' => array()),
                array('title' => translate('submenu_events_manage'), 'link' => array('page' => 'events', 'id' => 'manage'), 'access' => $eventManagementAccess, 'children' => array()),

            )),
            array('title' => translate('submenu_new_event'), 'link' => array('page' => 'newevent'), 'access' => 'admin', 'children' => array()),
        )),


        'users' => array('title' => translate('users'), 'link' => array('page' => 'users'), 'children' => array(
            array('title' => translate('submenu_all_users'), 'link' => array('page' => 'users', 'id' => ''), 'access' => null, 'children' => array()),
            array('open' => 'auto', 'title' => $selectedusername, 'link' => array('page' => 'user', 'id' => @$_GET['id']), 'access' => '', 'condition' => @$_GET['id'] && @$_GET['id'] != $username , 'children' => array(
                array('title' => translate('submenu_edit_user'), 'link' => array('page' => 'editmyinfo' , 'id' => @$_GET['id']),  'access' => 'admin', 'children' => array()),
                array('title' => translate('submenu_password'), 'link' => array('page' => 'changepassword', 'id' => @$_GET['id']), 'access' => 'admin', 'children' => array()),
                array('title' => translate('submenu_user_events'), 'link' => array('page' => 'events', 'id' => 'byUser', 'username' => @$_GET['id']), 'access' => null, 'children' => array()),
            )),
            array('open' => 'auto', 'title' => translate('submenu_my_info'), 'link' => array('page' => 'user', 'id' => $username), 'access' => 'login', 'children' => array(
                array('title' => translate('submenu_edit_my_info'), 'link' => array('page' => 'editmyinfo' , 'id' => ''),  'access' => null, 'children' => array()),
                array('title' => translate('submenu_password'), 'link' => array('page' => 'changepassword', 'id' => ''), 'access' => null, 'children' => array()),
                array('title' => translate('submenu_recover_password'), 'link' => array('page' => 'recoverpassword'), 'access' => 'admin', 'condition' => $user == null , 'children' => array()),
                array('title' => translate('submenu_my_user_events'), 'link' => array('page' => 'events', 'id' => 'byUser', 'username' => $username), 'access' => null, 'children' => array()),
            )),
            array('open' => 'auto', 'title' => translate('submenu_manage'), 'link' => array('page' => 'manage_users'), 'access' => 'admin', 'children' => array(
                array('title' => translate('submenu_manage_fees_item'), 'link' => array('page' => 'managefees' ), 'access' => null, 'children' => array(),
                      'condition' => !$settings['SFL_ENABLED']),
                array('title' => translate('submenu_ban_and_remove_users'), 'link' => array('page' => 'manageaccess' ), 'access' => null, 'children' => array()),
                array('title' => translate('submenu_new_admin'), 'link' => array('page' => 'newadmin' ), 'access' => null, 'children' => array()),

                )),
        )),

        'administration' => array('title' => translate('administration'), 'link' => array('page' => 'admin'), 'children' => array(
           array('open' => 'auto', 'title' => translate('submenu_manage_site'), 'link' => array('page' => 'sitemanagement'), 'access' => 'admin', 'children' => array(
            array('title' => translate('submenu_classes'), 'link' => array('page' => 'manageclasses'), 'access' => 'admin', 'children' => array(
                array('title' => translate('editclass'), 'link' => array('page' => 'editclass', 'id' => @$_GET['id']), 'access' => null, 'children' => array(), 'condition' => PageIs('editclass')
            ))),

            array('title' => translate('submenu_levels'), 'link' => array('page' => 'managelevels'), 'access' => 'admin', 'children' => array(
                array('title' => translate('editlevel'), 'link' => array('page' => 'editlevel', 'id' => @$_GET['id']), 'access' => null, 'children' => array(), 'condition' => PageIs('editlevel')
            ))),
            array('title' => translate('submenu_tournaments'), 'link' => array('page' => 'managetournaments'), 'access' => 'admin', 'children' => array(
                array('title' => translate('edittournament'), 'link' => array('page' => 'edittournament', 'id' => @$_GET['id']), 'access' => null, 'children' => array(), 'condition' => PageIs('edittournament')
            ))),
            array('title' => translate('submenu_courses'), 'link' => array('page' => 'managecourses'), 'access' => 'admin', 'children' => array(
                array('title' => translate('editcourse'), 'link' => array('page' => 'editcourse', 'id' => @$_GET['id']), 'access' => null, 'children' => array(), 'condition' => PageIs('editcourse')
            ))),
)),
           array('title' => translate('submenu_manage_content'), 'link' => array('page' => 'sitecontent_main'), 'access' => 'admin', 'children' => array(

                                                                                                                                                    )),
           array('title' => translate('submenu_manage_emails'), 'link' => array('page' => 'manage_email'), 'access' => 'admin', 'children' => array()),
           array('title' => translate('submenu_ads'), 'link' => array('page' => 'ads'), 'access' => 'admin', 'children' => array()),
           array('title' => translate('submenu_new_admin'), 'link' => array('page' => 'newadmin'), 'access' => 'admin', 'children' => array()),
           array('title' => translate('submenu_new_event'), 'link' => array('page' => 'newevent'), 'access' => 'admin', 'children' => array()),
           array('title' => translate('submenu_manage_users'), 'link' => array('page' => 'manage_users'), 'access' => 'admin', 'children' => array()),
        )),



    );

    // Event details part can only be shown if there is a selected event; because of that it's added
    // to the menu conditionally
    if ($id == (int) $id && $id != 0 && getmainmenuselection() == 'events') {
        $eventData = array('title' => pdr_GetEventName($id), 'link' => array('page' => 'event', 'id' => $id), 'access' => null, 'children' => array(
            array('title' => translate('event_info'), 'link' => array('page' => 'event', 'id' => $id, 'view' => ''), 'access' => null, 'children' => array(
                array('title' => translate('event_newsarchive'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'newsarchive'), 'access' => null, 'children' => array()),
            )),
            /*array('title' => translate('event_news'), 'link' => array('page' => 'news', 'id' => $id, 'view' => ''), 'access' => null, 'children' => array()),*/
            array('title' => translate('event_results'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'results'), 'access' => null, 'children' => array(
                            array('title' => translate('event_live_results'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'liveresults'), 'access' => null, 'children' => array()),
                            array('title' => translate('event_leaderboard'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'leaderboard'), 'access' => null, 'children' => array())
            )),
            array('title' => translate('event_competitors'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'competitors'), 'access' => null, 'children' => array(
                array('title' => translate('event_queue'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'queue'), 'access' => null, 'children' => array()),
            )),
            array('title' => translate('event_quotas'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'quotas'), 'access' => null, 'children' => array()),
            array('title' => translate('event_course'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'course'), 'access' => null, 'children' => array()),
            array('title' => translate('event_schedule'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'schedule'), 'access' => null, 'children' => array()),
            array('title' => translate('event_signup_info'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'signupinfo'), 'access' => null, 'children' => array(
                array('title' => translate('event_payment'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'payment'), 'access' => null, 'children' => array()),
                array('title' => translate('event_cancel_signup'), 'link' => array('page' => 'event', 'id' => $id, 'view' => 'cancelsignup'), 'access' => null, 'children' => array(), 'condition' => @$_GET['view'] == 'cancelsignup'),
            )),

        ));

        // It is possible to edit the titles of the event pages and add new custom pages; these
        // changes are taken care of by this call.
        page_customizeEventMenu((int) $id, $eventData);

        $eventData['children'][] = array('title' => translate('event_rss'), 'link' => array('page' => 'eventrss', 'id' => $id, '_url_suffix' => '.rss'), 'access' => null, 'children' => array());

        // Event management links for TDs and admins
        $eventData['children'][] =
            array('title' => translate('edit_event'), 'link' => array('page' => 'manageevent', 'id' => $id), 'access' => 'td', 'children' => array(
                array('title' => translate('edit_event_info'), 'link' => array('page' => 'editevent', 'id' => $id), 'access' => null, 'children' => array()),
                array('title' => translate('edit_news'), 'link' => array('page' => 'editnews', 'id' => $id), 'access' => null, 'children' => array(
                    array('title' => translate('new_news_item'), 'link' => array('page' => 'editeventpage', 'mode' => 'news', 'id' => $id, 'content' => '*'), 'access' => null, 'children' => array()),
                    array('title' => translate('edit_news_item'), 'link' => array('page' => 'editeventpage', 'mode' => 'news', 'id' => $id, 'content' => @$_GET['content']), 'access' => null, 'children' => array(), 'condition' => @$_GET['content']),
                )),
                array('title' => translate('add_offline_competitor'), 'link' => array('page' => 'addcompetitor', 'id' => $id), 'access' => null, 'children' => array()),
                array('title' => translate('edit_event_fees'), 'link' => array('page' => 'eventfees', 'id' => $id), 'access' => null, 'children' => array(
                    array('title' => translate('remind'), 'link' => array('page' => 'remind'), 'access' => null, 'children' => array(), 'condition' => PageIs('remind'))
                )),
                array('title' => translate('edit_event_classes'), 'link' => array('page' => 'eventclasses', 'id' => $id), 'access' => null, 'children' => array()),
                array('title' => translate('edit_event_quotas'), 'link' => array('page' => 'editquotas', 'id' => $id), 'access' => null, 'children' => array()),
                array('title' => translate('edit_event_pages'), 'link' => array('page' => 'editeventpages', 'id' => $id), 'access' => null, 'children' => array(
                    array('title' => translate('event_info'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'index'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_info_schedule'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'index_schedule'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_newsarchive'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'newsarchive'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_results'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'results'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_live_results'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'live_results'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_leaderboard'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'leaderboard'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_competitors'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'competitors'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_course'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'course'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_schedule'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'schedule'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_signup_info'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'signupinfo'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_payment'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'payment'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_cancel_signup'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'content' => 'cancelsignup'), 'access' => null, 'children' => array()),
                    array('title' => translate('event_custom_pages'), 'link' => array('page' => 'editcustomeventpages', 'id' => $id), 'access' => null, 'children' => array(
                        array('title' => translate('edit'), 'link' => array('page' => 'editeventpage', 'id' => $id, 'mode' => 'custom'), 'access' => null, 'children' => array(), 'condition' => @$_GET['mode'] == 'custom'),
                    )),

                )),
                array('title' => translate('edit_ads'), 'link' => array('page' => 'eventads', 'id' => $id), 'access' => null, 'children' => array()),
                array('title' => translate('edit_rounds'), 'link' => array('page' => 'editrounds', 'id' => $id), 'access' => null, 'children' => array(
                    array('title' => translate('manage_rounds'), 'link' => array('page' => 'managerounds', 'id' => $id), 'access' => null, 'children' => array(
                        array('title' => translate('submenu_courses'), 'link' => array('page' => 'managecourses', 'id' => $id), 'access' => null, 'children' => array())
                        )),
                    array('title' => translate('edit_pools'), 'link' => array('page' => 'splitclasses', 'id' => $id), 'access' => null, 'children' => array()),
                    array('title' => translate('class_starting_times'), 'link' => array('page' => 'starttimes', 'id' => $id), 'access' => null, 'children' => array()),
                    array('title' => translate('edit_groups'), 'link' => array('page' => 'editgroups', 'id' => $id), 'access' => null, 'children' => array()),
                )),
                array('title' => translate('enter_results'), 'link' => array('page' => 'enterresults', 'id' => $id), 'access' => null, 'children' => array()),
                array('title' => translate('results_csv'), 'link' => array( 'page' => 'event', 'id'=>$id, 'view' => 'leaderboard_csv'), 'access' => null, 'children' => array()),
                array('title' => translate('participants_csv'), 'link' => array( 'page' => 'event', 'id'=>$id, 'view' => 'participant_csv'), 'access' => null, 'children' => array()),
            ));

            // Event management links for officials
        $eventData['children'][] =    array('title' => translate('edit_event'), 'link' => array('page' => 'manageevent_official', 'id' => $id), 'access' => 'officialonly', 'children' => array(
                array('title' => translate('edit_news'), 'link' => array('page' => 'editnews', 'id' => $id), 'access' => null, 'children' => array(
                    array('title' => translate('new_news_item'), 'link' => array('page' => 'editnewsitem', 'id' => $id, 'news' => ''), 'access' => null, 'children' => array()),
                    array('title' => translate('edit_news_item'), 'link' => array('page' => 'editnewsitem', 'id' => $id, 'news' => @$_GET['news']), 'access' => null, 'children' => array(), 'condition' => @$_GET['news']),
                )),
                array('title' => translate('enter_results'), 'link' => array('page' => 'enterresults', 'id' => $id), 'access' => null, 'children' => array()),
            ));

        array_unshift($submenu['events']['children'], $eventData);

    }

    // Special case of dynamic behavior: username appears in the submenu when the user wants to view
    // the events a specific user has attented
    if (getmainmenuselection() == 'events' && @$_GET['id'] == 'byUser') {
        $userEvents = array(
            'title' => translate('user_events', array('username' => @$_GET['username'])), 'link' => array('page' => 'events', 'id' => 'byUser', 'username' => @$_GET['username']), 'access' => null, 'children' => array()
        );
        array_unshift($submenu['events']['children'], $userEvents);
    }

    if (getmainmenuselection() == 'tournaments') {
            // Not unlike event archive, tournaments have a dynamic year-based submenu as well
            $tyear = @$_GET['id'];
            if (!$tyear) $tyear = date('Y');

            $submenu['tournaments'] = array('title' => translate('tournaments'), 'link' => array('page' => 'tournaments'), 'children' => array());
            if (@$_GET['page'] == 'tournament' || @$_GET['page'][0] == 'tournament') {
                $t = GetTournamentDetails(@$_GET['id']);
                $tname = $t->name;
                $submenu['tournaments']['children'][] = array('title' => $tname, 'link' => array('page' => 'tournament', 'id' => @$_GET['id']), 'children' => array());
            }

            foreach (GetTournamentYears() as $year) {
                $submenu['tournaments']['children'][] = array('title' => $year, 'link' => array('page' => 'tournaments', 'id' => $year), 'children' => array());
            }

        }

    // Open the branch which contains the currently selected page
    foreach ($submenu as $index => $ignore) {
        page_openSubmenuBranchs($submenu[$index]);
    }

    return $submenu;
}

/**
 * Opens branches of the submenu according to the page selection. Called recursively.
 * @param $submenu array Submenu item to process
 * @return boolean true if the item itself or one of its subitems is selected
 */
function page_openSubmenuBranchs(&$submenu)
{
    $containsSelection  = false;

    // See if any of the contained items is selected
    foreach ($submenu['children'] as $index => $ignoreAsNoReference) {

        // Filter out all entries that are to be hidden
       if (array_key_exists('condition', $submenu['children'][$index])) {
            if (!$submenu['children'][$index]['condition']) {
                unset($submenu['children'][$index]);
                continue;
            }
       }
       $childContainsSelection = page_openSubmenuBranchs($submenu['children'][$index]);
       if ($childContainsSelection !== false) $containsSelection = $childContainsSelection;

    }

    // Set default values if the user hasn't overridden them
    if (!array_key_exists('open', $submenu)) $submenu['open'] = false;
    if (!array_key_exists('selected', $submenu)) $submenu['selected'] = false;
    if (!array_key_exists('condition', $submenu)) $submenu['condition'] = true;

    if (page_selected($submenu['link'])) {
        // This page was selected

        $submenu['open'] = $submenu['open'] || count($submenu['children']) > 0; // Only consider this one to be open if there's something inside (or if forced open)
        $submenu['selected'] = true;
    } else {
        // Not selected, open the menu item if the selected item is found inside though
        if ($containsSelection !== false) $submenu['open'] = true;

    }

    //
    //return $submenu['open'] || $submenu['selected'];
    return $containsSelection || $submenu['selected'];
}

/**
 * Returns true if the page matching the link (as defined in submenu) is the current page
 */
function page_selected($link)
{
    foreach ($link as $parameter => $value) {
        $getValue = @$_GET[$parameter];
        if (is_array($getValue)) $getValue = implode('/', $getValue);
        if ($getValue != $value) return false;
    }

    return true;
}

/**
 * Simple wrapper to return event name based on its id
 */
function pdr_GetEventName($evid)
{
    $event = GetEventDetails($evid);
    if (!$event || is_a($event, 'Error')) return '';
    else return $event->name;
}

/**
 * Customizes the submenu for an event based on entered custom pages and modified titles
 */
function page_customizeEventMenu($eventid, &$menu)
{
    $data = GetAllTextContent($eventid);
    foreach ($data as $row) {
        // Ignoring pages set up to use default title
        if (!$row->title) continue;

        if ($row->type == 'custom') {
            // Custom page; add it
            $menu['children'][] = array(
                'title' => $row->title,
                'link' => array('page' => 'event', 'id' => $eventid, 'view' => $row->id),
                'access' => null,
                'children' => array()
                );
        } else {
            // For the purpose of links, index page is page with no view defined
            if ($row->type == 'index') $row->type = '';

            // Try to find the item matching the page and change its title
            foreach ($menu['children'] as $key => $item) {
                if ($item['link']['view'] == $row->type) {
                    $menu['children'][$key]['title'] = $row->title;
                }
            }
        }
    }
}

// Returns the deepest selected menu item from the provided submenu
function page_GetSelectedMenuItem($menu)
{
    $mm = GetMainMenuSelection();
    $from = $menu[$mm];

    return page_GetSelectedMenuItem2($from);

}

// Returns the deepest selected menu item from the provided submenu item recursively
function page_GetSelectedMenuItem2($from)
{
    if ($from['selected']) {
        // This item is selected; if one of its children is selected then that children is deeper
        // and must be considered, otherwise this is the item

        foreach ($from['children'] as $child) {
            if ($child['selected']) {
                return page_GetSelectedMenuItem2($child);
            }
        }

        return $from;
    } elseif ($from['open']) {
        // Not selected but open, one of the children might be selected
        foreach ($from['children'] as $child) {
            if ($child['open'] || $child['selected']) {
                $found = page_GetSelectedMenuItem2($child);
                if  ($found) return $found;
            }
        }
    }

    return null;

}
