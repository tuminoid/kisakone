{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Signup cancellation page
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

{if !$signupOpen}
    <p>{translate id=cant_cancel_signup_now}</p>
{else}

    {if $paid}
    <p><p class="signup_status">{translate id=signed_up_and_paid}</p>
        
    {else}
        <p class="signup_status">{translate id=signed_up_not_paid}</p>
    
    {/if}
    
    <form method="post">
        <input type="hidden" name="formid" value="cancel_signup" />
        <input type="submit" value="{translate id="cancelsignup"}" />
        <input type="submit" name="cancel" value="{translate id="abort"}" />
    </form>
{/if}
    
{/if}