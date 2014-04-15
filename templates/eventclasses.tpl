{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Move players from one class to another within an event
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
{if $error}
<p class="error">{$error}</p>
{/if}

{include file=support/eventlockhelper.tpl}

<p><button id="toggle_submenu">{translate id=toggle_menu}</button></p>

<h2>{translate id=player_list}</h2>

<form method="get" class="usersform searcharea" action="{url page=eventclasses id=$smarty.get.id}">
    {initializeGetFormFields  search=false}
    <div class="formelements">
         <p>{translate id=users_searchhint} </p>
        <input id="searchField" type="text" size="30" name="search" value="{$smarty.get.search|escape}" />
        <input type="submit" value="{translate id=users_search}" />
    </div>
    <br style="clear: both" />
</form>


<div class="SearchStatus" />
<form method="post">
    <p style="clear: both;"><input type="submit" value="{translate id=form_save}" />
        <input name="cancel" type="submit" value="{translate id=form_cancel}" /></p>

    <input type="hidden" name="formid" value="event_classes" />
    <table id="userTable" class="hilightrows oddrows">
       <tr>
          <th>{sortheading field=LastName id=lastname sortType=alphabetical}</th>
          <th>{sortheading field=FirstName id=firstname sortType=alphabetical}</th>
          <th>{sortheading field=pdga id=users_pdga sortType=integer}</th>
          <th>{sortheading field=birthyear id=birthyear sortType=integer}</th>
          <th>{sortheading field=gender id=gender sortType=alphabetical}</th>
          <th>{sortheading field=class id=class sortType=selectText}</th>


       </tr>


       {foreach from=$users item=user}
          {assign var=userid value=$user.user->id}
          {assign var=partid value=$user.participationId}
         <tr>
            <td><a href="{url page="user" id="$userid"}">{$user.user->lastname|escape}</a></td>
            <td><a href="{url page="user" id="$userid"}">{$user.user->firstname|escape}</a></td>

             <td>{$user.player->pdga|escape}</td>
             <td>{$user.player->birthyear}</td>
             <td>{if $user.player->gender == 'M'}{translate id=male}{else}{translate id=female}{/if}</td>
             <td>
                <input type="hidden" name="init_{$user.player->id}" value="{$user.classId}" />
                <select name="class_{$user.player->id}"
                {assign var=userclass value=$user.classId}
                {if $badClasses.$userclass}
                        class="bad_class"
                        {/if}
                >
                    {foreach from=$classes item=class}
                    {assign var=cid value=$class->id}
                    {if !$badClasses.$cid}
                        <option value="{$class->id}" {if $user.classId == $class->id}selected="selected"{/if}>
                        {$class->name}
                        </option>
                    {elseif $class->id == $user.classId}
                     <option value="{$class->id}" {if $user.classId == $class->id}selected="selected"{/if} class="bad_class">
                        {$class->name}
                        </option>
                    {/if}
                    {/foreach}
                    <option disabled="disabled">---------</option>
                    <option style="background-color: #FCC;" value="removeplayer">{translate id=remove_player_from_event}</option>
                </select>

             </td>

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
    $("#toggle_submenu").click(toggleSubmenu);






});




function toggleSubmenu() {
    $("#submenucontainer").toggle();
}


{/literal}


//]]>
</script>

{include file='include/footer.tpl' noad=true}
