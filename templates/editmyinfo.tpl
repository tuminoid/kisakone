{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013, 2015, 2018 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * User info editor
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
{translate id='editmyinfo_title' assign='title'}
{include file='include/header.tpl'}

<form method="post" class="evenform" id="regform">

    <input type="hidden" name="formid" value="editmyinfo" />

    <h2>{translate id='reg_contact_info'}</h2>

    <div>
        <label for="firstname">{translate id='first_name'}</label>
        <input id="firstname" type="text" name="firstname"  value="{$userdata->firstname|escape}" />
        {formerror field='firstname'}
    </div>
    <div>
        <label for="lastname">{translate id='last_name'}</label>
        <input id="lastname" type="text" name="lastname" value="{$userdata->lastname|escape}" />
        {formerror field='lastname'}
    </div>
    <div>
        <label for="email">{translate id='reg_email'}</label>
        <input id="email" type="text" name="email" value="{$userdata->email|escape}" />
        <input type="hidden" name="email_old" value="{$userdata->email|escape}" />
        {formerror field='email'}
    </div>

    {if $player}
    <h2>{translate id='reg_player_info'}</h2>
    <div>
        <label for="pdga">{translate id='pdga_number'}</label>
        <input id="pdga" type="text" name="pdga"  value="{$player->pdga|escape}" />
        <p>{formerror field='pdga'}</p>
    </div>

    {if $suomisport_enabled}
    <div>
        <label for="sportid">{translate id='sportid_number'}</label>
        <input id="sportid" type="text" name="sportid"  value="{$userdata->sportid|escape}" />
        <p>{formerror field='sportid'}</p>
    </div>
    {/if}

    <div>
        <label for="gender">{translate id='gender'}</label>
        <input id="gender" type="radio" name="gender" value="M" {if $player->gender == 'M'}checked="checked"{/if} /> {translate id="male"} &nbsp;&nbsp;
        <input type="radio" name="gender" value="F" {if $player->gender == 'F'}checked="checked"{/if} /> {translate id="female"}
        {formerror field='gender'}
    </div>

    <div>
        <label>{translate id='dob'}</label>
        {translate id='year_default' assign='year_default'}
        {html_select_date time=$dob field_order=DMY month_format=%m
        prefix='dob_' display_months=false display_days=false start_year='1900' year_empty=$year_default month_empty=$month_default day_empty=$day_default field_separator=" "
        all_extra='style="min-width: 0"' }
        {formerror field='dob'}
    </div>
    {/if}
    <hr />
    <div>
        <input type="submit" value="{translate id='form_save'}" name="save" />
    </div>
</form>

<script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
    CheckedFormField('regform', 'lastname', NonEmptyField, null);
    CheckedFormField('regform', 'firstname', NonEmptyField, null);
    CheckedFormField('regform', 'email', EmailField, null);
//    CheckedFormField('regform', 'pdga', PositiveIntegerField, null);
//    CheckedFormField('regform', 'sportid', PositiveIntegerField, null);
    CheckedFormField('regform', 'gender', RadioFieldSet, null);
    CheckedFormField('regform', 'dob_Year', NonEmptyField, null);
    $("#cancelButton").click(CancelSubmit);

});


{/literal}


//]]>
</script>

{include file='include/footer.tpl'}
