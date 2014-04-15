{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Means for relaying autocomplete data to the UI. Format is JSON.
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
    query:"{$query}",
    suggestions:[
        {foreach from=$suggestions item=suggestion name=suggestions}
            {if !$smarty.foreach.suggestions.first}, {/if}
            "{$suggestion|escape:'html'}"
        {/foreach}
    ]
    {if $data}
    ,
    data:[
        {foreach from=$data item=item name=data}
            {if !$smarty.foreach.data.first}, {/if}
            "{$item|escape:'javascript'}"
        {/foreach}
    ]
    {/if}
{rdelim}