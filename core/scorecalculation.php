<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * This file provides means for accessing score calculation units.
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
 * This function provides a list of all score calulation methods of the given type.
 * Type can be either level or tournament.
 */
function GetScoreCalculationMethods($type)
{
    $dirname = "core/${type}Scores";
    $dir = opendir($dirname);
    $out = array();

    if ($dir !== false) {
        while (($file = readdir($dir)) !== false) {
            if ($file[0] == '.') continue;
            require_once($dirname . '/' . $file);
            $basename = basename($file, '.php');
            $classname = sprintf("scorecalc_%s_%s", $type, $basename);
            $obj = new $classname();
            $out[] = $obj;
        }
        closedir($dir);
    }

    return $out;
}

/**
 * This function provides a specific score calculation unit.
 * Type can be either level or tournament.
 */
function GetScoreCalculationMethod($type, $name)
{
    if ($name != basename($name)) return Error::AccessDenied();

    $filename = "core/${type}Scores/$name.php";
    require_once($filename);
    $className = sprintf("scorecalc_%s_%s", $type, $name);

    return new $className();
}
