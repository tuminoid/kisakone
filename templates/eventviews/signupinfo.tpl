{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010,2013 Kisakone projektiryhmä
 *
 * Sign up page
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


{if $admin}
<p>{translate id=admin_cant_sign_up}</p>
{assign var=nosignup value=true}
{elseif !$user}
<p>{translate id=login_to_sign_up}</p>
{assign var=nosignup value=true}
{elseif $feesMissing}
    {if $feesMissing == 1}
        <p>{translate id=fees_necessary_for_signup_1}</p>
    {elseif $feesMissing == 2}
        <p>{translate id=fees_necessary_for_signup_2}</p>
    {elseif $feesMissing == 6}
        <p>{translate id=fees_necessary_for_signup_3}</p>
    {/if}
{assign var=nosignup value=true}
{/if}

{if $admin ||( !$signedup && $signupOpen)}

<form method="post" class="">
    <input type="hidden" name="formid" value="sign_up" />
    {if $user}
        <p class="signup_status">{translate id=not_signed_up}</p>
        {assign var=player value=$user->getPlayer()}        
        {foreach from=$classes item=class}
            <div>
                <input type="radio" name="class" id="class" value="{$class->id}" {if !$player || !$player->isSuitableClass($class) || $nosignup}disabled="disabled"{/if} />
                <label>{$class->name|escape}</label>
            </div>
        {/foreach}
        
        <hr style="clear: both" />
        <input type="submit" {if $nosignup}disabled="disabled"{/if} value="{translate id="signup"}" />
        <input type="submit" id="cancel" name="cancel" value="{translate id="cancel"}" />
    {/if}
</form>
{elseif $paid}
    <p class="signup_status">{translate id=signed_up_and_paid}</p>
    <ul>
        <li><a href="{url page=event view=cancelsignup id=$smarty.get.id}">{translate id=cancel_signup}</a></li>    
    </ul>
{elseif $signedup && !$paid}
    <p class="signup_status">{translate id=signed_up_not_paid}</p>
    <ul>
        <li><a href="{url page=event view=payment id=$smarty.get.id}">{translate id=event_payment}</a></li>    
        <li><a href="{url page=event view=cancelsignup id=$smarty.get.id}">{translate id=cancel_signup}</a></li>    
    </ul>
{else}
    <p>
    {if $signupStart}
        {translate id=signup_closed_dates from=$signupStart to=$signupEnd}
    {else}
        {translate id=signup_closed}
    {/if}
    </p>
{/if}
    
{/if}
