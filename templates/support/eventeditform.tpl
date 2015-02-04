{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Event creation and editing form
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
 {capture assign=extrahead}
 <style type="text/css">{literal}
.narrow_selects select { min-width: 0; }
{/literal}</style>
{/capture}
{if $new}
{translate id='newevent_title' assign='title'}
{else}
{translate id='editevent_title' assign='title'}
{/if}
{include file='include/header.tpl' autocomplete=1 ui=1 timepicker=1}

{translate id='year_default' assign='year_default'}
{translate id='month_default' assign='month_default'}
{translate id='day_default' assign='day_default'}

<div class="nojs">
{translate id=page_requires_javascript}
</div>

<form method="post" class="evenform jsonly" id="eventform">
    <h2>{if $new}
    {translate id='newevent_title'}
        <input type="hidden" name="formid" value="new_event" />
    {else}
        {translate id='editevent_title'}
        <input type="hidden" name="formid" value="edit_event" />
        <input type="hidden" name="eventid" value="{$event.id}" />
    {/if}</h2>

    <div>
        <label for="name">{translate id=event_name}</label>
        <input id="name" type="text" name="name" value="{$event.name|escape}" />
        {formerror field='name'}
    </div>
    <div>

        <label for="venueField">{translate id=event_venue}</label>
        <input type="text" name="venue" id="venueField" value="{$event.venue|escape}" />
        {formerror field='venue'}
    </div>

    <div>
        <label for="tournament">{translate id=event_tournament}</label>
        <select id="tournament" name="tournament">
            <option value="" {if !$event.tournament}selected="true"{/if}>{translate id=select_none}</option>
            {html_options options=$tournament_options selected=$event.tournament}
        </select>
        {formerror field='tournament'}
    </div>

    <div>
        <label for="level">{translate id=event_level}</label>
        <select id="level" name="level">
            <option value="" selected="true">{translate id=select_none}</option>
            {html_options options=$level_options selected=$event.level}
        </select>
        {formerror field='level'}
    </div>

    <div>
        <label for="start">{translate id=event_start}</label>
        <input type="text" name="start" value="{$event.start|escape}" id="start" class="useDatePicker" />
        {formerror field='start'}
    </div>

    <div>
        <label for="duration">{translate id=event_duration}</label>
        <input id="duration" type="text" name="duration" style="min-width: 64px;"  value="{$event.duration|escape}" />
        <span>{translate id=event_duration_days}</span>
        {formerror field='duration'}
    </div>

    <div>
        <label for="playerlimit">{translate id=event_playerlimit}</label>
        <input id="playerlimit" type="text" name="playerlimit" style="min-width: 64px;" value="{$event.playerlimit|escape}" />
        <span>{translate id=event_playerlimit_max}</span>
        {formerror field='playerlimit'}
    </div>

    <div>
        <label for="signup_start">{translate id=event_signup_start}</label>
        <input id="signup_start" type="text" name="signup_start" value="{$event.signup_start|escape}" />
        {formerror field='signup_start'}
    </div>

    <div>
        <label for="signup_end">{translate id=event_signup_end}</label>
        <input id="signup_end" type="text" name="signup_end" value="{$event.signup_end|escape}" />
        {formerror field='signup_end'}
    </div>

    <div>
        <label for="contact">{translate id=event_contact}</label>
        <input id="contact" type="text" name="contact" value="{$event.contact|escape}" />
        {formerror field='contact'}
    </div>

    <div>
        <input id="requireFees_member" type="checkbox" name="requireFees_member" {if $event.requireFees_member} checked="checked" {/if}/>
        <label class="checkboxlabel" for="requireFees_member">{translate id="event_require_member_fee"}</label>
        <br />
        <input id="requireFees_license_A" type="radio" name="requireFees_license" value="requireFees_license_A"  {if $event.requireFees_aLicense} checked="checked" {/if}/>
        <label class="checkboxlabel" for="requireFees_license_A" >{translate id="event_require_alicense_fee"}</label>
        <br />
        <input id="requireFees_license_B" type="radio" name="requireFees_license" value="requireFees_license_B"  {if $event.requireFees_bLicense} checked="checked" {/if} />
        <label class="checkboxlabel" for="requireFees_license_B">{translate id="event_require_blicense_fee"}</label>
        <br />
    </div>


    <h2>{translate id='event_classes'}</h2>
    <div>
        <label for="classList">{translate id=event_classes}</label>
        <select name="classList" id="classList">
            <option value="" selected="true">{translate id=select_none}</option>
            {html_options options=$class_options}
        </select>
        <button href="#" id="addClass">{translate id=event_add_class}</button>
        <button href="#" id="addAllClasses">{translate id=event_add_all_classes}</button>
        {formerror field='classList_'}
    </div>

    <ul class="editList" id="classListList">
    </ul>
    {formerror field='classes'}

    <h2>{translate id='event_rounds'}</h2>
    <div class="narrow_selects">
        <label for="roundStart">{translate id="round_start_time"}</label>

        <select name="roundStart" id="roundStart">
        </select>

        <span>{translate id="event_round_time"}</span>
        {html_select_time
            prefix=round_start time='12:0:0' display_seconds=false
            minute_interval=5}

        <button href="#" id="addRound">{translate id=event_add_round}</button>
        {formerror field='round'}
    </div>

    <ul class="editList" id="roundList">

    </ul>
    {formerror field='rounds'}

    <h2>{translate id='event_management'}</h2>
    <div>
        <label for="td">{translate id=event_td}</label>
        <input type="hidden" name="oldtd" value="{$event.oldtd|escape}" />
        {if $allowTdChange}
        <input type="text" name="td" id="td" value="{$event.td|escape}" />
        {else}
        <input type="hidden" name="td" id="td" value="{$event.td|escape}" />
        {$event.td|escape}
        {/if}
        {formerror field='td'}
    </div>

    <div>
        <label for="official">{translate id=event_official}</label>
        <input type="text" name="official" id="official" />
        <button href="#" id="addOfficial">{translate id=event_add_official}</button>
        {formerror field='official'}
    </div>

    <ul class="editList" id="officialList">
    </ul>

    <h2>{translate id='event_pdga'}</h2>
    <div>
        <label for="pdgaeventid">{translate id=event_pdga_id}</label>
        <input type="hidden" name="oldpdgaeventid" value="{$event.oldpdgaeventid|escape}" />
        <input type="text" name="pdgaeventid" id="pdgaeventid" value="{$event.pdgaeventid|escape}" />
        {formerror field='pdgaeventid'}
    </div>

    {if !$new}
        <h2>{translate id=event_state}</h2>
        <ul class="nobullets">
            <li><input type="radio" name="event_state" value="preliminary" {if $event.event_state == 'preliminary' || $event.event_state == ''}checked="checked"{/if} />
            {translate id=event_state_preliminary}</li>
            <li><input type="radio" name="event_state" value="active" {if $event.event_state == 'active'}checked="checked"{/if} />
            {translate id=event_state_active}</li>
            <li><input type="radio" name="event_state" value="done" {if $event.event_state == 'done'}checked="checked"{/if} />
            {translate id=event_state_done}</li>
        </ul>
    {/if}

    {formerror field='officials'}
    <div>
        <input type="submit" value="{translate id='form_save'}" name="save" />
        <input type="submit" id="cancelButton" value="{translate id='form_cancel'}" name="cancel" />
        {if $admin && !$new}
        <input type="submit" style="margin-left: 96px" id="deleteButton" value="{translate id='delete'}" name="delete" />
        {/if}
    </div>

</form>


<script type="text/javascript">
//<![CDATA[
var day_index = "{translate id=day_index}";

{literal}
$(document).ready(function(){
    CheckedFormField('eventform', 'name', NonEmptyField, null);
    CheckedFormField('eventform', 'venue', NonEmptyField, null);
    CheckedFormField('eventform', 'level', NonEmptyField, null);
    CheckedFormField('eventform', 'start', NonEmptyField, null, {delayed: true});
    CheckedFormField('eventform', 'duration', PositiveIntegerField, null);
    CheckedFormField('eventform', 'playerlimit', OneOrMoreIntegerField, null);
    CheckedFormField('eventform', 'td', NonEmptyField, null);
    CheckedFormField('eventform', 'td', AjaxField, 'validuser', {delayed: true});
    CheckedFormField('eventform', 'official', AlwaysEmptyField, null);
    CheckedFormField('eventform', 'classList', AlwaysEmptyField, null);


    $("#duration").change(durationChanged);
    $("#duration").change();

    $("#addAllClasses").click(addAllClasses);

    $("#cancelButton").click(CancelSubmit);


    var options, a;
    jQuery(function(){
    options = { serviceUrl: baseUrl,
        params: { path : 'autocomplete', id: 'venue' }};
    a = $('#venueField').autocomplete(options);


    $('#td').autocomplete(
      { serviceUrl: baseUrl,
        params: { path : 'autocomplete', id: 'users'}
      }
    );
    $('#official').autocomplete(
      { serviceUrl: baseUrl,
        params: { path : 'autocomplete', id: 'users'
      }}
    );

    $(".useDatePicker").datepicker({
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

    $("#signup_start").datetimepicker({
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

    $("#signup_end").datetimepicker({
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

    $('#addClass').click(addClass);
    $('#addRound').click(addRound);
    $('#addOfficial').click(addOfficial);


});

});

function durationChanged() {
    var days = parseInt(this.value);
    if (days < 1) days = 1;
    $("#roundStart").empty();
    var select = $("#roundStart").get(0);

    for (ind = 1; ind <= days; ++ind) {
        var option = document.createElement('option');
        option.value = ind;
        option.appendChild(document.createTextNode(day_index + ind));
        select.appendChild(option);

    }
}

function AlwaysEmptyField(field, arguments, initialize) {
    if (initialize) {
	field.blur(TestField);
    }
    else {


        if (!fullTest) return true;

	if (getvalue(field) == "") return true;


	{/literal}
	return "{translate id=FormError_ShouldBeEmpty escape=false}";
	{literal}
    }

}

var classes = new Array();

{/literal}
var class_already_in_use = "{translate id=class_already_in_use}";
var confirm_class_removal = "{translate id=confirm_class_removal}";
var remove_class_text = "{translate id=remove_class_text}";

var confirm_round_removal = "{translate id=confirm_round_removal}";
var invalid_round ="{translate id=invalid_round}";
var remove_round_text = "{translate id=remove_round_text}";
var holesText = "{translate id=holes}";

var confirm_official_removal = "{translate id=confirm_official_removal}";
var remove_official_text = "{translate id=remove_official_text}";

{literal}

function addAllClasses(e) {
    if (e) e.preventDefault();
    var options = $('#classList option');
    options.each(function() {
       var val = this.value;
       if (val == "") return;
       if (!classes[val]) {

            addClass(null, val);

       }
    });
    return false;
}

function addClass(event, id) {
    if (event) event.preventDefault();

    var select = document.getElementById('classList');
    if (!id) id = select.value;

    if (id == "") return false;

    if (classes[id]) {
        alert(class_already_in_use);
        return;
    }

    classes[id] = true;

    var hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'classOperations_' + getUniqueFieldId();
    hidden.value = 'add:' + id;

    select.parentNode.appendChild(hidden);


    var label = document.createElement('label');
    var text = document.createTextNode(GetSelectOptionText(select, id));
    label.appendChild(text);

    var link = document.createElement('button');


    text = document.createTextNode(remove_class_text);
    link.appendChild(text);

    var li = document.createElement('li');

    li.id = "class" + id;

    li.appendChild(label);
    li.appendChild(link);

    document.getElementById('classListList').appendChild(li);

     $(link).click(function(e){ removeClass(id); e.preventDefault(); });

    select.value = '';

}

function removeClass(id) {
    if (!confirm(confirm_class_removal)) return;
    var select = document.getElementById('classList');

    classes[id] = false;
    var hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'classOperations_' + getUniqueFieldId();
    hidden.value = 'remove:' + id;

    select.parentNode.appendChild(hidden);

    var li = $("#class" + id).get(0);
    li.parentNode.removeChild(li);
}

var roundIndex = 0;

function addRound(event, startDate, startTime, roundId) {
    if (!roundId) roundId = "*";
    if (event) event.preventDefault();

    var dateElement = document.getElementById('roundStart');
    var hourElement = $('select[name="round_startHour"]').get(0);
    var minuteElement = $('select[name="round_startMinute"]').get(0);



    if (!startDate) startDate = GetSelectText(dateElement);
    if (!startTime) {
        startTime = hourElement.value + ":" + minuteElement.value;
    }


    var hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'roundOperations_' + getUniqueFieldId();
    hidden.value = 'add:' + roundIndex + ":" + roundId + ":" + startDate + ":" + startTime;

    dateElement.parentNode.appendChild(hidden);


    var label = document.createElement('label');
    var text = document.createTextNode(startDate + ", " + startTime);
    label.appendChild(text);

    var link = document.createElement('button');

    link.href = '#';
    text = document.createTextNode(remove_round_text);
    link.appendChild(text);

    var li = document.createElement('li');

    li.id = "round" + roundIndex;

    li.appendChild(label);
    li.appendChild(link);

    document.getElementById('roundList').appendChild(li);
    var ri = roundIndex;
     $(link).click(function(e){ removeRound(ri); e.preventDefault(); });

    roundIndex++;


}

function removeRound(id) {
    if (!confirm(confirm_round_removal)) return;
    var select = document.getElementById('roundStart');

    classes[id] = false;
    var hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'roundOperations_' + getUniqueFieldId();
    hidden.value = 'remove:' + id;

    select.parentNode.appendChild(hidden);

    var li = $("#round" + id).get(0);
    li.parentNode.removeChild(li);
}

function addOfficial(event, text) {
    if (event) event.preventDefault();

    var select = document.getElementById('official');
    if (!text) text = select.value;
    if (text == "") {
        return;
    }


    var hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'officialOperations_' + getUniqueFieldId();
    hidden.value = 'add:' + text;

    select.parentNode.appendChild(hidden);

    var label = document.createElement('label');
    var text = document.createTextNode(text);
    label.appendChild(text);

    var link = document.createElement('button');

    link.href = '#';
    text = document.createTextNode(remove_official_text);
    link.appendChild(text);

    var li = document.createElement('li');


    li.appendChild(label);
    li.appendChild(link);

    document.getElementById('officialList').appendChild(li);

     $(link).click(function(e){ removeOfficial(label); e.preventDefault(); });

    select.value = '';

}

function removeOfficial(label) {
    if (!confirm(confirm_official_removal)) return;
    var select = document.getElementById('official');

    var hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'officialOperations_' + getUniqueFieldId();
    hidden.value = 'remove:' + $(label).text();

    select.parentNode.appendChild(hidden);

    label.parentNode.parentNode.removeChild(label.parentNode);
}


var lastUniqueFieldId = 0;
function getUniqueFieldId() {
    lastUniqueFieldId++;
    return lastUniqueFieldId;
}

{/literal}


$(document).ready(function(){ldelim}


    {foreach from=$event.classes item=class}
        addClass(null, {$class});
    {/foreach}

    {foreach from=$event.rounds item=round}
        addRound(null, "{$round.datestring|escape}", "{$round.time|escape}", '{$round.roundid|escape}');
    {/foreach}

    {foreach from=$event.officials item=official}
        addOfficial(null, "{$official|escape}");
    {/foreach}
{rdelim});

//]]>
</script>
{include file='include/footer.tpl' noad=1}
