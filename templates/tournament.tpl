{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Tournament details page
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
{translate id='tournament_title' assign='title'}
{include file='include/header.tpl'}

<h2>{$tournament->name|escape}</h2>
<div>{$tournament->description}</div>

<h2>{translate id=tournament_info}</h2>

<table class="narrow">
    <tr><td>{translate id=tournament_name}</td><td>{$tournament->name|escape}</td></tr>
    <tr><td>{translate id=tournament_year}</td><td>{$tournament->year}</td></tr>
    <tr><td>{translate id=tournament_participants}</td><td>{$tournament->GetNumParticipants()}</td></tr>
    <tr><td>{translate id=tournament_events_held}</td><td>{$tournament->GetEventsHeld()} / {$tournament->GetNumEvents()}</td></tr>
    <tr>
        <td>{translate id=tournament_level}</td>
        <td>{assign var=level value=$tournament->GetLevel()}{$level->name}</td>
    </tr>
    <tr>
        <td>{translate id=tournament_scorecalculation}</td>
        <td>{assign var=scm value=$tournament->GetScoreCalculation()}{$scm->name}</td>
    </tr>
</table>

<h2>{translate id=tournament_events}</h2>
<table>
    {foreach from=$tournament->GetEvents() item=event key=index}
            <tr>
                <td>#{math equation="x+1" x=$index}</td>
            {if $event->isActive}
            <td><a href="{url page="event" id=$event->id}">{$event->name|escape}</a> </td>
            {else}
            <td>{$event->name|escape}</td>
            {/if}
            <td>{$event->venue|escape}</td>
            <td>{$event->fulldate}</td>
            <td>
            {if $event->signupState == 'signedup'}{translate id=fee_not_paid} <a href="{url page=payfees id=$event->id}">{translate id=fee_payment_info}</a>{/if}
            {if $event->signupState == 'accepted'}{translate id=fee_paid}{/if}
            </td>
            <td>
                {if $loggedon}
                    {if $event->management == '' && $event->signupState == 'available'}<a href="{url page='signup' id=$event->id}">{translate id=event_signup}</a>
                        <span class="note">{translate id=signup_by_start} {$event->signupend|date_format:"%d.%m.%Y %h:%i%s"} {translate id=signup_by_end}</span>
                    {/if}

                    {if $event->signupState == 'signedup'}<a href="{url page='cancelsignup' id=$event->id}">{translate id=event_cancel_signup}</a>{/if}
                    {if $event->signupState == 'accepted'}<a href="{url page='cancelsignup' id=$event->id}">{translate id=event_cancel_signup}</a>{/if}

                    {if $event->management == 'td' || $event->management == 'admin'}
                        <a href="{url page='manageevent' id=$event->id}">{translate id=event_manage}</a>
                    {/if}
                    {if $event->management != '' && $event->isOngoing}
                        <a href="{url page='enterresults' id=$event->id}">{translate id=event_enter_results}</a>
                    {/if}
                    {if $event->management == 'official'}
                        <a href="{url page='addnews' id=$event->id}">{translate id=event_add_news}</a>
                    {/if}
                {/if}
            </td>
        </tr>
            {/foreach}
</table>

<h2>{translate id=tournament_participants}</h2>
{if $edit}
<form method="post">
    <input type="hidden" name="formid" value="tournament_tie_breakers" />
    <p>{translate id=edit_tournament_tie_breakers_help}</p>
{/if}

<table>
{foreach from=$tournament->GetResultsByClass() key=classname item=participants}
    <tr>
        <td colspan="5"><h3>{$classname|escape}</h3></td>
    </tr>

    <tr>
        <th rowspan="2">{translate id=tournament_pos}</th>
        <th rowspan="2">{translate id=tournament_part_name}</th>
        <th rowspan="2">{translate id=pdga}</th>
        <th colspan="{$tournament->GetNumEvents()}">{translate id=tournament_event_positions}</th>
        <th rowspan="2">{translate id=tournament_overall}</th>
        {if $edit}
        <th rowspan="2">{translate id=tie_breaker}</th>
        {/if}
    </tr>
    <tr>
        {foreach from=$tournament->GetEvents() item=ignored key=index}
            {math assign=num equation="x+1" x=$index}
            <th>{translate id=tournament_event_score event=$num}</th>
        {/foreach}

    </tr>

    {foreach from=$participants item=part}
    <tr>
        <td>{$part.Standing}</td>
        <td><a href="{url page=user id=$part.Username}">{$part.FirstName|escape} {$part.LastName|escape}</a></td>
        <td>{$part.PDGANumber}</td>
        {foreach from=$tournament->GetEvents() item=event key=index}
            {assign var=eventid value=$event->id}
            {assign var=result value=$part.Results[$eventid]}
            {assign var=score value=$result.Score}
            {if !$score}
                <td>-</td>
            {else}
                <td>{math equation="x / 10" x=$score}</td>
            {/if}
        {/foreach}

        {if is_numeric($part.OverallScore)}
            <td>{math equation="x/10" x=$part.OverallScore}</td>
        {else}
            <td>&nbsp;</td>
        {/if}
        {if $edit}
            <td>
                <input type="text" value="{$part.TieBreaker}" name="tb_{$part.PlayerId}" />
                <input type="hidden" value="{$part.Classification}" name="class_{$part.PlayerId}" />
            </td>
        {/if}
    </tr>
    {/foreach}

{/foreach}
</table>

{if $edit}
<input type="submit" value="{translate id=save}" />
</form>
{elseif $admin}
<p><a href="{url page=tournament id=$smarty.get.id edit=1}">{translate id=edit_tournament_tie_breakers}</a></p>
{/if}

{include file='include/footer.tpl'}
