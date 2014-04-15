{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Tournament management listing
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
{translate assign=title id=managetournaments_title}
{include file='include/header.tpl' title=$title}

<p><a href="{url page=edittournament id=new}">{translate id=new_tournament}</a></p>

<table class="oddrows narrow">
    <tr>
        <th>{translate id=name}</th>
        <th>{translate id=year}</th>
        <th>{translate id=scorecalculation}</th>

        <th>{translate id=available}</th>
        <th>{translate id=edit}</th>
    </tr>
{foreach from=$tournaments item=tournament}
    <tr>
        <td>{$tournament->name|escape}</td>
        <td>{$tournament->year}</td>
        <td>{assign var=method  value=$tournament->GetScoreCalculation()}

            {$method->name}</td>

        <td>
            {if $tournament->available}
            {translate id=yes!}
            {else}
            {translate id=not}
            {/if}
        </td>
        <td>
            <a href="{url page=edittournament id=$tournament->id}">{translate id=edit}</a>
        </td>

        <td>{$item.date|date_format:"%d.%m.%Y %h:%i%s"}</td>
        <td>{$item.summary|escape}</td>
    </tr>
{/foreach}
</table>

<p><a href="{url page=edittournament id=new}">{translate id=new_tournament}</a></p>

{include file='include/footer.tpl' noad=1}