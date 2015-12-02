{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Email verification system
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

{translate id='emailverification_title' assign='title'}
{include file='include/header.tpl'}

<h2>{translate id=emailverification_title}</h2>

{if $error}
    <p class="error">{translate id=$error}</p>
{/if}

<p>{translate id=email_verification_help}</p>

<p>{translate id=email_verification_help2 email=$email|escape}</p>

<form method="post" class="evenform">
    <input type="hidden" name="formid" value="email_verification" />

    <div>
        <label for="verificationcode">{translate id='verificationcode'}</label>
        <input id="verificationcode" type="text" name="verificationcode" value="" length="10" maxlength="10" />
    </div>

    <p>
        <input type="submit" value="{translate id=confirm_email}" />
    </p>
</form>

{*
<p>
    {translate id=email_resend_code email=$email}
</p>
*}

{include file='include/footer.tpl'}
