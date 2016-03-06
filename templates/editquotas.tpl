{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Set and show quotas (player limits) for events
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
{include file='include/header.tpl' ui=1 tooltip=1}
{if $error}
<p class="error">{$error}</p>
{/if}

{assign var="min" value="0"}
{assign var="max" value="0"}
{assign var="reg" value="0"}
{assign var="que" value="0"}
{assign var="fre" value="0"}

<form method="post">
<input type="hidden" name="formid" value="event_quotas" />

<h2>{translate id=event_playerlimit}</h2>

  <p style="clear: both;">
    {translate id=event_playerlimit_text}: {$playerlimit}
  </p>

<h2>{translate id=event_queuestrategy}</h2>

  <p style="clear: both;">
    <label for="strategy">{translate id=event_queuestrategy}:</label>
    <select name="strategy" id="strategy">
    {foreach from=$strategies item=strategy}
      <option value="{$strategy}" {if $oldstrategy == $strategy}selected="selected"{/if}>{translate id="promotionstrategy_$strategy"}</option>
    {/foreach}
    </select>
  </p>

<h2>{translate id=class_list}</h2>

  <table id="classLimitTable">
    <tr>
      <th>{translate id=class}</th>
      <th><a href="#" title="{translate id=quota_help_reserved}">{translate id=class_minquota}</a></th>
      <th><a href="#" title="{translate id=quota_help_maximum}">{translate id=class_maxquota}</a></th>
      <th><a href="#" title="{translate id=quota_help_registered}">{translate id=class_registered_now}</a></th>
      <th><a href="#" title="{translate id=quota_help_queued}">{translate id=class_queued_now}</a></th>
      <th><a href="#" title="{translate id=quota_help_freequota}">{translate id=class_quota_free}</a></th>
    </tr>

    {foreach from=$quotas item=quota}
      {assign var="count" value=$counts[$quota.id]|default:0}
      {assign var="queue" value=$queues[$quota.id]|default:0}
      {math assign="free" equation="x - y" x=$quota.MinQuota y=$count}
      {if $free <= 0} {assign var="free" value="0"} {/if}

      {math assign="min" equation="x + y" x=$min y=$quota.MinQuota}
      {math assign="max" equation="x + y" x=$max y=$quota.MaxQuota}
      {math assign="reg" equation="x + y" x=$reg y=$count}
      {math assign="que" equation="x + y" x=$que y=$queue}
      {math assign="fre" equation="x + y" x=$fre y=$free}

    <tr>
      <td>{$quota.Short} ({$quota.Name})</td>
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
      <td>
        {$queues[$quota.id]|default:"0"}
      </td>
      <td>{$free}</td>
    </tr>
    {/foreach}

    <tr>
      <th>{translate id=total}</th>
      <th>{$min}</th>
      <th>{if $max >= 999}-{else}{$max}{/if}</th>
      <th>{$reg}</th>
      <th>{$que}</th>
      <th>{$fre}</th>
    </tr>
  </table>

  {if $playerlimit > 0 && $min > $playerlimit}
  <p style="clear: both;" class="error">
    {translate id="class_quota_invalid"}
  </p>
  {/if}

  <p style="clear: both;">
    <input type="submit" value="{translate id=form_save}" />
  </p>
</form>

<h2>{translate id=faq}</h2>

<h3>{translate id=quota_help_basics_title}</h3>
<p>{translate id=quota_help_basics}</p>

<h3>{translate id=quota_help_promotion_title}</h3>
<p>{translate id=quota_help_promotion}</p>

<h3>{translate id=quota_help_wildcard_title}</h3>
<p>{translate id=quota_help_wildcard}</p>

<h3>{translate id=quota_help_pool_title}</h3>
<p>{translate id=quota_help_pool}</p>

<h3>{translate id=quota_help_promotionlock_title}</h3>
<p>{translate id=quota_help_promotionlock}</p>

<h3>{translate id=quota_help_promoting_title}</h3>
<p>{translate id=quota_help_promoting}</p>

<h3>{translate id=quota_help_who_title}</h3>
<p>{translate id=quota_help_who}</p>

{include file='include/footer.tpl' noad=true}
