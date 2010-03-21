{*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * User listing
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
{include file='include/header.tpl'}

<form method="get" class="usersform" action="{url page=users}">
    {initializeGetFormFields  search=false }
    <div class="formelements">        
         <p>{translate id=users_searchhint} </p>
        <input id="searchField" type="text" size="30" name="search" value="{$smarty.get.search|escape}" />
        <input type="submit" value="{translate id=users_search}" />
    </div>    
</form>
<hr style="clear: both;" />
<div class="SearchStatus" />

<table id="userTable">
   <tr>
      <th>{sortheading field=name id=users_name sortType=alphabetical}</th>
      <th>{sortheading field=pdga id=users_pdga sortType=integer}</th>
      <th>{sortheading field=Username id=users_id sortType=alphabetical}</th>
      
   </tr>

   {foreach from=$users item=user}
      
      {assign var=player value=$user->GetPlayer()}
      {if $user->username == null || strpos($user->username, '/') !== false}
        {capture assign=url}{url page="user" id=$user->id}{/capture}
        {else}
        {capture assign=url}{url page="user" id=$user->username}{/capture}
        {/if}
      
     <tr>
        <td><a href="{$url}">{$user->firstname|escape} {$user->lastname|escape}</a></td>
        
         <td>{$player->pdga|escape}</td>
         <td><a href="{$url}">{$user->username|escape}</a></td>
         
     </tr>
   {/foreach}     
</table>

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

{include file='include/footer.tpl'}
