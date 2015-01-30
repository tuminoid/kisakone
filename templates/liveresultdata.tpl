{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Provides AJAX support for live result updates
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
 * *}{ldelim}
    "status": "{$statusText}",
    "updatedAt": {$updateTime},
    "forceRefresh" : {$forceRefresh},
    "updates" : {ldelim}
    {assign var=first value=true}
        {foreach from=$updates item=update key=ind}
        {if !$first},{/if}
        {assign var=first value=false}
        "{$ind}": {ldelim}
            "pid": {$update.PlayerId},
            "hole": {if $update.HoleId}{$update.HoleId}{elseif $update.Special == 'Penalty'}"p"{else}"sd"{/if},
            "value": {$update.Value},
            "round": {$update.RoundId},
            "holeNum": {$update.HoleNum}
        {rdelim}
        {/foreach}
    {rdelim}
{rdelim}
