{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2018 Tuomo Tanskanen <tuomo@tanskanen.org>
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
      {if $pdga_country and $pdga_country != 'FI'}
         <td>{translate id=user_country}:</td>
         <td>{if $pdga_state}{$pdga_state}, {/if}{$pdga_country}</td>
      {elseif $suomisport_enabled}
         <td>{translate id=user_club}:</td>
         <td>{$suomisport_club_name} ({$suomisport_club_shortname})</td>
      {elseif $sfl_enabled}
         <td>{translate id=user_club}:</td>
         <td>{$data.club_name|escape} {if $data.club_short} ({$data.club_short}) {else} {translate id=user_no_club} {/if}</td>
      {/if}
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

{if ($itsme || $isadmin) && $player}
   {if $suomisport_enabled}
      <h2>{translate id=user_licenses_title}</h2>

      <table style="width:500px">
      {include file='include/suomisportinfotable.tpl'}
      </table>

   {elseif $sfl_enabled}
      <h2>{translate id=user_licenses_title}</h2>

      {if $sfl_enabled and !$data}
         {if !$pdga_enabled or $pdga_country == 'FI'}
         <p class="error">{translate id=check_registry_data}</p>
         {/if}
      {/if}

      <table style="width:500px">
      {if $licenses}
         <tr>
            <td style="width: 200px">{translate id=user_membershipfee}: </td>
            <td>
               {foreach from=$licenses.membership key=year item=paid}
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
               {foreach from=$licenses.license key=year item=paid}
                  {if $paid}
                     {assign var=license_paid value=true}
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
{/if}

{if $pdga_enabled}
   {if $player && $player->pdga}
      <h2>{translate id=user_pdga_title}</h2>

      <table style="width:335px">
      {include file='include/pdgainfotable.tpl'}
      </table>
   {/if}
{/if}

{if $isadmin}
<h2>{translate id=admin_user_options}</h2>



{if $emailverification_enabled}
<form method="post">
    <input type="hidden" name="formid" value="email_verification" />
    <input type="hidden" name="email" value="{$email}" />
    <input type="hidden" name="token" value="{$emailverification_token}" />
    <input type="hidden" name="email_user" value="{$email_user}" />

    <input type="submit" value="{translate id=admin_verify_user_email}" {if $emailverified}disabled="disabled"{/if} />
</form>
{/if}

{/if}

{include file='include/footer.tpl'}
