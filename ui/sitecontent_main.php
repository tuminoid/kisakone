<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Global page listing
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
function InitializeSmartyVariables(&$smarty, $error)
{
    $links = array();
    $links[] = array('title' => translate('submenu_manage_terms'), 'id' => '', 'type' => 'terms');
    $links[] = array('title' => translate('submenu_manage_submenutext'), 'id' => '', 'type' => 'submenu');
    $links[] = array('title' => translate('submenu_manage_index'), 'id' => '', 'type' => 'index');
    //$links[] = array('title' => translate('submenu_manage_fees'), 'id' => '', 'type' => 'fees');

    $smarty->assign('fixed', $links);

    $custom = GetAllTextContent(null);
    $dynamic = array();

    foreach ($custom as $item) {
        if (substr($item->type, 0, 6) != 'custom') continue;

        $dynamic[] = array('title' => $item->title, 'id' => $item->id, 'type' => $item->type);
    }

    $smarty->assign('dynamic', $dynamic);

    if (!IsAdmin()) return Error::AccessDenied();
}

/**
 * Determines which main menu option this page falls under.
 * @return String token of the main menu item text.
 */
function getMainMenuSelection()
{
    return 'administration';
}
