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

{if $smarty.get.failed}
    <p class="error">{translate id=email_verification_failed}</p>
{/if}

{if $smarty.get.verified > 0}
<p class="searcharea">{translate id=email_verification_step3 email=$smarty.get.id|escape}</p>

{elseif $smarty.get.step}
<p>{translate id=email_verification_help}</p>

<p>{translate id=email_verification_step1 email=$smarty.get.id|escape}</p>

<form method="post" class="evenform">
    <input type="hidden" name="formid" value="email_verification" />
    <input type="hidden" name="email" value="{$smarty.get.id}" />
    <p>
        <input type="submit" name="send_token" value="{translate id=send_confirm_email}" />
        <input type="submit" name="edit_info" value="{translate id=editmyinfo_title}" />
    </p>
</form>

{else}
<p>{translate id=email_verification_help2 email=$smarty.get.id|escape}</p>

<form method="post" class="evenform">
    <input type="hidden" name="formid" value="email_verification" />
    <input type="hidden" name="email" value="{$smarty.get.id}" />

    <div>
        <label for="verificationcode">{translate id='verificationcode'}</label>
        <input id="verificationcode" type="text" name="token" value="{if $smarty.get.token}{$smarty.get.token}{/if}" />
    </div>

    <p>
        <input type="submit" value="{translate id=confirm_email}" />
    </p>
</form>
{/if}

{include file='include/footer.tpl'}
