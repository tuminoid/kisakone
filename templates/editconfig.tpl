{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Configuration interface
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

{translate assign=title id=config_title}
{include file='include/header.tpl'}

<h2>{translate id=config_title}</h2>

{if $error}
    <p class="error">{translate id=FormError_Summary}</p>
{/if}

<form method="post">
    <input name="formid" type="hidden" value="edit_config" />

{foreach from=$configs item=group key=title}
<h2>{translate id=$title}</h2>

<table class="narrow">
    <tr>
        <th>{translate id=config_translation}</th>
        <th>{translate id=config_value}</th>
    </tr>
    {foreach from=$group item=config}
    <tr>
        <td style="width: 300px;">
            <label for="{$config[0]}">{translate id=$config[0]}</label>
        </td>
        <td>
        {if $config[1] == "bool"}
            {html_options name="$config[0]" options=$bool_options selected="$config[2]"}
        {elseif $config[1] == "string"}
            <input type="text" name="{$config[0]}" value="{$config[2]}" />
        {elseif $config[1] == "int"}
            <input type="numeric" name="{$config[0]}" value="{$config[2]}" />
        {elseif $config[1] == "enum"}
            <select name="{$config[0]}">
            {foreach from=$config[3] item=enum}
                <option value="{$enum}" {if $enum == $config[2]}selected{/if}>{translate id=$config[0]_$enum}</option>
            {/foreach}
            </select>
        {else}
            Unknown config: {$config[0]}
        {/if}
        {formerror field="$config[0]"}
        </td>
    </tr>
    {/foreach}
</table>
{/foreach}

<br />

<input type="submit" name="submit" value="{translate id=form_save}" />

</form>

{include file='include/footer.tpl' noad=1}
