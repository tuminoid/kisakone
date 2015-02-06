{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * User details page
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

<h2>{translate id=user_header user=$userinfo->username|escape}</h2>

<table style="width:500px">
   <tr>
      <td style="width: 200px">{translate id=user_name}: </td>
      <td>{$userinfo->fullname|escape}</td>
   </tr>
   {if $player}
      <tr>
         <td>{translate id=user_gender}: </td>
         <td>{capture assign=gendertoken}gender_{$player->gender}{/capture}
         {translate id=$gendertoken}</td>
      </tr>
      <tr>
         <td>{translate id=user_pdga_number}:</td>
         <td>{$player->pdga|escape}</td>
      </tr>
      <tr>
         <td>{translate id=user_club}:</td>
         <td>{$data.club_name|escape} ({$data.club_short})</td>
      </tr>
      <tr>
         <td>{translate id=user_yearofbirth}: </td>
         <td>{$player->birthyear|escape}</td>
      </tr>
   {else}
      <tr><td colspan="2">
         {translate id=user_not_player}
      </td></tr>
   {/if}
</table>

{if ($itsme || $isadmin) && $player }
   <h2>{translate id=user_licenses_title}</h2>
   <table style="width:500px">
   {if $fees}
      <tr>
         <td style="width: 200px">{translate id=user_membershipfee}: </td>
         <td>
            {foreach from=$fees.membership key=year item=paid}
               {if $paid}
                  {$year} {translate id=user_ispaid}
               {else}
                  {$year} {translate id=user_notpaid}
               {/if}
               <br />
            {/foreach}
         </td>
      </tr>
      <tr>
         <td >{translate id=user_alicensefee}: </td>
         <td>
            {foreach from=$fees.aLicense key=year item=paid}
               {if $paid}
                  {assign var=alicense_paid value=true}
                  {$year} {translate id=user_ispaid}
               {else}
                  {$year} {translate id=user_notpaid}
               {/if}
               <br />
            {/foreach}
         </td>
      </tr>
      <tr>
         <td >{translate id=user_blicensefee}: </td>
         <td>
            {foreach from=$fees.bLicense key=year item=paid}
               {if $alicense_paid}
                  {$year} {translate id=user_alicense_paid}
               {elseif $paid}
                  {$year} {translate id=user_ispaid}
               {else}
                  {$year} {translate id=user_notpaid}
               {/if}
               <br />
            {/foreach}
         </td>
      </tr>
   {/if}
   </table>
{/if}

{if $player && $player->pdga}
<h2>{translate id=user_pdga_title}</h2>

<table style="width:500px">
<tr>
   <td style="width: 200px"><label for="membership">{translate id='pdga_membership'}:</label></td>
   <td><span name="membership">{translate id=pdga_membership_$pdga_membership_status} {if $pdga_membership_status != "current"}{$pdga_membership_expiration_date}{/if}</span></td>
</tr>
<tr>
   <td><label for="official">{translate id='pdga_official'}:</label></td>
   <td><span name="official">{translate id=pdga_official_$pdga_official_status}</span></td>
</tr>
<tr>
   <td><label for="rating">{translate id='pdga_rating'}:</label></td>
   <td><span name="rating">{$pdga_rating}</span></td>
</tr>
<tr>
   <td><label for="status">{translate id='pdga_status'}:</label></td>
   <td><span name="status">{$pdga_classification}</span></td>
</tr>
<tr>
   <td><label for="status">{translate id='pdga_country'}:</label></td>
   <td><span name="status">{$pdga_country}</span></td>
</tr>
</table>

<p><a href="http://www.pdga.com/player/{$player->pdga}">{translate id=user_pdga_link}</a></p>
{/if}

{include file='include/footer.tpl'}
