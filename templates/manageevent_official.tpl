{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Event management menu (official version)
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

{translate id=manage_event_text}
{submenulinks}

<p>{translate id=print_score_cards_help}</p>
<ul>
{foreach from=$rounds item=round key=index}
    {math assign=roundnum equation="x+1" x=$index}
    <li><a href="{url page=printscorecard round=$roundnum id=$smarty.get.id}">{translate id=round_number number=$roundnum}</a>
    {if !$round->groupsFinished}{translate id=preliminary}{/if}
    </li>
{/foreach}
</ul>

{include file='include/footer.tpl' noad=1} 