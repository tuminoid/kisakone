<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * URL manipulation functions
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


function serverURL()
{
    global $settings;

    $protocol = empty($_SERVER['HTTPS']) ? "http://" : "https://";
    $host = $_SERVER['HTTP_HOST'];
    $url = "$protocol$host" . (@$settings['USE_MOD_REWRITE'] ? "" : baseUrl());

    return $url;
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
        redirect("Location: " . $url);
    die();
}


// set cookies securely
function set_secure_cookie($name, $value = '', $expires = 0)
{
    setcookie($name, $value, $expires, baseurl(), null, isset($_SERVER['HTTPS']), true);
}


// sanitize url, ie. add missing schema etc
function sanitize_url($url, $schema = "http")
{
    if (!$url || empty($url))
        return $url;

    // All relative links need to be prefixed with schema
    if (substr($url, 0, 1) != "/") {
        $prev_schema = strtolower(substr($url, 0, 4));
        if ($prev_schema != "http")
            $url = $schema . "://" . $url;
    }

    // In php 5.4, htmlentities return empty string if it encounters unknown characters
    // For this, we need to check for empty url, and try recode it with explicit iso
    $url_safe = htmlentities($url);
    if (empty($url_safe))
        $url_safe = htmlentities($url, ENT_COMPAT | ENT_HTML401, "ISO-8859-1");

    if (empty($url_safe)) {
        // error_log("url_safe is empty, returning un-safe url! url = $url");
        return $url;
    }

    return $url_safe;
}
