{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Event fee reminding dialog
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
 {translate assign=title id=send_reminds_title}
{translate assign=save_text id=send_email}
{include file='include/header.tpl'}

<p>{translate id=sending_email_to recipients=$numReminds}</p>

<form method="post" action="{url page=remind id=$smarty.get.id}">
<input type="hidden" name="formid" value="remind" />
<input type="hidden" name="ids" value="{$idlist|escape}" />

{include file='editemail.tpl' inline=true}
</form>
{include file='include/footer.tpl' noad=1}
