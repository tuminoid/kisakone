{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Custom event page listing
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
{assign var=title value=$event->name}
{include file='include/header.tpl'}

{translate id=eventpages_custom_main_text}

<ul>
    {foreach from=$links item=link}
        <li>
            <a href="{url arguments=$link.link}">{$link.title|escape}</a>
        </li>
        {foreachelse}
        <li>{translate id=no_content}</li>

    {/foreach}
</ul>

<p>
    {capture assign=link}<a href="{url page=editeventpage id=$smarty.get.id mode=custom content="*"}">{translate id=create_new_custom_page_link}</a>{/capture}
    {translate id=create_new_custom_page_text link=$link}
</p>

{include file='include/footer.tpl' noad=1}
