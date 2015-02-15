<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
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

