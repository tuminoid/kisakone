{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Set event registration rules
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

{translate id='eventtaxes_title' assign='title'}
{include file='include/header.tpl' ui=1 tooltip=1 autocomplete=1}

{if $error}
    <p class="error">{$error}</p>
{/if}

<h2>{translate id=event_taxes_help_title}</h2>

<div class="error">
    <p>{translate id=event_taxes_help}</p>
    <p>{translate id=event_foreign_taxes_help}</p>
    <p>{translate id=event_notaxes_help}</p>
    <p>{translate id=event_taxes_dev_help}</p>
</div>

<h2>{translate id=event_winners}</h2>

<form method="post">
    <input type="hidden" name="formid" value="edit_taxes" />
    <input type="hidden" name="id" value="{$smarty.get.id}" />

    <table class="narrow">
    <thead>
        <tr>
            <th>{translate id=name}</th>
            <th><abbr title="{translate id=event_proprize_help}">{translate id=event_proprize}</abbr></th>
            <th><abbr title="{translate id=event_amprize_help}">{translate id=event_amprize}</abbr></th>
            <th><abbr title="{translate id=event_otherprize_help}">{translate id=event_otherprize}</abbr></th>
        </tr>
    </thead>
    <tbody>
    {foreach from=$player_data item=player}
        {assign var=taxes value=$player->GetEventTax($smarty.get.id)}
        <tr>
            <td>
                <input type="hidden" name="player[{$player->id}][]" value="{$player->id}" />
                {$player->lastname|escape}, {$player->firstname|escape}
            </td>
            <td>
                <input type="numeric" name="player[{$player->id}][]" value="{$taxes.ProPrize}" />
            </td>
            <td>
                <input type="numeric" name="player[{$player->id}][]" value="{$taxes.AmPrize}" />
            </td>
            <td>
                <input type="numeric" name="player[{$player->id}][]" value="{$taxes.OtherPrize}" />
            </td>
        </tr>
    {/foreach}
    </tbody>
    </table>

    <input type="submit" name="save" value="{translate id=save}" />
</form>

{include file='include/footer.tpl' noad=true}
