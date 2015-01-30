{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmº
 *
 * Recursively used single level of submenu
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
 <ul class="submenu submenu{$depth}">
    {foreach from=$items item=item}
        {if access($item.access) && $item.condition }
            <li>
                {if !$item.selected}
                    <a href="{url arguments=$item.link}">
                {/if}

                <span>{$item.title|escape}</span>
                {if !$item.selected}
                    </a>
                {/if}
                {if $item.open}
                    {if count($item.children) != 0}
                        {include file='include/submenulevel.tpl' items=$item.children depth="`$depth+1`"}
                    {/if}
                {/if}
            </li>{else}
        {/if}

    {/foreach}

</ul>&nbsp;
