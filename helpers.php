<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
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
 * Displays the user an error message and prevents the requested page from being
 * displayed. This function will call die() before exiting, so it will be the final
 * call of the calling method.
 * 
 * @param string $errormessage Token for the error message. This will go through translation, for display.
 * @param integer $errorcode Typically a HTTP error code should be included for the error. This is the code.
 * @return Never
 */


/**
 * Returns the relative base url for the website (including a trailing slash).
 * Necessary for providing links that work
 * properly when mod_rewrite virtual subdirectoris are being used. For example,
 * if the web site root is http://example.com/kisakone, and called URL is
 * http://www.example.com/kisakone/some/page, /kisakone/ will be returend.
 * @return string
 */
function baseURL() {
    $dir = dirname($_SERVER['SCRIPT_NAME']);
    if ($dir == "/")
        return $dir;
    return $dir . '/';
}





function xhtmlentities($inputString) {
   return htmlspecialchars($inputString);
}


// PHP 5 library function; implemented for PHP 4 as necessary for compatibility.
if (!is_callable('stripos')) {
   function stripos($haystack, $needle){
    return strpos($haystack, stristr( $haystack, $needle ));
   }
}
?>
