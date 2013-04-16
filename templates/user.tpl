{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010,2013 Kisakone projektiryhmä
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

<h3>{translate id=user_header user=$userinfo->username|escape}</h3>

<hr />

<table style="width:300px">
   <tr>
      <td >{translate id=user_name}: </td>
      <td>{$userinfo->fullname|escape}</td>
   </tr>
   {if $player}
      <tr>
         <td >{translate id=user_gender}: </td>
         <td>{capture assign=gendertoken}gender_{$player->gender}{/capture}
         {translate id=$gendertoken}</td>
      </tr>
      <tr>
         <td >{translate id=user_pdga_number}: </td>
         <td>{$player->pdga|escape}</td>
      </tr>
      {if $itsme || $isadmin}
      <tr>
         <td >{translate id=user_yearofbirth}: </td>
         <td>{$player->birthyear|escape}</td>
      </tr>
      {/if}
      {else}
         <tr><td colspan="2">
         {translate id=user_not_player}
         </td></tr>
      {/if}
</table>

{if $player && $player->pdga}
<p><a href="http://www.pdga.com/player-stats?PDGANum={$player->pdga}">{translate id=user_pdga_link}</a></p>
{/if}

{if ($itsme || $isadmin) && $player }
   <hr />
      <table style="width:300px">

         {if $fees}
            <tr>
               <td >{translate id=user_membershipfee}: </td>
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
                     {if $paid}
                        {$year} {translate id=user_ispaid}
                     {else}
                        {$year} {translate id=user_notpaid}
                     {/if}
                     <br />
                  {/foreach}

               </td>
            </tr>
{*
         {else}
            <tr>
               <td >{translate id=user_membershipfee}: </td>
               <td>
                  {foreach from=$player->membershipfeespaid() key=year item=paid}
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
               <td >{translate id=user_licensefee}: </td>
               <td>
                  {foreach from=$player->licensefeespaid() key=year item=paid}
                     {if $paid}
                        {$year} {translate id=user_ispaid}
                     {else}
                        {$year} {translate id=user_notpaid}
                     {/if}
                     <br />
                  {/foreach}

               </td>
            </tr>
*}
         {/if}

      </table>
{/if}

{include file='include/footer.tpl'}
