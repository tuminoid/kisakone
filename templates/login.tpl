{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Stand-alone login form
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
{translate id='login_title' assign='title'}
{include file='include/header.tpl'}

<h2>{translate id='loginform_title'}</h2>

{if $failedAlready}
    <p class="error">{$errorMessage}
        {*{translate id='error_invalid_login_details'}*}</p>
{/if}

<form method="post" class="evenform">
    
    <input type="hidden" name="formid" value="login" />
    <input type="hidden" name="loginAt" value="{$smarty.now}" />
    
    <div>
        <label for="f_username">{translate id='username'}</label>
        <input id="f_username" type="text" name="username" value="{$smarty.post.username|escape}" />
    </div>
    <div>
        <label for="f_password">{translate id='password'}</label>
        <input id="f_password" type="password" name="password" />
    </div>
    
    <div>        
        <input type="submit" value="{translate id='loginbutton'}" />                
    </div>
    <div>
    <input type="checkbox" name="rememberMe" /> Muista salasana
    </div>
    <p>
        <a href="{url page='register'}">{translate id=register}</a>
        | <a href="{url page='recoverpassword'}">{translate id=forgottenpassword}</a>
    </p>
</form>

{include file='include/footer.tpl'} 