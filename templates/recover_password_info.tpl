{*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Password recovery info
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
{translate id='recoverpassword_title' assign='title'}
{include file='include/header.tpl'}

{if $smarty.get.failed}
<p class="error">
    {translate id=error_invalid_token}
</p>
{/if}

<p>{translate id=recover_password_done}</p>
<p>{translate id=recover_password_done2}</p>

<form method="get" class="evenform" action="{url page=changepassword id=$smarty.get.id mode=recover}">    
    <div>
        <label for="token">{translate id='passwordtoken'}</label>
        <input id="token" type="text" name="token" value="" />
    </div>
    
    <p>
        <input type="submit" value="{translate id=proceed}" />
        
    </p>
</form>

{include file='include/footer.tpl'} 