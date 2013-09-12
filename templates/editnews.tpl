{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * News editor listing ui
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
{translate assign=title id=editnews_title}
{include file='include/header.tpl' title=$title}
<h2>{translate id=editnews_title}</h2>

<p><a href="{url page=editeventpage id=$smarty.get.id content=* mode=news}">{translate id=new_news}</a></p>

<table class="oddrows">
{foreach from=$news item=item}
    <tr>
        <td><a href="{url page=editeventpage mode=news id=$smarty.get.id content=$item->id}">{$item->title|escape}</a></td>        
        <td>{$item->date|date_format:"%d.%m.%Y %H:%M:%S"}</td>
        <td>{$item->content|escape}</td>
    </tr>
{/foreach}
</table>

<p><a href="{url page=editeventpage id=$smarty.get.id content=* mode=news}">{translate id=new_news}</a></p>

{include file='include/footer.tpl' noad=1} 