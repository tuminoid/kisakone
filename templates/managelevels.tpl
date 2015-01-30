{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Level management listing
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
{translate assign=title id=managelevels_title}
{include file='include/header.tpl' title=$title}

<p><a href="{url page=editlevel id=new}">{translate id=new_level}</a></p>

<table class="oddrows narrow">
    <tr>
        <th>{translate id=name}</th>
        <th>{translate id=scorecalculation}</th>
        <th>{translate id=available}</th>

        <th>{translate id=edit}</th>
    </tr>
{foreach from=$classes item=class}
    <tr>
        <td>{$class->name|escape}</td>
        <td>{$class->getScoreCalculationName()}</td>
        <td>
            {if $class->available}
                {translate id=yes_}
            {else}
                {translate id=no_}
            {/if}
        </td>
        <td>
            <a href="{url page=editlevel id=$class->id}">{translate id=edit}</a>
        </td>

    </tr>
{/foreach}
</table>

<p><a href="{url page=editlevel id=new}">{translate id=new_level}</a></p>

{include file='include/footer.tpl' noad=1}
