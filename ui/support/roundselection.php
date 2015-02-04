<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Round selection listing
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
function page_SelectRound($event, &$smarty)
{
    $rounds = $event->GetRounds();
    $roundOptions = array();

    foreach ($rounds as $round) {
        $roundOptions[$round->id] = translate('round_selection_text', array('number' => $round->roundnumber, 'date' => date('Y-m-d H:i', $round->starttime)));
    }
    $smarty->assign('rounds', $roundOptions);

    global $fullTemplateName;

    $fullTemplateName = "support/roundselection.tpl";
}
