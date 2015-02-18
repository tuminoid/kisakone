{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * AddThisEvent widget support for adding 'Add to Calendar'
 * widget to a page. Call SmartifyCalendar to prep.
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
{if $calendar}
{assign var=month value=$calendar.month}
{capture assign=dates}{$calendar.start}{if $calendar.end != $calendar.start} - {$calendar.end}{/if}{/capture}

<a href="{$calendar.url}" title="{$calendar.title}" class="addthisevent">
    <div class="date">
        <span class="mon">{translate id=calendar_month_$month}</span>
        <span class="day">{$calendar.day}</span>
        <div class="bdr1"></div>
        <div class="bdr2"></div>
    </div>
    <div class="desc">
        <p>
            <strong class="hed">{$calendar.title|replace:' ':'&nbsp;'}</strong>
            <span class="des">{translate id=calendar_where}: {$calendar.location|replace:' ':'&nbsp;'}<br />
                {translate id=calendar_when}: {$dates|replace:' ':'&nbsp;'}</span>
        </p>
    </div>
    <span class="_start">{$calendar.start_data}</span>
    <span class="_end">{$calendar.end_data}</span>
    <span class="_zonecode">50</span>
    <span class="_summary">{$calendar.title}</span>
    <span class="_location">{$calendar.location}</span>
    <span class="_organizer">{$calendar.organizer}</span>
    <span class="_all_day_event">true</span>
    <span class="_date_format">DD-MM-YYYY</span>
</a>
{/if}
