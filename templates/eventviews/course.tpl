{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Course info page
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

{foreach from=$courses key=index item=course}

    <h3>{$course.Rounds}: {$course.Name|escape}</h3>
    <div>{$course.Description}</div>
    {if $course.Link}
    <p><a href="{$course.Link}" target="_blank">{translate id=course_details}</a></p>
    {/if}
    {if $course.Map && $course.Map|truncate:4:"" == "http"}
        <img style="float: right" src="{$course.Map}" alt="{translate id=course_map}" />
    {/if}

    <h4>{translate id=holes_title}</h4>
    <table class="narrow" style="text-align: right;">
        <tr>
            <th>{translate id=holeNumber}</th>
            <th>{translate id=holeText}</th>
            <th>{translate id=par}</th>
            <th>{translate id=length}</th>
        </tr>
        {foreach from=$course.Holes item=hole}
        <tr>
            <td>{$hole->holeNumber}</td>
            <td>{$hole->holeText}</td>
            <td>{$hole->par}</td>
            <td>{$hole->length}</td>
        </tr>
        {/foreach}
    </table>
<hr style="clear: both" />
{/foreach}
{/if}
