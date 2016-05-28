{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Event main page
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
 {if $mode == 'body'}
 <div id="event_content">
    {$page->formattedText}
</div>

{if $calendar}
<div style="float: right; width: 400px;">
    {include file='include/calendar.tpl'}
</div>
{/if}

<table class="narrow">
    <tr>
        <td>{translate id=event_name}</td>
        <td>{$event->name|escape}</td>
    </tr>

    {if $event->club}
    <tr>
        <td>{translate id=event_club}</td>
        <td>{$event->GetClubName()|escape}</td>
    </tr>
    {/if}

    <tr>
        <td>{translate id=event_venue}</td>
        <td>{$event->venue|escape}</td>
    </tr>

    <tr>
        <td>{translate id=event_date}</td>
        <td>{$event->fulldate|escape}</td>
    </tr>

    {if $event->level}
    <tr>
        <td>{translate id=event_level}</td>
        <td>{$event->level|escape}</td>
    </tr>
    {/if}

    {if $event->tournament}
    <tr>
        <td>{translate id=event_tournament}</td>
        <td>{$event->tournament|escape}</td>
    </tr>
    {/if}

    <tr>
        <td>{translate id=event_contact}</td>
        <td id="contactInfo"><div style="font-family: monospace">{$contactInfoHTML}</div></td>
    </tr>

    {if $pdgaUrl}
    <tr>
        <td>{translate id=event_pdga_url}</td>
        <td><a href="{$pdgaUrl}">{$pdgaUrl}</a></td>
    </tr>
    {/if}
</table>

<h2>{translate id=schedule}</h2>

{$index_schedule_text}

<table>
   <tr>
    <th>{translate id=round_number number=''}</th>
    <th>{translate id=round_starttime}</th>
    {if $groups}
    <th>{translate id=your_group_is}</th>
    {/if}
    </tr>
    {foreach from=$rounds item=round key=index}
        {assign var=holes value=$round->GetHoles()}
    <tr>
        {math assign=number equation="x+1" x=$index}
        <td>{translate id=round_number number=$number}</td>
        <td>{$round->starttime|date_format:"%d.%m.%Y %H:%M"}</td>

        {assign var=group value=$groups.$index}
        {if $group}
        <td>
        {if $round->groupsFinished !== null}
            {if $round->starttype=='sequential'}
                {capture assign=groupstart}{$group.StartingTime|date_format:"%H:%M"}{/capture}
                {translate id=your_group_starting start=$groupstart}
            {else}
                {assign var=start_hole value=$group.StartingHole}
                {math assign=idx equation="x - 1" x=$group.StartingHole}
                {if $holes[$idx]->holeText}
                    {assign var=start_hole value=$holes[$idx]->holeText}
                {/if}
                {translate id=your_group_starting_hole hole=$start_hole}
            {/if}
        {/if}
   </td>
        {/if}

    </tr>
    {/foreach}

</table>

<p><a href="{url page=event id=$smarty.get.id view=schedule}">{translate id=full_schedule}</a></p>

<h2>{translate id=relevant_news}</h2>

{foreach from=$news item=item}
    {include file='eventviews/newsitem.tpl' item=$item}
{/foreach}

{if count($news)}
    <p><a href="{url page=event id=$smarty.get.id view=newsarchive}">{translate id=news_archive}</a></p>
    {else}
    <p>{translate id=no_news}</p>
{/if}


<script type="text/javascript">
//<![CDATA[
var ci = new Array();
{$contactInfoJS}

{literal}

function getContactInfo() {
    var str = '';


    for (var i = 0; i < ci.length; ++i) {
        str += ci[i];
    }

    return str;
}

$(document).ready(function(){

    $("#contactInfo").empty();
    $("#contactInfo").get(0).appendChild(document.createTextNode(getContactInfo()));
});



{/literal}


//]]>
</script>


{/if}
