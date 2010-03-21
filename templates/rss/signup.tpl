{*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmº
 *
 * RSS message for signup availablility
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
{capture assign=titleid}rss_{$item.type}{/capture}
{capture assign=textid}{$titleid}_text{/capture}
<title>{translate id=$titleid arguments=$item}</title>
<description>{translate id=$textid arguments=$item}</description>
<pubDate>{$item.rssDate}</pubDate>
{if $item.link}
<link>http://{$smarty.server.HTTP_HOST}{$url_base}event/{$event->id}/signupinfo</link>
{/if}
<guid>{$item.type}</guid>
