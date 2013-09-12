{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
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
    {if $course.Map}
        <img style="float: right" src="{$course.Map}" alt="{translate id=course_map}" />
    {/if}
    
    <h4>{translate id=holes_title}</h4>
    <table class="narrow">
        {if true || $course.Map}
        {* Remove the "true" to enable horizontal listing if there is no image *}
            <tr>
                <th>{translate id=holeNumber}</th>
                <th>{translate id=par}</th>
                <th>{translate id=length}</th>
            </tr>
            {foreach from=$course.Holes item=hole}
            <tr>
                <td>{$hole->holeNumber}</td>
                 <td>{$hole->par}</td>
                 <td>{$hole->length}</td>
            </tr>
            {/foreach}
            
           
        {else}
            <tr>
                <th>{translate id=holeNumber}</th>
                {foreach from=$course.Holes item=hole}
                    <td>{$hole->holeNumber}</td>
                {/foreach}
            </tr>
            <tr>
                <th>{translate id=par}</th>
                {foreach from=$course.Holes item=hole}
                    <td>{$hole->par}</td>
                {/foreach}
            </tr>
            <tr>
                <th>{translate id=length}</th>
                {foreach from=$course.Holes item=hole}
                    <td>{$hole->length}</td>
                {/foreach}
            </tr>
        {/if}
    </table>
<hr style="clear: both" />
{/foreach}
{/if}