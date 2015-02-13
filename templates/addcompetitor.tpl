{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file is the UI for adding competitors to an event
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
{translate id='addcompetitor_title' assign='title'}
{include file='include/header.tpl' autocomplete=1}

{include file=support/eventlockhelper.tpl}

{if $errorString}
<p class="error">{$errorString}</p>
{/if}

{if !$userdata && !is_array($many)}
    {* We have neither an user, nor a listing *}
    <p>{translate id=add_competitor_help}</p>
    <form method="get">
        {initializeGetFormFields  search=false}
        <label>{translate id=add_competitor_prompt}</label>
        <input id="player" type="text" size="40" name="player" />
        <input name="op_s"  type="submit" value="{translate id=search}" />
    </form>

    <p>
        <a href="{url page=newcompetitor id=$smarty.get.id user=new}">{translate id=add_competitor_create_new}</a>
    </p>

    <script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
   var options, a;
    // Initialize autocomplete
    options = { serviceUrl: baseUrl ,
                params: {path: 'autocomplete', 'id': 'players' }};
    a = $('#player').autocomplete(options);
});

{/literal}

//]]>
</script>

{elseif is_array($many)}
    {* Listing of users *}
    <p>{translate id=add_competitor_list_help}</p>
    <table class="oddrows">
        {foreach from=$many item=user}
            {assign var=player value=$user->getPlayer()}
            <tr>
                <td><a href="{url page=addcompetitor id=$smarty.get.id user=$user->id}">{translate id=select}</a></td>
                <td>{$player->pdga|escape}</td>
                <td>{$user->fullname|escape}</td>

                <td>
                    {if $user->username}
                        {$user->username|escape}
                    {else}
                        {translate id=add_competitor_no_username}
                    {/if}
                </td>
            </tr>

        {foreachelse}
            <tr><td>{translate id=add_competitor_nomatch}</td></tr>
        {/foreach}
    </table>

    <p>
        <a href="{url page=newcompetitor id=$smarty.get.id user=new}">{translate id=add_competitor_create_new}</a>
    </p>

{else}
    {* User details *}
<form method="post" class="evenform" id="regform">
    {assign var=player value=$userdata->getPlayer()}
    <input type="hidden" name="userid" value="{$user->id}" />
    <input type="hidden" name="formid" value="add_competitor" />

    <h2>{translate id='reg_contact_info'}</h2>
    <div>
        <label for="firstname">{translate id='first_name'}</label>
        <input type="text" id="firstname" name="firstname" disabled="disabled" value="{$userdata->firstname|escape}" />
        {formerror field='firstname'}
    </div>
    <div>
        <label for="lastname">{translate id='last_name'}</label>
        <input type="text" id="lastname" name="lastname" disabled="disabled" value="{$userdata->lastname|escape}" />
        {formerror field='lastname'}
    </div>
    <div>
        <label for="email">{translate id='reg_email'}</label>
        <input type="text" id="email" name="email" disabled="disabled" value="{$userdata->email|escape}" />
        {formerror field='email'}
    </div>

    {if $userdata->id}
    <h2>{translate id='reg_user_info'}</h2>
    <div>
        <label for="username">{translate id='username'}</label>
        <input type="text" id="username" name="username" disabled="disabled" value="{$userdata->username|escape}" />
        {formerror field='username'}
    </div>
    {/if}


    <h2>{translate id='reg_player_info'}</h2>
     <div>
        <label for="pdga">{translate id='pdga_number'}</label>
        <input id="pdga" type="text" disabled="disabled" name="pdga" value="{$player->pdga|escape}" />
        {if $pdga && $pdga_membership_status != "current"}
            <img src="/images/exclamation.png" height="16" alt="error!"
                title="{translate id=pdga_membership_expired} ({$pdga_membership_status}: {$pdga_membership_expiration_date})" />
        {/if}
        {formerror field='pdga'}
    </div>

     <div>
        <label for="gender">{translate id='gender'}</label>
        <input id="gender" type="radio" disabled="disabled" {if $player->gender == 'M'}checked="checked"{/if} name="gender" value="male" /> {translate id="male"} &nbsp;&nbsp;
        <input type="radio" disabled="disabled" {if $player->gender == 'F'}checked="checked"{/if} name="gender" value="female" /> {translate id="female"}
        {if $pdga}
            {if $pdga_gender != $player->gender}
            <img src="/images/exclamation.png" height="16" alt="error!"
                title="{translate id=pdga_data_mismatch} ({$player->gender} vs {$pdga_gender})" />
            {/if}
        {/if}
    </div>


     <div style="margin-top: 8px">
        <label>{translate id='dob'}</label>
        {translate id='year_default' assign='year_default'}
        <input type="text" value="{$player->birthyear|escape}" disabled="disabled" />
        {if $pdga && $pdga_birth_year != $player->birthyear}
            <img src="/images/exclamation.png" height="16" alt="error!"
                title="{translate id=pdga_data_mismatch} ({$player->birthyear|escape} vs {$pdga_birth_year})" />
        {/if}
        {formerror field='dob'}
    </div>

    <h2>{translate id='add_competitor_class'}</h2>
    <div>
        {if $pdga}
        <table style="width: 300px" class="searcharea">
        {include file='include/pdgainfotable.tpl'}
        </table>
        {/if}

        <label for="class">{translate id='class'}</label>
        <select id="class" name="class">
            {html_options options=$classOptions}
        </select>

        {formerror field='class'}
    </div>

    <h2>{translate id='license_status_header'}</h2>
    <div>
        {if $licenses_ok}
            <div class="searcharea">
            {if $sfl_license_a}
                {translate id='license_ok_a'}
            {elseif $sfl_license_b}
                {translate id='license_ok_b'}
            {else}
                {if $pdga && $pdga_country != "FI" && $pdga_membership_status == "current"}
                    {translate id='license_ok_foreign'}
                {else}
                    This shouldn't happen...
                {/if}
            {/if}
            </div>
        {else}
            <div class="error">
            {assign var="licenses_ok" value=false}
            {if $pdga && $pdga_country != "FI"}
                {if $pdga_membership_status != "current"}
                    {translate id='license_fail_foreign'}
                {else}
                    This shouldn't happen...
                {/if}
            {else}
                {if $sfl_license_b && $licenses_ok == false}
                    {translate id='licenses_fail_onlyb'}
                {else}
                    {translate id='licenses_fail'}
                {/if}
            {/if}
            </div>
        {/if}
    </div>

    <h2>{translate id='reg_finalize'}</h2>
    <div>
        <input type="submit" value="{translate id='form_add_competitor'}" name="accept" {if !$licenses_ok}disabled="disabled"{/if} />
        <input type="submit" value="{translate id='form_add_competitor_queue'}" name="accept_queue" {if !$licenses_ok}disabled="disabled"{/if} />
        <input type="submit" id="cancelButton" value="{translate id='form_cancel'}" name="cancel" />
    </div>
</form>

{/if}

{include file='include/footer.tpl'}
