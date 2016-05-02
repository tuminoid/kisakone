{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Competitor queue listing
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

<form method="get" class="usersform" action="{url page=event view=queue id=$smarty.get.id}">
    {initializeGetFormFields  search=false }
    <div class="formelements">
         <p>{translate id=users_searchhint}</p>
        <input id="searchField" type="text" size="30" name="search" value="{$smarty.get.search|escape}" />
        <input type="submit" value="{translate id=users_search}" />
    </div>
</form>
<hr style="clear: both;" />

<p>
    <strong>{translate id=event_queue_lift}:</strong> {translate id=event_queue_$strategy}
</p>

<div class="SearchStatus" />
<table class="narrow" style="min-width: 400px">
   <tr>
      <th>{sortheading field=1 id=num sortType=integer}</th>
      <th>{sortheading field=LastName id=lastname sortType=alphabetical}</th>
      <th>{sortheading field=FirstName id=firstname sortType=alphabetical}</th>
      {if $sfl_enabled}<th>{sortheading field=ClubName id=clubname sortType=alphabetical}</th>{/if}
      <th>{sortheading field=ClassName id=class sortType=alphabetical}</th>
      <th>{sortheading field=pdga id=users_pdga sortType=integer}</th>
      {if $pdga_enabled}<th>{sortheading field=Rating id=pdga_rating sortType=integer}</th>{/if}
   </tr>
   {foreach from=$queue item=participant name=osallistuja}
   <tr>
      <td>{$smarty.foreach.osallistuja.index+1}</td>
      <td>
        {if $participant.user->username}<a href="{url page=user id=$participant.user->username}">{/if}
        {$participant.user->lastname|escape}
        {if $participant.user->username}</a>{/if}
      </td>
      <td>
        {if $participant.user->username}<a href="{url page=user id=$participant.user->username}">{/if}
        {$participant.user->firstname|escape}
        {if $participant.user->username}</a>{/if}
      </td>
      {if $sfl_enabled}
      <td><abbr title="{$participant.clubLongName|escape}">{$participant.clubName|escape}</abbr></td>
      {/if}
      <td><abbr title="{$participant.className|escape}">{$participant.classShort|escape}</abbr></td>
      <td>{$participant.player->pdga|escape}</td>
      {if $pdga_enabled}<td>{$participant.rating|escape}</td>{/if}
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

{/if}
