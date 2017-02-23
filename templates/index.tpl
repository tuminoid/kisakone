{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2017 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Index page
 * Note: This page uses "events" as the backend, instead of index
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
 {include file='include/header.tpl'}

{$content}

{if $error}
    <p class="error">{$error}</p>

{else}
<table>

    {foreach from=$lists key=listtype item=events}
    <tr><td colspan="7"><h2>
    {if $listtype == 0}
        {translate id=relevant_events}
        {assign var=trclass value="hot_event_row"}
    {elseif $listtype == 1}
        {translate id=registering_events}
        {assign var=trclass value="event_row"}
    {elseif $listtype == 2}
        {translate id=registering_soon_events}
        {assign var=trclass value="event_row"}
    {elseif $listtype == 3}
        {translate id=upcoming_events}
        {assign var=trclass value="event_row"}
    {elseif $listtype == 4}
        {translate id=past_events}
        {assign var=trclass value="event_row"}
    {/if}
    </h2></td></tr>

    <tr>
        <th>{translate id='event_name' }</th>
        <th>{translate id='event_location'}</th>
        <th>{translate id='event_level'}</th>
        <th class="classes_max_width">{translate id='event_classes'}</th>
        <th>
        {if $listtype == 1}
            {translate id='event_signup_end'}
        {elseif $listtype == 2}
            {translate id='event_signup_start'}
        {else}
            {translate id='event_date'}
        {/if}
        </th>
        <th></th>
        <th></th>
    </tr>
   {foreach from=$events item=event}
        {if $listtype == 1 || $listtype == 2}
            {if !$event->isActive}
                {php}continue;{/php}
            {/if}
        {/if}
        <tr class="{$trclass}">
            {if $event->isAccessible()}
            <td><a href="{url page="event" id=$event->id}">{$event->name|escape}</a> </td>
            {else}
            <td>{$event->name|escape}</td>
            {/if}
            <td>{$event->venue|escape}</td>
            <td>{$event->levelName|escape}</td>
            <td class="classes_max_width">
            {counter assign=nonsuitable start=0}
            {assign var=onesuitable value=""}
            {assign var=term value="classes"}

            {foreach from=$event->GetClasses() item=class}
                {if $player}
                    {assign var=style value="font-weight: bold;"}
                    {if $listtype == 1}
                        {assign var=q value=$event->getQueueCounts()}
                        {assign var=c value=$class->id}
                        {if $q[$c]}
                            {assign var=style value="color: Red; font-style: italic;"}
                        {/if}
                    {/if}
                    {assign var=suitable value=$player->IsSuitableClass($class, $pdga_data, $event->GetProsPlayingAm())}

                    {if !$suitable}
                        {assign var=style value="color: #ddd; display: none;"}
                        {counter}
                    {else}
                        {assign var=onesuitable value="+"}
                        {assign var=term value=other}
                    {/if}
                {/if}

                <span style="{$style}" class="event{$event->id}classes">
                {if $class->short}{$class->short|escape}{else}{$class->name|substr:0:3|escape}{/if}
                </span>
            {foreachelse}
                -
            {/foreach}
            {if $nonsuitable > 0}
                <span style="color: #ddd" class="event{$event->id}hidden"
                    onclick="$('.event{$event->id}classes').show(); $('.event{$event->id}hidden').hide();">
                    {$onesuitable} {$nonsuitable} {translate id=$term}
                </span>
            {/if}
            </td>
            <td>
            {if $listtype == 1}
                {$event->signupEnd|date_format:"%d.%m.%Y %H:%M"}
            {elseif $listtype == 2}
                {$event->signupStart|date_format:"%d.%m.%Y %H:%M"}
            {else}
                {$event->fulldate}
            {/if}
            </td>

            <td class="event_links">
            {if $event->resultsLocked}
                <span class="nowrap"><img src="{$url_base}images/trophyIcon.png" alt="{translate id=results_available}" title="{translate id=results_available}"/>
                <a href="{url page='event' view=leaderboard id=$event->id}">{translate id=event_results}</a></span>

                {if $event->standing != null}
                    {translate id=your_standing standing=$event->standing}
                {/if}
            {elseif $event->approved !== null}
                {* There is a participation record  *}
                {if $event->paymentEnabled}
                    {if $event->eventFeePaid}
                        <span class="nowrap"><img src="{$url_base}images/thumb_up_green.png" width="15" title="{translate id=fee_paid}" alt="{translate id=fee_paid}" />
                        <a href="{url page='event' view=cancelsignup id=$event->id}">{translate id=paid}</a></span>
                    {else}
                        <span class="nowrap"><img src="{$url_base}images/exclamation.png" width="15" title="{translate id=fee_not_paid}" alt="{translate id=fee_not_paid}" />
                        <a href="{url page=event view=payment id=$event->id}">{translate id=fee_payment_info}</a></span>
                    {/if}
                {else}
                    <span class="nowrap"><img src="{$url_base}images/infoIcon.png" width="15" title="{translate id=registration_ok}" alt="{translate id=registration_ok}" />
                    <a href="{url page='event' view=cancelsignup id=$event->id}">{translate id=registration_ok}</a></span>
                {/if}
            {/if}

            {if $loggedon}
                {if $event->SignupPossible()}
                    {if $event->approved !== null}
                        {* <a href="{url page='event' view=cancelsignup id=$event->id}">{translate id=event_cancel_signup}</a> *}
                    {elseif $user->role != 'admin' && $user->role != 'manager' && $event->management != 'td'}
                        <span class="nowrap"><img src="{$url_base}images/goIcon.png" alt="{translate id=sign_up_here}" />
                        <a href="{url page='event' view=signupinfo id=$event->id}">{translate id=event_signup}</a></span>
                    {/if}
                {/if}


                {if $event->management == 'td' || $user->role == 'admin'}
                    <a href="{url page='manageevent' id=$event->id}">{translate id=event_manage}</a>
                {/if}
                {if ($event->management != '' || $user->role == 'admin') && $event->EventOngoing()}
                    <a href="{url page='enterresults' id=$event->id}">{translate id=event_enter_results}</a>
                {/if}
                {if $event->management == 'official'}
                    <a href="{url page='editnews' id=$event->id}">{translate id=event_add_news}</a>
                {/if}
            {/if}
            </td>
        </tr>
        {foreachelse}
        <tr><td colspan="7">
            <p>{translate id=no_matching_events}</p>
        </td></tr>
    {/foreach}

    <tr><td colspan="7">
    {if $listtype == 0}
        &nbsp;
    {elseif $listtype == 3}
        <p><a href="{url page=events id=upcoming}">{translate id=show_all}</a></p>
    {elseif $listtype == 4}
        <p><a href="{url page=eventarchive}">{translate id=show_archive}</a></p>
    {/if}
    </td></tr>

    {/foreach}
</table>



{/if}
{include file='include/footer.tpl'}
