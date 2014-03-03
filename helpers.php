<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Miscellaneous helper functions
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
 * Returns the relative base url for the website (including a trailing slash).
 * Necessary for providing links that work
 * properly when mod_rewrite virtual subdirectoris are being used. For example,
 * if the web site root is http://example.com/kisakone, and called URL is
 * http://www.example.com/kisakone/some/page, /kisakone/ will be returend.
 * @return string
 */
function baseURL()
{
    $dir = dirname($_SERVER['SCRIPT_NAME']);
    if ($dir == "/")
        return $dir;
    return $dir . '/';
}
