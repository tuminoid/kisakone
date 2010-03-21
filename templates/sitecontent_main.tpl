{*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Global page listing
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
{translate assign=title id=sitecontent_title}
{include file='include/header.tpl'}
{translate id=admin_sitecontent_main_text}

<table class="oddrows narrow">
    {foreach from=$fixed item=link}
        <tr>
            <td>{$link.title|escape}</td>
            <td><a href="{url page=sitecontent id=$link.type}">{translate id=edit}</a></td>
            <td><a href="{url page=content id=$link.type}">{translate id=preview}</a></td>
        </tr>
    {/foreach}
</table>
<p>{translate id=sitecontent_custom_text}</p>

<table class="oddrows narrow">
    {foreach from=$dynamic item=link}
        <tr>
            <td>{$link.title|escape}</td>
            <td><a href="{url page=sitecontent id=$link.id mode=custom}">{translate id=edit}</a></td>
            <td><a href="{url page=content id=$link.title}">{translate id=preview}</a></td>
        </tr>
    {/foreach}
</table>

    

<p>
    <a href="{url page=sitecontent id=* mode=custom}">{translate id=new_page}</a>
</p>
     
{include file='include/footer.tpl' noad=1} 