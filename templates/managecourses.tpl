{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Course management listing
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
{translate assign=title id=managecourses_title}
{include file='include/header.tpl' title=$title}

{if $smarty.get.id}
<p><a href="{url page=editcourse id=new event=$smarty.get.id}">{translate id=new_course}</a></p>
{else}
<p><a href="{url page=editcourse id=new}">{translate id=new_course}</a></p>
{/if}

<table class="oddrows narrow">
    <tr>
        <th>{translate id=name}</th>
        <th>{translate id=edit}</th>
        <th>{translate id=copy}</th>
    </tr>
{foreach from=$courses item=course}
    <tr>        
        <td>{$course.Name|escape}</td>
       
        <td>
            {if $smarty.get.id && !$admin}
                {if $course.Event == $smarty.get.id}
                 <a href="{url page=editcourse id=$course.id event=$smarty.get.id}">{translate id=edit}</a>
                {else}
                    {translate id=edit_blocked}
                {/if}
            {else}
                <a href="{url page=editcourse id=$course.id}">{translate id=edit}</a>
            {/if}
        </td>
        <td>
            {if $smarty.get.id}
                <a href="{url page=editcourse id=new template=$course.id event=$smarty.get.id}">{translate id=copy}</a>
            {else}
                <a href="{url page=editcourse id=new template=$course.id}">{translate id=copy}</a>
            {/if}
        </td>
    </tr>
{/foreach}
</table>

{if $smarty.get.id}
<p><a href="{url page=editcourse id=new event=$smarty.get.id}">{translate id=new_course}</a></p>
{else}
<p><a href="{url page=editcourse id=new}">{translate id=new_course}</a></p>
{/if}

{include file='include/footer.tpl' noad=1} 