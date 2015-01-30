{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Splitting classes into multiple sections
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
{translate id='splitclasses_title' assign='title' }
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
        float: left;
        padding: 16px;
        margin: 8px;
    }

    h2 {
        clear: both;
    }

    .name {
        min-width: 120px;
        display: inline-block;
    }


    {/literal}
</style>
{/capture}
{include file='include/header.tpl'  ui=1 }


{include file=support/eventlockhelper.tpl}



{if $suggestRegeneration}
    <div class="error">
        <form method="get">
            {initializeGetFormFields  regenerate=false }
            <p>{translate id=regenerate_section_text_2}</p>
            <p><input name="regenerate" type="submit" value="{translate id=regenerate_sections}" /></p>
        </form>
    </div>
{else}
    <div class="searcharea">
        <form method="get">
            {initializeGetFormFields  regenerate=false }
            <p>{translate id=regenerate_section_text_1}</p>
            <p><input name="regenerate"  type="submit" value="{translate id=regenerate_sections}" /></p>
        </form>
    </div>
{/if}

<form method="post">
    <input type="hidden" name="formid" value="split_classes" />

    <div  class="buttonarea">
        <p style="float: right; max-width: 200px;">{translate id=split_classes_quickhelp}</p>
        <input type="submit" value="{translate id=save}" />
        <input type="submit" name="cancel" value="{translate id=cancel}" />
    </div>



{assign var=parentid value='undefined'}
{foreach from=$data item=section}
    {if $section->classification !== $parentid}
        {assign var=parentid value=$section->classification}
        <div></div>
        <h2>{$section->GetClassName()|escape}</h2>
        {assign var=first value=true}
    {/if}

            <div class="subclass cid{$section->classification}" id="c_{$section->id}">
                <input name="cname_{$section->id}" value="{$section->name|escape}" />

                <ul>

                    {foreach from=$section->GetPlayers() item=player}
                        <li><input type="hidden" name="p{$player.PlayerId}" value="c_{$section->id}" />
                            <span class="name">{$player.FirstName|escape} {$player.LastName|escape}, </span>
                            <span class="pdga">{$player.PDGANumber}</span>{if $firstRound},
                            <span class="class">{$player.Classification|escape}</span>{else}, #{counter}{/if}</li>
                    {/foreach}
                </ul>
                <button class="splitButton splitBase_{$section->classification}">{translate id=split}</button>
                {if !$first}
                    <button class="joinButton splitBase_{$section->classification}">{translate id=combine}</button>
                {/if}
            </div>
        {* Used for making sure there's a nextSibling from last split *}
        {assign var=first value=false}
{/foreach}
<div></div>

    <div  class="buttonarea">
        <input type="submit" value="{translate id=save}" />
        <input type="submit" name="cancel" value="{translate id=cancel}" />
    </div>

</form>

<script type="text/javascript">
//<![CDATA[

var locked = {if $locked}true{else}false{/if};

{literal}


var beingDragged = null;

var newClassIndex = 1;


$("document").ready(function(){
    reInit();
    $(".splitButton").click(doSplit);
    $(".joinButton").click(doJoin);
});

function reInit() {
    if (locked) return;
   $(".subclass li").draggable({
        addClasses: false,
        containment: '#content',
        revert: true,
        revertDuration: 0,
        zIndex: 200,
        helper: 'clone',
        scroll: true,
        start: function(e, ui)  { ui.helper.addClass("beingDragged"); beingDragged = this; },
        stop: function(e, ui)  { ui.helper.removeClass("beingDragged"); },
        opacity: 0.8

    });



   $(".subclass").droppable(
    {
        addClasses: false,
        hoverClass: 'droponme',

        drop: dropped
    });


}

function getBaseId(button) {
    var cn = button.className;
    var s = cn.split('_');
    return s[1];
}

function doSplit() {
    var baseId = getBaseId(this);

    //<input name="cname_{$class->id}" value="{$class->name|escape}" />
    var div = document.createElement('div');
    div.className = this.parentNode.className;


    var h3 = document.createElement('input');
    h3.type = "text";
    var myid = "c_n" + (++newClassIndex);
    h3.name = "cname_" + myid.substring(2);

    div.id = myid;


    var splitName = prompt("{/literal}{translate id=enter_split_name}{literal}");
    if (splitName == undefined) return false;
    if (!splitName) splitName = "{/literal}{translate id=new_split_name}{literal}";

    h3.value = splitName;

    div.appendChild(h3);

    var baseInput = document.createElement('input');

    baseInput.type = "hidden";
    baseInput.name = "base_" + myid;
    baseInput.value = baseId;

    div.appendChild(baseInput);

    var list = document.createElement('ul');
    div.appendChild(list);

    var button = document.createElement('button');
    button.appendChild(document.createTextNode("{/literal}{translate id=split}{literal}"));
    button.className = "splitButton splitBase_" + baseId;

    div.appendChild(button);

    var joinButton = document.createElement('button');
    joinButton.appendChild(document.createTextNode("{/literal}{translate id=combine}{literal}"));
    div.appendChild(joinButton);

    var myList = this.previousSibling;
    while (!myList.tagName || ! myList.tagName.match(/ul/i)) myList = myList.previousSibling;

    moveHalf(myList, list, myid);

    this.parentNode.parentNode.insertBefore(div, this.parentNode.nextSibling);

    $(button).click(doSplit);
    $(joinButton).click(doJoin);
    reInit();

    return false;
}

function doJoin() {
    var myList = this.previousSibling;
    while (!myList.tagName || !myList.tagName.match(/ul/i)) myList = myList.previousSibling;

    var prevContainer = this.parentNode.previousSibling;
    while (!prevContainer.tagName || !prevContainer.tagName.match(/div/i)) prevContainer = prevContainer.previousSibling;
    var prevList = prevContainer.firstChild;

    while (!prevList.tagName || !prevList.tagName.match(/ul/i)) prevList = prevList.nextSibling;

    while (myList.childNodes.length != 0) {
        if (!myList.firstChild.tagName ||  !myList.firstChild.tagName.match(/li/i)) {
            myList.removeChild(myList.firstChild);
        } else {
            setId(myList.firstChild, prevContainer.id);
            prevList.appendChild(myList.firstChild);
        }
    }

    this.parentNode.parentNode.removeChild(this.parentNode);
}

function moveHalf(from, to, newId) {
    var count = 0;
    for (var i in from.childNodes) if (from.childNodes[i].tagName && from.childNodes[i].tagName.match (/li/i)) count++;

    if (count < 2) return;
    var skip = Math.ceil(count / 2);

    var toMove = new Array();

    for (var i in from.childNodes) {
        if (!from.childNodes[i].tagName || !from.childNodes[i].tagName.match(/li/i)) continue;
        if (skip) skip--;
        else {
            toMove.push(from.childNodes[i]);
        }

    }

    for (var i = 0; i < toMove.length; ++i) {
        setId(toMove[i], newId);
        to.appendChild(toMove[i]);
    }

}

function dropped() {

    var srcPanel = beingDragged.parentNode.parentNode;
    if (srcPanel == this) return;

    if (this.className !=  srcPanel.className) {
        alert(this.className + " -- " + srcPanel.className);
        alert("{/literal}{translate id=cant_move_between_classes}{literal}");
        return;
    }

    var myList = this.firstChild;
    while (!myList.tagName || !myList.tagName.match(/ul/i)) myList = myList.nextSibling;

    if (firstBeforeLater(srcPanel, this)) {
        if (myList.firstChild) {
            myList.insertBefore(beingDragged, myList.firstChild);
        } else {
            myList.appendChild(beingDragged);
        }
    } else {
        myList.appendChild(beingDragged);
    }
    setId(beingDragged, this.id);

}

function setId(li, id) {
    var c = li.firstChild;
    while (!c.tagName || !c.tagName.match(/input/i) ) c = c.nextSibling;
    c.value = id;
}

function firstBeforeLater(first, later) {
    var node = first.nextSibling;
    while (node != null) {
        if (node == later) return true;
        node = node.nextSibling;
    }
    return false;
}
{/literal}


//]]>
</script>

{include file='include/footer.tpl' noad=true}

