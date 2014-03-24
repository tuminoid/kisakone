{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Event ad listing
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

<table class="oddrows">
    <tr>
        <th>{translate id=ad_location}</th>
        <th>{translate id=ad_type}</th>
        <th>{translate id=ad_actions}</th>
    </tr>
    {foreach from=$ads item=ad}
    <tr>
        <td>{capture assign=locid}ad_event_location_{$ad->contentId}{/capture}
        {translate id=$locid}</td>
        <td>{capture assign=typeid}ad_type_{$ad->type}{/capture}
        {translate id=$typeid}</td>
        <td><a href="{url page=editad id=$event->id adType=$ad->contentId}">{translate id=edit}</a>
            <a href="{url page=editad id=$event->id adType=$ad->contentId preview=1}">{translate id=preview}</a></td>
    </tr>
    {/foreach}
</table>

{include file='include/footer.tpl' noad=1 }
