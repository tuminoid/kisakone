<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * General initialization for event editing form
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

require_once 'data/tournament.php';
require_once 'data/level.php';
require_once 'data/class.php';

function page_InitializeEventFormData(&$smarty, $creatingNew)
{
    $tournaments = GetTournaments(null, $creatingNew);
    $tournamentOptions = array();

    foreach ($tournaments as $tournament)
        if ($tournament->available)
            $tournamentOptions[$tournament->id] = $tournament->name;
    $smarty->assign('tournament_options', $tournamentOptions);

    $levelList = GetLevels($creatingNew);
    $levels = array();
    foreach ($levelList as $level)
        if ($level->available)
            $levels[$level->id] = $level->name;
    $smarty->assign('level_options', $levels);

    $classList = GetClasses($creatingNew);
    $classes = array();
    foreach ($classList as $class)
        if ($class->available)
            $classes[$class->id] = $class->name;
    $smarty->assign('class_options', $classes);
}
