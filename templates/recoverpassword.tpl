{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Password recovery dialog
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
{translate id='recoverpassword_title' assign='title'}
{include file='include/header.tpl'}


{if $failedAlready}
    <p class="error">{translate id='error_no_such_user'}</p>
{/if}

<p>{translate id=recover_password_help}</p>

<form method="post" class="evenform">

    <input type="hidden" name="formid" value="recover_password" />

    <div>
        <label for="username">{translate id='username_or_email'}</label>
        <input id="username" type="text" name="username" value="{$smarty.post.username|escape}" />
    </div>

    <p>
        <input type="submit" value="{translate id=recover}" />

    </p>
</form>

{include file='include/footer.tpl'}
