{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * RSS feed for events
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
<rss version="2.0">
    <channel>
        <title>{translate id=eventrss_title eventname=$event->name eventvenue=$event->venue}</title>
        <link>http://{$smarty.server.HTTP_HOST}{$url_base}event/{$event->id}</link>
        <description>{translate id=eventrss_description eventname=$event->name eventvenue=$event->venue}</description>
        <language>{$language}</language>
        <generator>Kisakone 1.0 EventRSS</generator>
        <copyright>{translate id=rss_copyright}</copyright>
        <image>
            <url>http://{$smarty.server.HTTP_HOST}{$url_base}ui/elements/sitelogo.png</url>
            <title>{translate id=eventrss_title eventname=$event->name eventvenue=$event->venue}</title>
            <link>http://{$smarty.server.HTTP_HOST}{$url_base}event/{$event->id}</link>
        </image>
        {foreach from=$items item=item}
            {if $item !== null}
                <item>
                    {capture assign=filename}rss/{$item.template}.tpl{/capture}
                    {include file=$filename }
                </item>
            {/if}
        {/foreach}
    </channel>

</rss>
