{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Confirmation dialog for deleting an event
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

<h2>{translate id=confirm_event_delete}</h2>

<p>{translate id=confirm_event_delete_text}</p>

<div style="width: 600px; height: 300px; overflow: scroll; padding: 16px; background-color: #EEE ">
    {include file=eventviews/index.tpl}
</div>

<p>{translate id=confirm_event_delete_question}</p>

<form method="post" action="{$url_base}">
    <input type="hidden" name="formid" value="delete_event" />
    <input type="hidden" name="id" value="{$smarty.get.id|escape}" />
    <input type="submit" value="{translate id=delete}" />
    <input type="submit" name="cancel" value="{translate id=abort}" />
</form>

{include file='include/footer.tpl' noad=1}
