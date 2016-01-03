{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Signup cancellation page
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
 {if $mode == 'body'}

 <div id="event_content">
    {$page->formattedText}
</div>

{if !$user}
    <p class="error">{translate id=login_to_sign_up}</p>
{elseif !$signupOpen}
    <p>{translate id=cant_cancel_signup_now}</p>
{else}

    {if $queued}
    <p class="signup_status">{translate id=signed_up_in_queue}</p>
    {elseif $payment_enabled}
        {if $paid}
        <p class="signup_status">{translate id=signed_up_and_paid}</p>
        {else}
        <p class="signup_status">{translate id=signed_up_not_paid}</p>
        {/if}
    {else}
        <p class="signup_status">{translate id=signed_up_payment_disabled}</p>
    {/if}

    <form method="post">
        <input type="hidden" name="formid" value="cancel_signup" />
        <input type="submit" value="{translate id="cancelsignup"}" />
    </form>
{/if}

{/if}
