{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
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
{translate id='newcompetitor_title' assign='title'}
{include file='include/header.tpl'}

{include file=support/eventlockhelper.tpl}

{if $errorString}
<p class="error">{$errorString}</p>
{/if}

{if $pdga_error}
<p class="error">{translate id=$pdga_error}</p>
{/if}

{if $sfl_error}
<p class="error">{translate id=$sfl_error}</p>
{/if}

{if !$id_entered || $pdga_error || $sfl_error}
<form method="post" class="evenform" id="regform">
    <input type="hidden" name="formid" value="new_competitor" />

    <h2>{translate id=form_search_competitor}</h2>
    <div>
        <label for="pdga">{translate id=pdga_number}</label>
        <input id="pdga" type="text" name="pdga_preview" />
        {formerror field='pdga'}
    </div>
    <div style="padding-left: 300px;">
        {translate id=or}
    </div>
    <div>
        <label for="sflid">{translate id=sfl_number}</label>
        <input id="sflid" type="text" name="sflid_preview" />
        {formerror field='sflid'}
    </div>

    <div>
        <input type="submit" value="{translate id=search}" name="search" />
        <input type="submit" value="{translate id=cancel}" name="cancel" />
    </div>
</form>

{else}

<form method="post" class="evenform" id="regform">
    <input type="hidden" name="formid" value="new_competitor" />

    <h2>{translate id='reg_contact_info'}</h2>
    <div>
        <label for="firstname">{translate id='first_name'}</label>
        <input type="text" id="firstname" name="firstname" value="{$firstname|escape}" disabled="disabled" />
        <input type="hidden" name="firstname" value="{$firstname|escape}" />
        {formerror field='firstname'}
    </div>
    <div>
        <label for="lastname">{translate id='last_name'}</label>
        <input id="lastname" type="text" name="lastname" value="{$lastname|escape}" disabled="disabled" />
        <input type="hidden" name="lastname" value="{$lastname|escape}" />
        {formerror field='lastname'}
    </div>
    <div>
        <label for="email">{translate id='reg_email'}</label>
        <input id="email" type="text" name="email" value="{$email|escape}" {if !$edit_email}disabled="disabled"{/if} />
        {if !$edit_email}<input type="hidden" name="email" value="{$email|escape}" />{/if}
        {formerror field='email'}
    </div>

    <h2>{translate id='reg_player_info'}</h2>
    <div>
        <label for="pdga">{translate id='pdga_number'}</label>
        <input id="pdga" type="text" name="pdga" value="{$pdga|escape}" disabled="disabled" />
        <input type="hidden" name="pdga" value="{$pdga|escape}" />
        {formerror field='pdga'}
    </div>

    <div>
        <label for="gender">{translate id='gender'}</label>
        <input id="gender_m" type="radio" disabled="disabled" {if $gender == 'M'}checked="checked"{/if} name="gender" value="male" /> {translate id="male"} &nbsp;&nbsp;
        <input id="gender_f" type="radio" disabled="disabled" {if $gender == 'F'}checked="checked"{/if} name="gender" value="female" /> {translate id="female"}
        <input type="hidden" name="gender" value="{if $gender == 'M'}male{/if}{if $gender == 'F'}female{/if}" />
    </div>

    <div style="margin-top: 8px">
        <label>{translate id='dob'}</label>
        {translate id='year_default' assign='year_default'}
        <input type="text" name="dob_Year" value="{$birthyear|escape}" disabled="disabled" />
        <input type="hidden" name="dob_Year" value="{$birthyear|escape}" />
        {formerror field='dob'}
    </div>

    <h2>{translate id='reg_finalize_create'}</h2>
    <div>
        <input type="submit" id="newButton" value="{translate id='form_new_competitor'}" name="accept" />
        <input type="submit" id="cancelButton" value="{translate id='cancel'}" name="cancel" />
    </div>
</form>

<script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
    CheckedFormField('regform', 'email', EmailField, null);
    $("#cancelButton").click(CancelSubmit);
});

{/literal}
//]]>
</script>
{/if}

{include file='include/footer.tpl'}
