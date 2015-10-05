<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * PDR module initialization
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

require_once 'translate.php';
require_once 'menu.php';
require_once 'functions.php';

LoadLanguage(page_ChooseLanguage());

/**
 * Determines the language we want to display
 */
function page_ChooseLanguage()
{
    // reset support is only for debug purposes, as it'd be a bit of a pain
    // to force the basic detection otherwise
    if (@$_GET['language'] != 'RESET') {
        if (@$_SESSION['kisakone_language']) {
            return @$_SESSION['kisakone_language'];
        }
        elseif (@$_COOKIE['kisakone_language']) {
            $cookie = basename($_COOKIE['kisakone_language']);
            if (file_exists('ui/languages/' . $cookie))
                return $cookie;
        }
    }

    // Language hasn't been chosen, try to choose the best option
    $lines = file('ui/languages/mapping');
    $options = array();
    foreach ($lines as $line) {
        if (trim($line) == "")
            continue;
        list($key, $value) = explode(":", $line);
        $options[$key] = trim($value);
    }
    $frombrowser = explode(',', @$_SERVER['HTTP_ACCEPT_LANGUAGE']);

    foreach ($frombrowser as $item) {
        preg_match('/([\w-]+)(;q=(\d+(.\d+)))?/', $item, $found);
        $b[] = $found;
    }

    usort($b, 'page_sort_languages');
    $chosen = null;

    foreach ($b as $item) {
        if ($item && $item[1])
            $language = $item[1];

        if (@$options[$language]) {
            $chosen = $options[$language];
            break;
        }
    }
    if (!$chosen)
        $chosen = $options['default'];

    $_SESSION['kisakone_language'] = $chosen;
    set_secure_cookie('kisakone_language', $chosen, time() + 60 * 60 * 24 * 45);
    return $chosen;
}

function page_sort_languages($a, $b)
{
    $qa = @$a[3];
    $qb = @$b[3];
    if (!$qa)
        $qa = 1;
    if (!$qb)
        $qb = 1;

    if ($qa == $qb)
        return 1;
    if ($qa < $qb)
        return 1;
    return - 1;
}

/**
 * Initializes a copy of smarty and returns it. This function is mostly used
 * by index.php, should another page need one, this function shuold be used as well.
 * For example, the error function requires a smarty of its own.
 * @return Smarty Properly initialized smarty object
 */
function InitializeSmarty()
{
    $smarty = new Smarty();
    // Initialize directories used by smarty
    $smarty->template_dir = './templates';
    $smarty->compile_dir = './Smarty/templates_c';
    $smarty->config_dir = './Smarty/configs';

    // Register some globally usable functions
    // Translates text tokens into actual text. Implementation in ui/translate.php
    $smarty->register_function('translate', 'translate_smarty', false);

    // Provides a URL an internal page, taking into account whether or not
    // mod_rewrite is available to be used.
    $smarty->register_function('url', 'url_smarty', false);

    // Error description for form fields
    $smarty->register_function('formerror', 'formerror_smarty', false);

    // Depending on if mod_rewrite is used or not, it might be necessary to add
    // form fields for GET method forms to ensure correct page being loaded
    $smarty->register_function('initializeGetFormFields', 'initializeGetFormFields_Smarty', false);

    $smarty->register_function('submenulinks', 'submenulinks_smarty', true);

    // Heading for sortable tables
    $smarty->register_function('sortheading', 'sortheading_smarty', false);

    // Initialize some variables available to all pages
    $smarty->assign('url_base', BaseUrl());

    // Link to be used within help system
    $smarty->register_function('helplink', 'helplink_smarty', false);

    $user = @$_SESSION['user'];
    $smarty->assign('user', $user);
    if (is_object($user))
        $smarty->assign('admin', $user->role == 'admin');

    // Main menu is defined in the file ui/mainmenu.php
    $smarty->assign('mainmenu', page_InitializeMainMenu());

    // Submenu is defined by the subpage being shown.
    $smarty->assign('submenu', page_GetSubMenu());

    // Main menu selection is also defined by the subpage being shown.
    $smarty->assign('mainmenuselection', GetMainMenuSelection());

    // Assume no errors
    $smarty->assign('errors', array());

    require_once 'core/textcontent.php';
    $tc = GetGlobalTextContent('submenu');
    if ($tc)
        $smarty->assign('submenu_content', $tc->formattedText);

    // Default help file; PDR and templates can change it if necessary
    if (@$_GET['showhelp'] && @$_GET['showhelp'] !== '1') {
        $smarty->assign('helpfile', basename(@$_GET['showhelp']));
    }
    else {
        if (empty($_GET['page'][0])) {
            $smarty->assign('helpfile', 'events');
        }
        else {
            $smarty->assign('helpfile', @$_GET['page'][0]);
        }
    }

    global $language;
    $smarty->assign('language', $language->id);

    return $smarty;
}
