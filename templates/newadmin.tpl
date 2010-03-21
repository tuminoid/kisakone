{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * "Create new admin" page
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
{translate id='newadmin_title' assign='title'}
{include file='include/header.tpl'}

{if $done}
    <p class="searcharea">
	{translate id=admin_created username=$smarty.post.username}
    </p>
{/if}

<form method="post" class="evenform" id="regform">
    
    <input type="hidden" name="formid" value="add_admin" />
    
    <h2>{translate id='reg_contact_info'}</h2>    
    
    <div>
        <label for="lastname">{translate id='last_name'}</label>
        <input id="lastname" type="text" name="lastname" value="{if !$done}{$smarty.post.lastname|escape}{/if}" />
        {formerror field='lastname'}
    </div>
    <div>
        <label for="firstname">{translate id='first_name'}</label>
        <input id="firstname" type="text" name="firstname"  value="{if !$done}{$smarty.post.firstname|escape}{/if}" />
        {formerror field='firstname'}
    </div>
    <div>
        <label  for="email">{translate id='reg_email'}</label>
        <input id="email" type="text" name="email"  value="{if !$done}{$smarty.post.email|escape}{/if}" />
        {formerror field='email'}
    </div>
    
    <h2>{translate id='reg_user_info'}</h2>
    <div>
        <label for="username">{translate id='username'}</label>
        <input id="username" type="text" name="username"  value="{if !$done}{$smarty.post.username|escape}{/if}" />
        {formerror field='username'}
    </div>
    <div>
        <label for="password1">{translate id='password'}</label>
        <input type="password" id="password1" name="password" />
        {formerror field='password'}
    </div>
    <div>
        <label for="password2">{translate id='password_repeat'}</label>
        <input type="password" name="password2" />
        {formerror field='password2'}
    </div>
    
    <h2>{translate id='user_access_level'}</h2>
    <div>        
        <input type="radio" name="access" value="admin" {if !$done && $smarty.post.access =='admin'}checked="checked"{/if} />
	{translate id=access_level_admin}
	    <br />
	    
	<input type="radio" name="access" value="manager" {if !$done && $smarty.post.access =='manager'}checked="checked"{/if} />
	{translate id=access_level_manager}
	<br />
        {formerror field='access'}
    </div>
    
    
    <h2>{translate id='reg_finalize'}</h2>
    <div>
        <input type="submit" value="{translate id='form_accept'}" name="register" />
        <input type="submit" id="cancelButton" value="{translate id='form_cancel'}" name="cancel" />        
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
    CheckedFormField('regform', 'access', RadioFieldSet, null);
    
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

{include file='include/footer.tpl' noad=1}
