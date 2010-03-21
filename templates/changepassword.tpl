{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Change password dialog
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
{translate id='changepassword_title' assign='title'}
{include file='include/header.tpl'}


<p>{if $smarty.get.mode == recover}
    {translate id=recover_password_help_final}
    {else}
    {translate id=change_password_help}
    {/if}
</p>

<form method="post" class="evenform" id="regform">
    
    <input type="hidden" name="formid" value="changepassword" />
    
    <div>
	{if $smarty.get.mode == recover}
	    <p>{translate id=recovering_password_for username=$username}</p>
	{else}
        <label for="current">{translate id='old_password'}</label>
        {if !$adminmode}
        <input id="current" type="password" name="current" autocomplete="off" />
        {else}
        <input id="current" type="text" disabled="disabled" value="{translate id=admin_changing_password}" />        

        {/if}
        {formerror field='current_password'}
	{/if}
    </div>
    <div>
        <label for="password1">{translate id='new_password'}</label>
        <input type="password" id="password1" name="password"  autocomplete="off"  />
        {formerror field='password'}
    </div>
    <div>
        <label for="password2">{translate id='password_repeat'}</label>
        <input type="password" name="password2"  autocomplete="off"  />
        {formerror field='password2'}
    </div>
    
    <hr />
    <div>
        <input type="submit" value="{translate id='form_accept'}" name="register" />
        <input type="submit" id="cancelButton" value="{translate id='form_cancel'}" name="cancel" />
        {* | <a href="{url page='recoverpassword'}">{translate id=forgottenpassword}</a>*}
    </div>
</form>

<script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
    CheckedFormField('regform', 'current', NonEmptyField, null);
    CheckedFormField('regform', 'password', NonEmptyField, null);
    CheckedFormField('regform', 'password2', RepeatedPasswordField, "password1");$
    
    $("#cancelButton").click(CancelSubmit);
    
});


{/literal}


//]]>
</script>

{include file='include/footer.tpl'}
