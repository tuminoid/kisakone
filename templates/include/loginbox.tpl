{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Login box/login information
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
{if $user eq null}
<div class="loginbox" id="login_panel">
    <a id="login_link" href="{url page='login'}">{translate id=login}</a> |
    <a id="register_link" href="{url page='register'}">{translate id=register}</a>

</div>
<form class="loginbox hidden" action="{$url_base}" id="login_form" method="post">
    <input type="hidden" name="comingFrom" value="{$smarty.server.REQUEST_URI|escape}" />
    <a id="loginform_x" href="" class="dialogx" ><img src="{$url_base}images/loginx2.png" alt="{translate id=close}" /></a>
    <input type="hidden" name="loginAt" value="{$smarty.now}" />
    <input type="hidden" name="formid" value="login" />
    <div>
        <label for="loginUsernameInput">{translate id='username'}</label>
        <input type="text" name="username" id="loginUsernameInput" />
    </div>
    <div>
        <label for="loginPassword">{translate id='password'}</label>
        <input type="password" id="loginPassword" name="password" />
    </div>

    <div>
        <input id="loginRememberMe" type="checkbox" name="rememberMe" /> Muista salasana
        <input id="loginSubmit" type="submit" value="{translate id='loginbutton'}" />
    </div>
    <div>
        <a href="{url page='register'}">{translate id=register}</a> |
        <a href="{url page='recoverpassword'}">{translate id=forgottenpassword}</a>
    </div>
</form>
{else}
    <div class="loginbox">
    <div>{translate id='loginform_loggedin_title'}</div>
    <div>{translate id='loginform_loggedin_as' user=$user->username firstname=$user->firstname lastname=$user->lastname}</div>
    <p>
        <a id="loginMyInfo" href="{url page=myinfo}">{translate id='my_info'}</a> |
        <a id="logout" href="{$url_base}?action=logout">{translate id='logout'}</a>
    </p>
    </div>
{/if}
