{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * License and membership fee management
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
{translate id='users_title' assign='title'}
{include file='include/header.tpl' }

<form method="get" class="usersform" action="{url page=managefees}">
    {initializeGetFormFields  search=false }
    <div class="formelements">        
         <p>{translate id=users_searchhint} </p>
        <input id="searchField" type="text" size="30" name="search" value="{$smarty.get.search|escape}" />
        <input type="submit" value="{translate id=users_search}" />
    </div>    
</form>

<div class="SearchStatus" />
<form method="post">
    <p style="clear: both;"><input type="submit" value="{translate id=form_save}" /></p>
    <input type="hidden" name="formid" value="manage_fees" />
    <table id="userTable" class="hilightrows">
       <tr>
          <th>{sortheading field=name id=users_name sortType=alphabetical}</th>
          <th>{sortheading field=pdga id=users_pdga sortType=integer}</th>
          <th>{sortheading field=Username id=users_id sortType=alphabetical}</th>
          <th>{sortheading field=1 id=user_licensefee sortType=checkboxchecked}</th>
          <th>{sortheading field=1 id=user_membershipfee sortType=checkboxchecked}</th>
          {*<th>{translate id=eventfee_remind}</th>*}
       </tr>
        
            
       {foreach from=$users item=user}
          {assign var=userid value=$user.user->id}          
         <tr>
            <td><a href="{url page="user" id="$userid"}">{$user.user->fullname|escape}</a></td>
            
             <td>{$user.player->pdga|escape}</td>
             <td><a href="{url page="user" id="$userid"}">{$user.user->username|escape}</a></td>
             <td>
                {foreach from=$user.licensefees item=payment key=year}
                    <input type="hidden" name="oldlfee_{$userid}_{$year}" value="{$payment}" />
                    <input type="checkbox" name="newlfee_{$userid}_{$year}" {if $payment}checked="checked"{/if} />
                    {translate id=fee} {$year}<br />
                {/foreach}
             </td>
            <td>
                {foreach from=$user.membershipfees item=payment key=year}
                    <input type="hidden" name="oldmfee_{$userid}_{$year}" value="{$payment}" />
                    <input type="checkbox" name="newmfee_{$userid}_{$year}" {if $payment}checked="checked"{/if} />
                    {translate id=fee} {$year}<br />
                {/foreach}
             </td>
            {*<td>
                <input type="checkbox" name="remind_{$userid}" />
                {translate id=remind}
            </td>*}
         </tr>
       {/foreach}     
    </table>
    <p style="clear: both;">
        <input type="submit" value="{translate id=form_save}" />
        <input name="cancel" type="submit" value="{translate id=form_cancel}" />
    </p>
</form>
<div class="SearchStatus" />

<script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
    TableSearch(document.getElementById('searchField'), document.getElementById('userTable'),
                {/literal}"{translate id=No_Search_Results}"{literal}
                );   
    $($(".SortHeading").get(0)).click();
    
});



{/literal}


//]]>
</script>

{include file='include/footer.tpl' noad=true}
