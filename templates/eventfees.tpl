{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Mark event fees paid, and send reminder emails
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
{translate id='eventfees_title' assign='title'}
{include file='include/header.tpl' }

{include file=support/eventlockhelper.tpl}

<p><button id="toggle_submenu">{translate id=toggle_menu}</button></p>

<form method="get" class="usersform searcharea" action="{url page=eventfees id=$smarty.get.id}">
    {initializeGetFormFields  search=false }
    <div class="formelements">        
         <p>{translate id=users_searchhint} </p>
        <input id="searchField" type="text" size="30" name="search" value="{$smarty.get.search|escape}" />
        <input type="submit" value="{translate id=users_search}" />
    </div>
    <br style="clear: both" />
</form>


<div class="SearchStatus" />
<form method="post">
    <p style="clear: both;"><input type="submit" value="{translate id=form_save}" /></p>
    <p><input class="all" type="checkbox" name="remind_all" /> {translate id=remind_all}</p>
    <input type="hidden" name="formid" value="event_fees" />
    <table id="userTable" class="hilightrows oddrows">
       <tr>
        <th>{sortheading field=1 id=num sortType=integer}</th>
          <th>{sortheading field=LastName id=lastname sortType=alphabetical}</th>
          <th>{sortheading field=FirstName id=firstname sortType=alphabetical}</th>
          <th>{sortheading field=pdga id=users_pdga sortType=integer}</th>
          <th>{sortheading field=Username id=users_id sortType=alphabetical}</th>
          
          <th>{sortheading field=1 id=users_eventfees sortType=checkboxchecked}</th>
          <th>{sortheading field=1 id=eventfee_remind sortType=checkboxchecked}</th>
          <th>{sortheading field=1 id=date sortType=date}</th>          
       </tr>
        
       {assign var='i' value=1}     
       {foreach from=$users item=user}
          {assign var=userid value=$user.user->id}
          {assign var=partid value=$user.participationId}
         <tr>
            <td>{$i++}</td>
            <td><a href="{url page="user" id="$userid"}">{$user.user->lastname|escape}</a></td>
            <td><a href="{url page="user" id="$userid"}">{$user.user->firstname|escape}</a></td>
            
             <td>{$user.player->pdga|escape}</td>
             <td><a href="{url page="user" id="$userid"}">{$user.user->username|escape}</a></td>
             
             <td>
                <input type="hidden" name="oldfee_{$userid}_{$partid}" value="{$user.eventFeePaid}" />
                <input type="checkbox" class="payment" name="newfee_{$userid}_{$partid}" {if $user.eventFeePaid !== null}checked="checked"{/if} />
                {translate id=fee}
             </td>
            <td>
                <input type="checkbox" {if $user.eventFeePaid !== null}disabled="disabled"{/if} class="remind" name="remind_{$userid}" />
                {translate id=remind}
            </td>
            <td>
                {if $user.eventFeePaid !== null}
                 {assign var='paid' value=$paid+1}   
                    <input type="hidden" value="{$user.eventFeePaid}" />
                    {capture assign=date}{$user.eventFeePaid|date_format:"%d.%m.%Y"}{/capture}
                    {translate id=payment_date date=$date}
                {else}
                {assign var='not_paid' value=$not_paid+1}   
                <input type="hidden" value="{$user.signupTimestamp}" />
                    {capture assign=date}{$user.signupTimestamp|date_format:"%d.%m.%Y %H:%M"}{/capture}
                    {translate id=signup_date date=$date}
                    
                {/if}
             </td>
         </tr>
       {/foreach}     
    </table>
    <p><input class="all" type="checkbox" name="remind_all" /> {translate id=remind_all}</p>
    <p style="clear: both;">
        <input type="submit" value="{translate id=form_save}" />
        <input name="cancel" type="submit" value="{translate id=form_cancel}" />
    </p>
</form>
<div class="SearchStatus" />
<p>Maksettu: {$paid} / {$paid+$not_paid}</p>


<script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
    TableSearch(document.getElementById('searchField'), document.getElementById('userTable'),
                {/literal}"{translate id=No_Search_Results}"{literal}
                );   
    $($(".SortHeading").get(0)).click();
    $("#toggle_submenu").click(toggleSubmenu);
    
    SortDoneCallback = attachInputEvents;
    attachInputEvents();
    
    $(".all").click(synchAll)
    
});

function synchAll() {
    var c = this.checked;
    $(".all").each(function() {
        this.checked = c;
    });
}

function attachInputEvents() {
    $(".payment").click(adjustRemind)
}

function adjustRemind() {
    var remind = $(this).parent().next("td").find(".remind").get(0);
    
    if (this.checked) {
        remind.disabled = true;
        remind.checked = false;
    } else {
        remind.disabled = false;
    }
}

function toggleSubmenu() {
    $("#submenucontainer").toggle();
}


{/literal}


//]]>
</script>

{include file='include/footer.tpl' noad=true}
