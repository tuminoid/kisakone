{**
 * Suomen Frisbeeliitto Kisakone
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
{translate id='classquotas_title' assign='title'}
{include file='include/header.tpl' }
{if $error}
<p class="error">{$error}</p>
{/if}

{include file=support/eventlockhelper.tpl}

<h2>{translate id=class_list}</h2>
<form method="post">
  <input type="hidden" name="formid" value="event_quotas" />
  <table id="classLimitTable">
    <tr>
      <th>{translate id=event_classes}</th>
      <th>{translate id=class_minquota}</th>
      <th>{translate id=class_maxquota}</th>
      <th>{translate id=class_registered_now}</th>
    </tr>
    {foreach from=$quotas item=quota}
    <tr>
      <td>{$quota.Name}</td>
      <td>
        <input type="hidden" name="init_{$quota.id}_minquota" value="{$quota.MinQuota}" />
        <input type="text" name="minquota_{$quota.id}" value="{$quota.MinQuota}" />
      </td>
      <td>
        <input type="hidden" name="init_{$quota.id}_maxquota" value="{$quota.MaxQuota}" />
        <input type="text" name="maxquota_{$quota.id}" value="{$quota.MaxQuota}" />
      </td>
      <td>
        {$counts[$quota.id]|default:"0"}
      </td>
    </tr>
    {/foreach}
  </table>

  <p style="clear: both;">
    <input type="submit" value="{translate id=form_save}" />
    <input name="cancel" type="submit" value="{translate id=form_cancel}" />
  </p>
</form>


{include file='include/footer.tpl' noad=true}
