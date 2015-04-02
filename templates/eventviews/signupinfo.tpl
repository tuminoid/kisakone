{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
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
    <div class="error">{translate id=admin_cant_sign_up}</div>
    {assign var=nosignup value=true}
{elseif !$user}
    <div class="error">{translate id=login_to_sign_up}</div>
    {assign var=nosignup value=true}
{elseif $feesMissing}
    <div class="error">
    {if $pdga && $pdga_country != 'FI'}
        {translate id=fees_necessary_for_signup_pdga}
    {elseif $feesMissing == 1}
        {translate id=fees_necessary_for_signup_1}
    {elseif $feesMissing == 2}
        {translate id=fees_necessary_for_signup_2}
    {elseif $feesMissing == 6}
        <p>{translate id=fees_necessary_for_signup_3}</p>
        <p>{translate id=check_registry_data}</p>
    {/if}
    </div>
    {assign var=nosignup value=true}
{/if}


{if $queued}

    <p class="signup_status">{translate id=signed_up_in_queue}</p>
    <ul>
        <li><a href="{url page=event view=queue id=$smarty.get.id}">{translate id=event_queue}</a></li>
        <li><a href="{url page=event view=cancelsignup id=$smarty.get.id}">{translate id=cancel_signup}</a></li>
    </ul>

{elseif $admin || (!$signedup && $signupOpen)}

<form method="post" class="">
    <input type="hidden" name="formid" value="sign_up" />
    {if $user}
        <div id="playerinfo" style="float: right; width: 200px" class="searcharea">
            <table>
            <tr>
                <td><label for="sfl_license">{translate id=license_status_header}</label></td>
                <td><span id="sfl_license">
                    {if $sfl_license_a}
                        {translate id=alicense}
                    {elseif $sfl_license_b}
                        {translate id=blicense}
                    {elseif $sfl_membership}
                        {translate id=membership}
                    {else}
                        {translate id=none_paid}
                    {/if}
                </span></td>
            </tr>
            {include file='include/pdgainfotable.tpl'}
            </table>
        </div>

        <p class="signup_status">{translate id=not_signed_up}</p>

        {assign var=player value=$user->getPlayer()}
        {foreach from=$classes item=class}
            <div>
                <input type="radio" name="class" id="class" value="{$class->id}" />
                <label for="class">{$class->name|escape}</label>
            </div>
        {/foreach}
        {foreach from=$unsuited item=class}
            <div>
                <input type="radio" name="class" id="class" value="{$class->id}" disabled="disabled" />
                <label for="class" style="color: #888;">{$class->name|escape}</label>
            </div>
        {/foreach}

        <div style="padding: 1em;">
        <input type="submit" {if $nosignup}disabled="disabled"{/if} value="{translate id="signup"}" />
        <input type="submit" id="cancel" name="cancel" value="{translate id="cancel"}" />
        </div>
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

    <p>{translate id=signup_closed}</p>
    {if $signupStart}
        <p>{translate id=signup_closed_dates from=$signupStart to=$signupEnd}</p>
    {/if}

{/if}

{if $rules}
<h2 id="regrules" style="clear:both">{translate id=event_registration_rules}</h2>

<div>
    <table>
    <tr><th>Luokka</th><th colspan="3">Ehto</th><th>Asti</th></tr>
    {foreach from=$rules item=rule}
        {assign var=op value=$rule.Op}
        {assign var=type value=$rule.Type}
        {assign var=value value=$rule.Value}
        <tr>
            <td>{if $rule.Classification}{$rule.ClassName}{else}{translate id=rule_all_classes}{/if}</td>
            <td>{translate id=ruletype_short_$type}</td>
            <td>{$op}</td>
            <td>
                {if $type == 'co' or $type == 'status'}
                    {capture name=valuetype assign=rulevalue}{$type}_{$value}{/capture}
                    {translate id=rulevalue_$rulevalue}
                {else}
                    {$value}
                {/if}
            </td>
            <td>{if $rule.Valid}{$rule.ValidUntil}{else}{translate id=rule_not_valid}{/if}</td>
        </tr>
    {/foreach}
    </table>
</div>
{/if}

{/if}
