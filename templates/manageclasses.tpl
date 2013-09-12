{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Class management listing
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
{translate assign=title id=manageclasses_title}
{include file='include/header.tpl' title=$title}

<p><a href="{url page=editclass id=new}">{translate id=new_class}</a></p>

<table class="oddrows narrow">
    <tr>
        <th>{translate id=name}</th>
        <th>{translate id=minage}</th>
        <th>{translate id=maxage}</th>
        <th>{translate id=gender}</th>
        <th>{translate id=available}</th>
        <th>{translate id=edit}</th>
    </tr>
{foreach from=$classes item=class}
    <tr>
        <td>{$class->name|escape}</td>
        <td>{$class->minAge}
        {if !$class->minAge}-{/if}
        </td>
        <td>{$class->maxAge}
        {if !$class->maxAge}-{/if}</td>
        <td>
            {if $class->gender == M}
                {translate id=male}
                {elseif $class->gender == F}
                {translate id=female}
                {else}
                {translate id=any}
                
            {/if}
        </td>
        <td>
            {if $class->available}
            {translate id=yes!}
            {else}
            {translate id=not}
            {/if}
        </td>
        <td>
            <a href="{url page=editclass id=$class->id}">{translate id=edit}</a>
        </td>
        
    </tr>
{/foreach}
</table>

<p><a href="{url page=editclass id=new}">{translate id=new_class}</a></p>

{include file='include/footer.tpl' noad=1} 