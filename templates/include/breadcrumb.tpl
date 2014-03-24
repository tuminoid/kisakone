{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmº
 *
 * Breadcrumb bar
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
 * *}
 {if $from.selected}
         <li>{$from.title|escape}   </li>
        {foreach from=$from.children item=child}
            {if $child.selected}
                <li>/</li>
                {include file='include/breadcrumb.tpl' from=$child}
                {php}break;{/php}
            {/if}
        {/foreach}
    {elseif $from.open && $from.open !== 'auto'}

        <li><a href="{url arguments=$from.link}">{$from.title|escape}</a></li>
        <li> / </li>
        {foreach from=$from.children item=child}
            {if ($child.open && $child.open !== 'auto')  || $child.selected}
                {include file='include/breadcrumb.tpl' from=$child}
                {php}break;{/php}
            {/if}
        {/foreach}
    {/if}
