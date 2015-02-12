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

{translate id='eventrules_title' assign='title'}
{include file='include/header.tpl' ui=1 tooltip=1 autocomplete=1 timepicker=1}

{if $error}
    <p class="error">{$error}</p>
{/if}

<h2>{translate id=event_registration_rules}</h2>

<p>{translate id=rule_header_text}</p>

<form method="post">
    <input type="hidden" name="formid" value="event_rules" />
    <input type="hidden" name="eventid" value="{$event->id}" />

    {foreach from=$classes item=class name=classes}
        <h2>{$class->name}</h2>
        <table id="ruletable_{$class->id}">
            <tr>
                <th>{translate id=ruletype_header}</th>
                <th>{translate id=ruleop_header}</th>
                <th>{translate id=rulevalue_header}</th>
                <th>{translate id=ruleuntil_header}</th>
                <th>{translate id=ruleoption_header}</th>
                <th><a href="#" id="newrule_{$class->id}" onclick="return newrule({$class->id});">{translate id=rule_new}</a></th>
            </tr>
        {foreach from=$class->getRules($event->id) item=rule}
            <tr>
                <td>
                    <select name="ruletype_{$rule.id}" id="ruletype_{$rule.id}">
                    {foreach from=$ruletypes item=ruletype}
                        <option value="{$ruletype}" {if $rule.Type == $ruletype}selected="selected"{/if}>{translate id=ruletype_$ruletype}</option>
                    {/foreach}
                    </select>
                </td>
                <td>
                    <select name="ruleop_{$rule.id}" id="ruleop_{$rule.id}">
                    {foreach from=$ruleops item=ruleop}
                        <option value="{$ruleop}" {if $rule.Op == $ruleop}selected="selected"{/if}>{translate id=ruleop_$ruleop}</option>
                    {/foreach}
                    </select>
                </td>
                <td>
                    <input name="rulevalue_{$rule.id}" id="ruletype_{$rule.id}" type="text" value="{$rule.Value}" maxlength="6" length="6" />
                </td>
                <td>
                    <input class="useDatePicker" name="rulevaliduntil_{$rule.id}" id="rulevaliduntil_{$rule.id}" type="text" value="{$rule.ValidUntil}" />
                </td>
                <td>
                    <select name="ruleaction_{$rule.id}" id="ruleaction_{$rule.id}">
                    {foreach from=$ruleactions item=ruleaction}
                        <option value="{$ruleaction}" {if $rule.Action == $ruleaction}selected="selected"{/if}>{translate id=ruleaction_$ruleaction}</option>
                    {/foreach}
                    </select>
                </td>
                <td>
                    <a id="delete" href="#" onclick="return disablerule(this)">{translate id=rule_delete}</a>
                    <a id="restore" href="#" onclick="return enablerule(this)" style="display: none;">{translate id=rule_restore}</a>
                    <input name="ruleclass_{$rule.id}" id="ruleclass_{$rule.id}" type="hidden" value="{$class->id}" />
                </td>
            </tr>
        {foreachelse}
            <tr id="norule_{$class->id}"><td>{translate id=rule_no_rules}</td></tr>
        {/foreach}
        </table>
    {foreachelse}
        <p>{translate id=rule_no_classes}</p>
    {/foreach}

    <hr />

    <input type="submit" name="submit" value="Tallenna" />
</form>

<script type="text/javascript">
//<![CDATA[
{literal}

var newcount = 1000;

$(document).ready(function() {
    $(".useDatePicker").datetimepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        {/literal}
        dayNames: [{translate id=DayNameArray}],
        dayNamesShort: [{translate id=DayNameShortArray}],
        dayNamesMin: [{translate id=DayNameMinArray}],
        monthNames: [{translate id=MonthNameArray}],
        monthNamesShort: [{translate id=MonthNameShortArray}],
        {literal}
        firstDay: 1
    });
});

function applyDateTimePicker(element)
{
    element.datetimepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        {/literal}
        dayNames: [{translate id=DayNameArray}],
        dayNamesShort: [{translate id=DayNameShortArray}],
        dayNamesMin: [{translate id=DayNameMinArray}],
        monthNames: [{translate id=MonthNameArray}],
        monthNamesShort: [{translate id=MonthNameShortArray}],
        {literal}
        firstDay: 1
    });
    element.addClass("useDatePicker");
}

function newrule(classid)
{
    $('#norule_' + classid).hide();

    clonerow = $('#rule_stub tr:first-child').clone();
    clonerow.find('td:nth-child(1) select')
        .attr('name', 'ruletype_' + newcount + '_new')
        .attr('id', 'ruletype_' + newcount + '_new');
    clonerow.find('td:nth-child(2) select')
        .attr('name', 'ruleop_' + newcount + '_new')
        .attr('id', 'ruleop_' + newcount + '_new');
    clonerow.find('td:nth-child(3) input')
        .attr('name', 'rulevalue_' + newcount + '_new')
        .attr('id', 'rulevalue_' + newcount + '_new');
    applyDateTimePicker(
        clonerow.find('td:nth-child(4) input')
            .attr('name', 'rulevaliduntil_' + newcount + '_new')
            .attr('id', 'rulevaliduntil_' + newcount + '_new')
    );
    clonerow.find('td:nth-child(5) select')
        .attr('name', 'ruleaction_' + newcount + '_new')
        .attr('id', 'ruleaction_' + newcount + '_new');
    clonerow.find('td:nth-child(6) input')
        .attr('name', 'ruleclass_' + newcount + '_new')
        .attr('id', 'ruleclass_' + newcount + '_new')
        .attr('value', classid);
    $('#ruletable_' + classid).append(clonerow);

    newcount++;
    return false;
}

function disablerule(element)
{
    $(element).css('display', 'none');
    tr = $(element).parent().parent();
    tr.find('input, select').prop('disabled', true);
    tr.find('#restore').css('display', 'block');
    return false;
}

function enablerule(element)
{
    $(element).css('display', 'none');
    tr = $(element).parent().parent();
    tr.find('input, select').prop('disabled', false);
    tr.find('#delete').css('display', 'block');
    return false;
}

{/literal}
//]]>
</script>


<table id="rule_stub" style="display: none;">
<tr>
    <td>
        <select id="ruletype_new">
        {foreach from=$ruletypes item=ruletype}
            <option value="{$ruletype}">{translate id=ruletype_$ruletype}</option>
        {/foreach}
        </select>
    </td>
    <td>
        <select id="ruleop_new">
        {foreach from=$ruleops item=ruleop}
            <option value="{$ruleop}">{translate id=ruleop_$ruleop}</option>
        {/foreach}
        </select>
    </td>
    <td>
        <input id="ruletype_new" type="text" maxlength="6" length="6" />
    </td>
    <td>
        <input id="rulevaliduntil_new" type="text" />
    </td>
    <td>
        <select id="ruleaction_new">
        {foreach from=$ruleactions item=ruleaction}
            <option value="{$ruleaction}">{translate id=ruleaction_$ruleaction}</option>
        {/foreach}
        </select>
    </td>
    <td>
        <a id="delete" href="#" onclick="return disablerule(this)">{translate id=rule_delete}</a>
        <a id="enable" href="#" onclick="return enablerule(this)" style="display: none;">{translate id=rule_restore}</a>
        <input id="ruleclass_new" type="hidden" />
    </td>
</tr>
</table>

{include file='include/footer.tpl' noad=true}
