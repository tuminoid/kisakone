<?php
/**
* Suomen Frisbeegolfliitto Kisakone
* Copyright 2009-2010 Kisakone projektiryhmä
* Copyright 2013-2014 Tuomo Tanskanen <tuomo@tanskanen.org>
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

setlocale(LC_ALL, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish'));

// Our configs
require_once 'config.php';
require_once 'config_site.php';

// Some version of PHP 5 complain about lack of time zone data, so if we can
// we'll set it now
// It is also utterly important to PHP timezone to match MySQL timezone,
// otherwise database is filled with non-sensical datestamps
if (is_callable('date_default_timezone_set')) {
    date_default_timezone_set("Europe/Helsinki");
}

require_once './Smarty/libs/Smarty.class.php';
require_once 'core/init_core.php';
require_once 'ui/support/init_pagedatarelay.php';
require_once 'inputhandlers/support/init_input.php';
require_once 'data/init_data.php';

// Suomen Frisbeegolfliitto-specific functionality
require_once 'sfl/sfl_integration.php';

// PDGA API if enabled
if ($settings['PDGA_ENABLED'])
    require_once 'sfl/pdga_integration.php';

// Disabling caching; we have menus and such which can vary depending on user's
// access level, so this is necessary.
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// If we're supposed to be logged in, start the session
if (@$_COOKIE['kisakone_login']) {
    session_start();
    global $user;
    $user = @$_SESSION['user'];
}
else {
    // Not logged in; see if the user enabled automatic login
    if (@$_COOKIE['kisakone_autologin_as']) {

        // Yes; ensure the automatic login token matches the one that can be
        // generated for the user from database, if so, log in, if not ignore;
        // we don't want to display error message for outdated cookies
        $uid = GetUserId($_COOKIE['kisakone_autologin_as']);
        $key = GetAutoLoginToken($uid);
        if ($key == @$_COOKIE['kisakone_autologin_key']) {
            session_start();
            setcookie('kisakone_login', 1);
            global $user;
            $user = GetUserDetails($uid);
            $_SESSION['user'] = $user;
        }
        else {
            // Login failed; no error message, just clear the cookies so that
            // the login doesn't have to be attempted for every page load
            setcookie('kisakone_autologin_key', '');
            setcookie('kisakone_autologin_as', '');
        }
    }
}

// As this is the first PHP file that gets called for any given request, we'll
// do basic initialization here. The most important result from the calls is that
// data sent by the user can be used properly from $_GET, $_POST and $_REQUEST
// afterwards.
gate_StripSlashesIfNecessary();

// These language files are either used globally, or are simply needed for the
// basic layout.
language_include('general');
language_include('mainmenu');
language_include('submenu');
language_include('loginbox');
language_include('pageNameMapping');
language_include('errors');

gate_MapURLParameters();

// Support libraries that do or might rely on data from the user.

require_once 'core/inputmapping.php';

// Process sent form data. The function itself can be found in inputmapping.php
$pageData = gate_ProcessInputData();

// See if an error occured, and if so, determine how to show it
if (is_a($pageData, 'Error')) {
    if ($pageData->isMajor) {
        $_GET['page'] = array('error');
    }
    else {
        if ($pageData->errorPage)
            $_GET['page'] = $pageData->errorPage;
        // else: assume that the page being shown is fine
    }
}

// $pagename represents the subpage that is to be shown.
if (array_key_exists('page', $_GET) && $_GET['page'] && !$_GET['page'][0] == "")
    $pagename = $_GET['page'];
else
    $pagename = array('events');

// Pagename needs to be an array; in some cases (especially after errors) it might
// be a string; in this case the string should be the first and only item in the array,
// we'll fix that here
if (!is_array($pagename))
    $pagename = array($pagename);

// Clean the page name in order to prevent "clever" stuff like "../../etc/passwd.
// Basename removes the path entirely, which in that particular case would leave
// only "passwd", which is fine.
$pagename[0] = basename($pagename[0]);

// Now it's time to show the actual page.

global $fullPageName, $fullTemplateName;
$fullPageName = implode('/', $pagename);
$fullTemplateName = $fullPageName . '.tpl';

// Ensure both the template and the PDR module exist
if (!file_exists("templates/" . $fullTemplateName) || !file_exists("ui/$pagename[0].php")) {
    // Todo: support this

    if (gate_AttemptLanguageDetection($pagename)) {
        gate_ReloadPage();
    }
    $pagename = array('error');
    $fullTemplateName = "error.tpl";
    $pageData = new Error();
    $pageData->title = 'error_filenotfound';
    $pageData->description = translate('error_filenotfound_description');
    $pageData->errorCode = 404;
    $pageData->cause = $_GET['page'];
    $pageData->function = 'Gatekeeper:(automatic)';

}

require_once("ui/$pagename[0].php");

// Although rarely used, pages can have their own language files
language_include($pagename[0]);

// Similarly the selected item in the main menu can include new language data
language_include(GetMainMenuSelection());

if (GetMainMenuSelection() == 'administration')
    language_include('admin');

$smarty = InitializeSmarty();

// Provided by the ui/$pagename.php
$pageData = InitializeSmartyVariables($smarty, $pageData);

foreach ($smarty->get_template_vars() as $var => $value) {
    if (is_a($value, 'Error'))
        $pageData = $value;
}

// Add analytics js if it exists
if (file_exists("js/analytics.js"))
    $smarty->assign('analytics', true);

// The type of the data that is being passed to the browser has to be at some point.
// The type depends on a number of factors:
// - a single page can use a special content type (such as text/xml for RSS feeds)
// - by default application/xhtml+xml is used
// - but IE doesn't understand that so text/html is served for IE
// - pages with user-made HTML content set the global disable_xhtml, which
//   enables HTML mode (as opposed to XHTML)
$isXhtml = false;
if (@$GLOBALS['contentTypeSet']) {
    // already done, do nothing now
    $smarty->assign('contentType', $GLOBALS['contentTypeSet']);
}
elseif (@$GLOBALS['disable_xhtml'] || strpos(@$_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
    header("Content-Type: text/html; charset=utf-8");
    $smarty->assign('contentType', "text/html; charset=utf-8");
}
else {
    header("Content-Type: application/xhtml+xml; charset=utf-8");
    $smarty->assign('contentType', "application/xhtml+xml; charset=utf-8");

    $isXhtml = true;
}

// Choose the ad for the page
$adSuccess = gate_AssignAd($smarty);
if (is_a($adSuccess, 'Error')) {
    $pageData = $adSuccess;
}

// If the page data relay encountered an error, display it instead
// of the normal page.
if (is_a($pageData, 'Error')) {
    $pagename = array('error');
    $fullTemplateName = "error.tpl";
    include_once 'ui/error.php';
    Error_InitializeSmartyVariables($smarty, $pageData);
    $smarty->assign('error', $pageData);
}

// And finally render the page
if ($isXhtml)
    echo '<?xml version="1.0" encoding="UTF-8" ?>';
$smarty->display($fullTemplateName);


/**
* This function maps parameters passed within the URL (when mod_rewrite is used)
* into parameters found in the $_GET and $_REQUEST arrays.
*/
function gate_mapURLParameters()
{
    global $parameterInPath;
    $parameterInPath = array();

    // The entire call path is contained within the $_GET variable path. The
    // processing is only done if it's present.
    if (count($_GET) == 0 || !array_key_exists('path', $_GET)) {
        $_GET['page'] = explode('/', @$_GET['page']);
        return;
    }

    // The paths come in the following format:
    // ./pagename/id/arg1/value1/arg2/value2/.../argn/valuen .
    // None of the elements is mandatory. Pagename defaults to "index" and id
    // defaults to "default".

    if (@$_GET['page'] && !$_GET['path'])
        $_GET['path'] = @$_GET['page'];
    $pathnodes = explode('/', $_GET['path']);

    // How many extra elements have been included in the path
    $offset = 0;

    // Handle the 2 non-named arguments first
    $templatePath = '';

    // Has "page" variable been provided?
    if (count($pathnodes) >= 1) {
        $node = gate_TranslatePathNode($pathnodes[0]);
        $templatePath = "templates/" . $node;
        $_GET['page'] = array($node);
        $_REQUEST['page'] = array($node);

        $parameterInPath['page'] = true;
    }

    // It is also possible to use deeper paths as well for the templates. The PDR
    // unit is chosen as normally, but if there is no matching template, then the
    // directory tree can be traversed until one is found -- this is done here.
    //
    // For example, there's template javascript/base.tpl, but it's served by the
    // PDR module ui/javascript.php

    if ($templatePath != '' && !file_exists($templatePath . ".tpl")) {
        for ($offset = 1; $offset < count($pathnodes); ++$offset) {
            $element = gate_TranslatePathNode($pathnodes[$offset]);

            // Ensure there are no dots in the filename; not only are they unnecessary,
            // doing this prevents directory traversal nicely
            if (strpos($element, '.') !== false)
                break;

            $templatePath .= "/$element";
            $_GET['page'][] = $element;
            $_REQUEST['page'][] = $element;

            if (file_exists($templatePath . ".tpl"))
                break;
        }

        if (!file_exists($templatePath . ".tpl")) {
            $offset = 0;
        }
    }

    // Is there ID on the url?
    if (count($pathnodes) > $offset + 1) {
        $_GET['id'] = $pathnodes[$offset + 1];
        $_REQUEST['id'] = $pathnodes[$offset + 1];
        $parameterInPath['id'] = true;
    }

    // And then the named arguments
    for ($ind = $offset + 2; $ind < count($pathnodes); $ind += 2) {
        if (count($pathnodes) == $ind + 1)
            break;

        $_GET[$pathnodes[$ind]] = $pathnodes[$ind + 1];
        $_REQUEST[$pathnodes[$ind]] = $pathnodes[$ind + 1];
        $parameterInPath[$pathnodes[$ind]] = true;
    }

    // Translate all the variables as necessary
    gate_remapGet();
}

// Choose the ad to be shown on this page; a page data relay unit may
// have set one already, so we won't replace it in that case
function gate_AssignAd(&$smarty)
{
    if ($smarty->get_template_vars('ad'))
        return;
    if (GetMainMenuSelection() == 'administration')
        return;

    global $fullPageName;
    $ad = GetAd(null, $fullPageName);
    if (is_a($ad, 'Error'))
        return $ad;

    if ($ad)
        $smarty->assign('ad', $ad);
    else
        $smarty->assign('ad', GetAd(null, 'default'));
}

// Translates a single entry in a page name
function gate_TranslatePathNode($node)
{
    global $language;
    if (array_key_exists("page:" . $node, $language->data))
        $node = substr(translate("page:" .  $node), 5);
    return $node;
}

// This function translates all the variables sent using GET method
function gate_remapGet()
{
    global $language;

    foreach ($_GET as $param => $value) {
        // Page is translated as it's being read, not done here
        if ($param == 'page')
            continue;

        // Translates both the variable name and value
        if (array_key_exists("param:" . $param, $language->data))
            $param = substr(translate("param:" . $param), 6);;
        if (array_key_exists("$param:" . $value, $language->data))
            $value = substr(translate("$param:" .  $value), strlen($param) + 1);

        $_GET[$param] = $value;
    }
}

/**
* One of the more troublesome PHP settings is "magic quotes gpc", which prepends
* quote characters with backslashes. If the settings is enabled,  this function
* goes through the affected arrays and removes the backslashes.
*/
function gate_stripSlashesIfNecessary()
{
    if (!get_magic_quotes_gpc())
        return;

    // Luckily php doesn't mind having the array values changed while
    // in the foreach loops.
    foreach ($_POST as $k => $v)
        $_POST[$k] = recursive_stripslashes($v);
    foreach ($_GET as $k => $v)
        $_GET[$k] = recursive_stripslashes($v);
    foreach ($_REQUEST as $k => $v)
        $_REQUEST[$k] = recursive_stripslashes($v);
    foreach ($_COOKIE as $k => $v)
        $_COOKIE[$k] = recursive_stripslashes($v);
}

// This is a slightly extented version of stripslashes; if the value is an array,
// it remains an array and all its values are sanitized similarly
function recursive_stripslashes($data)
{
    if (is_array($data)) {
        $out = array();
        foreach ($data as $key => $value) {
            $out[$key] = recursive_stripslashes($value);
        }
        return $out;
    }
    else
        return stripslashes($data);
}

// Simple function which can be used to confirm whether or not the current page
// matches the provided string, for example, PageIs("events")
function PageIs($pageName)
{
    global $fullPageName;
    return $pageName == $fullPageName;
}

// Set the content type for the request; this function should be used instead
// of a simple header() call, as otherwise the type will be replaced later on.
function SetContentType($type)
{
    $GLOBALS['contentTypeSet'] = $type;
    header("Content-Type: " . $type);
}

/**
* Translated links don't work directly when the one using the link is using another
* language by default. To rectify this, all languages are changed for valid page name mapping
* when attempting to access a file that doesn't exist
*/
function gate_AttemptLanguageDetection($pagename)
{
    $dir = opendir('ui/languages');
    if ($dir) {
        $token = "page:" . $pagename[0];

        while (($file = readdir($dir)) !== false) {
            if ($file == 'mapping' || $file{0} == '.')
                continue;
            $l = LoadLanguage($file, true);
            $l->LoadSingleFile('pageNameMapping');

            if (isset($l->data[$token])) {
                $bits = $_GET;
                $bits['action'] = 'set_language';
                $bits['language'] = $l->id;
                $bits['asl_nrd'] = 1;
                unset($bits['path']);
                $bits['page'] = $pagename[0];

                redirect("Location: " . url_smarty($bits, $_GET));
            }
        }

        closedir($dir);
    }
}

// figure out correct baseurl
function baseURL()
{
    $dir = dirname($_SERVER['SCRIPT_NAME']);
    if ($dir == "/")
        return $dir;
    return $dir . '/';
}

// redirects user using Location header
function redirect($url)
{
    if (substr($url, 0, 9) == "Location:")
        header($url);
    else
        redirect("Location: ".$url);
    die();
}
