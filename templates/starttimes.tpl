{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Section start time management
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
{translate id='starttimes_title' assign='title' }
{capture assign=extrahead}
<style type="text/css">
{literal}
    .groupman ul, .groupman li {
        margin: 0;
        padding: 0;
        list-style-type: none;
    }

    .groupman li {
        padding: 2px;
    }

    .beingDragged{
        background-color: #CCC;
    }

    .droponme {
        border: 2px solid blue;
    }

    .groupman td {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .groupman .toplist {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .innertable td {
        padding: 3px;
        min-height: 32px;
    }

    .grouplist {
        width: 400px;
        float: left;
    }

    .tagged {
        border: 2px solid green;
    }

    .taggedp {
        background-color: #FFA;
        font-weight: bold;
    }

    .subclass {
        background-color: #EEE;
        padding: 16px;
        margin: 8px;
        max-width: 400px;
    }

    h2 {
        clear: both;
    }
    {/literal}
</style>
{/capture}
{include file='include/header.tpl'  ui=1 }
{include file=support/eventlockhelper.tpl}

<div class="nojs">
    {translate id=page_requires_javascript}
</div>

<div class="jsonly">
    <p>{translate id=starttimes_help}</p>
    <p>{translate id=round_starts_at start=$startTime interval=$interval}</p>

<form method="post">
    <input type="hidden" name="formid" value="start_times" />

    <div  class="buttonarea">
        <input type="submit" value="{translate id=save}" />
        <input type="submit" name="cancel" value="{translate id=cancel}" />
    </div>

        {foreach from=$sections item=section}

            <div class="subclass cid{$section->id}" id="c_{$section->id}">
                {assign var=estimate value=$section->EstimateNumberOfGroups()}
                <span class="groups_in_class" style="display: none">{$estimate}</span>
                <input type="hidden" class="timeInput" name="time_{$section->id}" value="{$section->startTime|date_format:"%H:%M"}" />
                <h3>{$section->name|escape}</h3>
                <p>{translate id=start_time} <span class="timeText">{$section->startTime|date_format:"%H:%M"}</span>
                    <span class="timeType">{if $section->startTime}{translate id=forced}{else}{translate id=automatic}{/if}</span>
                    <button class="cs">{translate id=change_start_time}</button>
                </p>
                <p>{translate id=estimated_number_of_groups estimate=$estimate}</p>
                <input type="checkbox" class="presentCb" name="present_{$section->id}" {if $section->present}checked="checked"{/if} /> {translate id=class_present}
                <br />
                <div>
                    <button class="ea">{translate id=earlier}</button>
                    <button class="la">{translate id=later}</button>
                </div>
            </div>
        {/foreach}

<div class="forbiddenArea"></div>

<div class="buttonarea">
        <input type="submit" value="{translate id=save}" />
        <input type="submit" name="cancel" value="{translate id=cancel}" />
    </div>

</form>

<script type="text/javascript">
//<![CDATA[

var changeTimePrompt = "{translate id=change_time_prompt}";
var automaticText = "{translate id=automatic}";
var forcedText = "{translate id=forced}";
var invalidFormat = "{translate id=invalid_time}";

var notPresentText = "{translate id=section_not_present}";

var startTime = '{$startTime}';
var interval = {$interval};

{literal}
$("document").ready(function(){
  AttachHandlers($(".subclass"));
  RedoTimes();
});

function AttachHandlers(to) {
    to.find(".cs").click(changeStartTime);
    to.find(".ea").click(earlier);
    to.find(".la").click(later);
    to.find(".presentCb").click(RedoTimes);
}

function changeStartTime() {
    var div = this.parentNode.parentNode;
    var hidden = $(div).find(".timeInput").get(0);
    var typeSpan = $(div).find(".timeType").get(0);

    var evStart = prompt(changeTimePrompt, hidden.value);

    if (evStart == undefined)
        return false;

    if (evStart == "") {
        $(typeSpan).empty();
        typeSpan.appendChild(document.createTextNode(automaticText));
        hidden.value = "";
    }
    else {
        if (!(evStart.match(/\d\d?(:\d\d)/))) {
            alert(invalidFormat);
            return false;
        }

        $(typeSpan).empty();
        typeSpan.appendChild(document.createTextNode(forcedText));
        hidden.value = evStart;
    }

    RedoTimes();

    return false;
}

function earlier(){
    var theDiv = this.parentNode.parentNode;

    var before = $(theDiv).prev("div").get(0);
    if (before) {
        if (before.className == "buttonarea")
            return false;
        $(theDiv).remove();

        before.parentNode.insertBefore(theDiv, before);

        AttachHandlers($(theDiv));
    }

    RedoTimes();
    return false;
}

function later() {
    var theDiv = this.parentNode.parentNode;
    var before = $(theDiv).next("div").next("div").get(0);

    if (before) {
        //$(theDiv).next("div").remove();
        $(theDiv).remove();
        before.parentNode.insertBefore(theDiv, before);
        AttachHandlers($(theDiv));
    }

    RedoTimes();
    return false;
}

function RedoTimes() {
    // There's probably a better native way to do this as well, but due to time constraints
    // a straightforward manual approach was taken

    var now = startTime.split(':');
    var numGroupsInLast = 0;

    $(".subclass").each(function(){
        var hidden = $(this).find(".timeInput").get(0);
        var span = $(this).find(".timeText").get(0);
        var groupnumElement = $(this).find(".groups_in_class").get(0);
        var present = $(this).find(".presentCb").get(0).checked;

        if (present) {
            if (hidden.value != '') {
                $(span).empty();
                span.appendChild(document.createTextNode(hidden.value));
                now = hidden.value.split(':');
            }
            else {
                now = offsetTime(now, interval * numGroupsInLast);
                $(span).empty();
                span.appendChild(document.createTextNode(now[0] + ":" + now[1]));
            }
            numGroupsInLast = parseInt(groupnumElement.innerText || groupnumElement.textContent);
        }
        else {
            $(span).empty();
            span.appendChild(document.createTextNode(notPresentText));
        }
    });
}

function offsetTime(time, offset) {
    var hourString = time[0];
    if (hourString.substring(0, 1) == "0" && hourString != "0")
        hourString = hourString.substring(1);
    var hours = parseInt(hourString);

    var minuteString = time[1];
    if (minuteString.substring(0, 1) == "0" && minuteString != "0")
        minuteString = minuteString.substring(1);
    var minutes = parseInt(minuteString);

    minutes += offset;
    while (minutes >= 60) {
        hours++;
        minutes -= 60;
    }

    hours = hours % 24;

    if (minutes < 10)
        minutes = "0" + minutes;

    return [hours + "", minutes + ""];
}

{/literal}
//]]>
</script>

</div>
{include file='include/footer.tpl' noad=true}
