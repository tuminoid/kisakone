{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Tournament listing page
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
{translate id='tournaments_title' assign='title'}
{include file='include/header.tpl'}

<h2>{translate id='tournaments'} {$year}</h2>

{if $error}
    <p class="error">{$error}</p>

{else}

<table>
    <tr>
        <th>{sortheading id='tournament_name' sortType=alphabetical}</th>

        <th>{sortheading id='tournament_participants' sortType=integer}</th>
        <th>{sortheading id='tournament_events_held' sortType=alphabetical}</th>

    </tr>

   {foreach from=$tournaments item=t}

        <tr>

            <td><a href="{url page="tournament" id=$t->id}">{$t->name|escape}</a> </td>

            <td>{$t->GetNumParticipants()}</td>
            <td>{$t->GetEventsHeld()} / {$t->GetNumEvents()}</td>


        </tr>
    {/foreach}
</table>

<script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
    $($(".SortHeading").get(0)).click();
});

{/literal}


//]]>
</script>
{/if}
{include file='include/footer.tpl'}
