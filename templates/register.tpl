{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Registration form
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
{translate id='register_title' assign='title'}
{include file='include/header.tpl'}

<form method="post" class="evenform" id="regform">

    <input type="hidden" name="formid" value="register" />

    <h2>{translate id='reg_contact_info'}</h2>

    <div>
        <label for="firstname">{translate id='first_name'}</label>
        <input id="firstname" type="text" name="firstname"  value="{$smarty.post.firstname|escape}" />
        {formerror field='firstname'}
    </div>
    <div>
        <label for="lastname">{translate id='last_name'}</label>
        <input id="lastname" type="text" name="lastname" value="{$smarty.post.lastname|escape}" />
        {formerror field='lastname'}
    </div>
    <div>
        <label for="email">{translate id='reg_email'}</label>
        <input id="email" type="text" name="email"  value="{$smarty.post.email|escape}" />
        {formerror field='email'}
    </div>


    <h2>{translate id='reg_user_info'}</h2>
    <div>
        <label for="username">{translate id='username'}</label>
        <input id="username" type="text" name="username"  value="{$smarty.post.username|escape}" />
        {formerror field='username'}
    </div>
    <div>
        <label for="password1">{translate id='password'}</label>
        <input type="password" id="password1" name="password" />
        {formerror field='password'}
    </div>
    <div>
        <label for="password2">{translate id='password_repeat'}</label>
        <input id="password2" type="password" name="password2" />
        {formerror field='password2'}
    </div>

    <h2>{translate id='reg_player_info'}</h2>
     <div>
        <label for="pdga">{translate id='pdga_number'}</label>
        <input id="pdga" type="text" name="pdga"  value="{$smarty.post.pdga|escape}" />
        {formerror field='pdga'}
    </div>

     <div>
        <label for="gender">{translate id='gender'}</label>
        <input id="gender" type="radio" name="gender" value="male" {if $smarty.post.gender == 'male'}checked="checked"{/if} /> {translate id="male"} &nbsp;&nbsp;
        <input type="radio" name="gender" value="female" {if $smarty.post.gender == 'female'}checked="checked"{/if} /> {translate id="female"}
        {formerror field='gender'}
    </div>

     <div style="margin-top: 8px">
        <label>{translate id='dob'}</label>
        <!--<select  style="min-width: 0" name="day">
            <option value="" selected="true">pp</option>
        </select>-->
        {translate id='year_default' assign='year_default'}
        {html_select_date time='1980-1-1' field_order=DMY month_format=%m
        prefix='dob_' start_year='1900' display_months=false display_days=false year_empty=$year_default month_empty=$month_default day_empty=$day_default field_separator=" "
        all_extra='style="min-width: 0"' }
        {formerror field='dob'}
    </div>

    <h2>{translate id='reg_termsandconditions'}</h2>
    <div>
        <input type="checkbox" id="termsandconditions" name="termsandconditions" {if $smarty.post.termsandconditions}checked="checked"{/if} />
        {capture assign='termslink'}
        <a target="_blank" href="{url page='termsandconditions'}">{translate id='termsandconditionslinktitle'}</a>
           {/capture}
        <label class="checkboxlabel" for="termsandconditions">{translate id='termsandconditions' link=$termslink}</label>
        {formerror field='termsandconditions'}
    </div>

    <h2>{translate id='reg_finalize'}</h2>
    <div>
        <input type="submit" id="registerButton" value="{translate id='form_accept'}" name="register" />
        <input type="submit" id="cancelButton" value="{translate id='form_cancel'}" name="cancel" />
        {* | <a href="{url page='recoverpassword'}">{translate id=forgottenpassword}</a>*}
    </div>
</form>

<script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
    CheckedFormField('regform', 'lastname', NonEmptyField, null);
    CheckedFormField('regform', 'firstname', NonEmptyField, null);
    CheckedFormField('regform', 'email', EmailField, null);
    CheckedFormField('regform', 'username', AjaxField, 'username');
    CheckedFormField('regform', 'password', NonEmptyField, null);
    CheckedFormField('regform', 'password2', RepeatedPasswordField, "password1");
    CheckedFormField('regform', 'gender', RadioFieldSet, null);
    CheckedFormField('regform', 'dob_Year', NonEmptyField, null);
    CheckedFormField('regform', 'termsandconditions', TermsAndConditionsField, null);

    $("#cancelButton").click(CancelSubmit);

});

function TermsAndConditionsField(field, arguments, initialize) {
    if (!initialize) {
	if (field.get()[0].checked) return true;


	{/literal}
	return "{translate id=FormError_Terms escape=false}";
	{literal}
    }

}

{/literal}


//]]>
</script>

{include file='include/footer.tpl'}
