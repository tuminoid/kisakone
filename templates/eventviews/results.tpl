{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Results and live results
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
 {if $mode != 'body'}
 <style type="text/css">{literal}
    .resultrow td, .resultrow th {
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        text-align: center;
        
        margin: 0;
    }
    
    
    
    .results td, .results th {
        background-color: #EEE;
        text-align: center;
        border: 2px solid white;
    }
    
    .penalty_hidden { display: none !important; }
    
    
    .in, .out {
        background-color: #caffca !important;
    }
    
    .round_selection_table .selected {
        background-color: #DDD;
        
    }
    
    .results {
        border-collapse: collapse;
    }
    
    .rightside {
        text-align: right !important;
    }
    .leftside {
        text-align: left !important;
    }
    
    .thr {
        
    }
    
    .plusminus_neg { color: #F00; }
    .plusminus_pos { color: #0000aa; font-weight: bold; }
    
    .rm {
        background-color: #f6a690 !important;
    }
    
    .rp1 {
        background-color: #aacfcf !important;
    }
    .pr {
        background-color: #f6F6F6 !important;
    }
    
    .rp {
        background-color: #51787e !important;
        color: white;
    }
    
    .penaltytd { background-color: white !important}
    
    .penalty {
        background-color: #EEE !important;
        color: red;
        min-width: 16px;
        
        
    }
    
{/literal}</style>
{else}
 <div id="event_content">
    {$page->formattedText}
</div>


<table class="round_selection_table narrow" >
    {foreach from=$classes key=classid item=class}
        <tr>
            <th>{$class->name|escape}</th>
        {foreach from=$rounds key=index item=round}
        {math assign=roundnum equation="x+1" x=$index}
            
            {if $round->id == $the_round->id}
                <td class="selected">
                <a href="#c{$class->name}">
                {translate id=round_title number=$roundnum}</a></td>
            {else}
                 <td>
            
                <a href="{url page=event id=$smarty.get.id view=$smarty.get.view round=$roundnum}#c{$class->name}">
                {translate id=round_title number=$roundnum}</a>
                </td>
            {/if}
        {/foreach}
        </tr>
    {/foreach}
</table>


<table class="results ">
   
    
    {foreach from=$resultsByClass key=class item=results}
    <tr style="border: none" class="class_border">
        {math assign=colspan equation="2+x+2+2" x=$round->NumHoles()}
        <td colspan="{$colspan}" style="background-color: white" class="leftside">
            <a name="c{$class}"></a>
            <h3>{$class|escape}</h3>
        </td>
        
    </tr>
    {counter assign=rowind start=-1}
    {foreach from=$results item=result}
    {if $result.Total != 'not_used'}
        {counter assign=rowind}
        
        {if $rowind == 0}
        <tr>
               <td style="height: 8px; background-color: white;"></td>
            </tr>
            <tr class="thr">
                <th rowspan="2">{translate id=result_pos}</th>
                <th rowspan="2">{translate id=result_name}</th>
                <th></th>
                <th colspan="{math equation="x+2" x=$round->NumHoles()}">{translate id=result_score}</th>
               
               
                <th colspan="2">{translate id=round}</th>
                <th colspan="2">{translate id=cumulative}</th>
            </tr>
            <tr class="thr">
                <th class="rightside">
                    {translate id=hole_num}<br />
                    {translate id=hole_par}
                </th>
                {assign var=parSoFar value=0}
                {foreach from=$holes key=index item=hole}
                        {math assign=parSoFar equation="x+y" x=$parSoFar y=$hole->par}                        
                        <th>{$hole->holeNumber}<br />{$hole->par}</th>
                        {if $hole->holeNumber == $out_hole_index}<th class="out">{translate id=hole_out}<br />{$parSoFar}{assign var=parSoFar value=0}</th>{/if}
                {/foreach}
                <th class="in">{translate id=hole_in}<br />{$parSoFar}</th>
                 <th>+/-</th>
                <th>{translate id=result}</th>
                <th>+/-</th>
                <th>{translate id=result}</th>
            </tr>
            
            <tr>
               <td style="height: 8px; background-color: white;"></td>
            </tr>
        {/if}
        
<tr class="resultrow">

<td id="r{$result.PlayerId}_pos">{$result.Standing}</td>
<td colspan="2" class="leftside">{$result.FirstName|escape} {$result.LastName|escape}</td>

{assign var=inout value=0}
{assign var=dnfd value=false}
{foreach from=$holes item=hole key=index}

{assign var=holenum value=$hole->holeNumber}
{capture assign="hr_id"}{$hole->round}_{$hole->holeNumber}{/capture}
{assign var=holeresult value=$result.Results.$holenum.Result}
{if !$holeresult}{assign var=holeresult value=0}{/if}
{math assign=inout equation="x+y" x=$inout y=$holeresult}

{if $holeresult >= 99}{assign var=dnfd value=true}{/if}

{math assign=pardiff equation="res-par" res=$holeresult par=$hole->par}
{if $holeresult == 0}{assign var=holeclass value='rz'}
{elseif $pardiff == 0}{assign var=holeclass value='pr'}
{elseif $pardiff < 0}{assign var=holeclass value='rm'}
{elseif $pardiff  == 1}{assign var=holeclass value='rp1'}
{elseif $pardiff > 1}{assign var=holeclass value='rp'}
{/if}

<td class="{$holeclass}"  id="r{$result.PlayerId}_{$hr_id}">
    {if $holeresult != 0}{$holeresult}{/if}</td>


{if $hole->holeNumber == $out_hole_index}
<td class="out" id="r{$result.PlayerId}_out">
    {if $dnfd}{translate id=result_dnf}{else}
    {$inout}{/if}
    {assign var=inout value=0}
</td>{/if}

{/foreach}

<td class="in" id="r{$result.PlayerId}_in">
{if $dnfd}{translate id=result_dnf}{else}
    {$inout}{/if}

</td>

{if $result.DidNotFinish}
 <td  id="r{$result.PlayerId}_rpm">{translate id=result_dnf}</td>
 <td  id="r{$result.PlayerId}_rt">{translate id=result_dnf}</td>
 <td class="cpm" id="r{$result.PlayerId}_cpm">{translate id=result_dnf}</td>
<td  id="r{$result.PlayerId}_ct">{translate id=result_dnf}</td>
{else}
<td class="plusminus_{if $result.RoundPlusMinus < 0}neg{elseif $result.RoundPlusMinus > 0}pos{else}zero{/if}"
id="r{$result.PlayerId}_rpm">{$result.RoundPlusMinus}</td>
<td id="r{$result.PlayerId}_rt">{$result.Total}</td>
<td class="cpm plusminus_{if $result.CumulativePlusminus < 0}neg{elseif $result.CumulativePlusminus > 0}pos{else}zero{/if}"
id="r{$result.PlayerId}_cpm">{$result.CumulativePlusminus}</td>
<td id="r{$result.PlayerId}_ct">{$result.CumulativeTotal}</td>
<td id="r{$result.PlayerId}_p" class="penalty_hidden">{$result.Penalty}</td>
{/if}
{if $result.Penalty}
<td id="r{$result.PlayerId}_px" class="penaltytd penalty">                
{translate id=result_penalty_panel}

</td>
{ else}
<td id="r{$result.PlayerId}_px" class="penaltytd">                               
</td>
{/if}
            
        </tr>
        {/if}
    {/foreach}
    {/foreach}
    {* Note: JS assumes nextSibling is valid for any resultrow -- the empty one must be here! *}
    <tr><td></td></tr>
</table>


    <script type="text/javascript" src="{url page=javascript/live}"></script>
    
    <script type="text/javascript">
    //<![CDATA[
    var holes = new Array();
    {foreach from=$holes item=hole}
        holes[{$hole->id}] = {$hole->par};
    {/foreach}
    holes["p"] = 0;
    var eventid = {$eventid};
    
    var roundid = {$roundid};
    var out_hole_index = {$out_hole_index};
    var penaltyText = "{translate id=result_penalty_panel}";

    {literal}
    
    
    
    $(document).ready(function(){
        {/literal}{if $live}
        initializeLiveUpdate(15, eventid, roundid, updateField, updateBatchDone);
        
        {/if}{literal}
        
        
        $("#stop").click(function(){ nolive=true; });
        
    });
    
    var anyChanges = false;
    var anySwaps = false;
    
    function updateField(data) {
        if (data.hole == "sd") return;
        
        var fieldid;
        if (data.hole == "p") {
            updatePenaltyField(data);
             fieldid = "r" + data.pid + "_p";
        } else {
            fieldid = "r" + data.pid + "_" + data.round + "_" + data.holeNum;
        }
        
        
        
        
        var field = document.getElementById(fieldid);
        if (field) {
            var current = parseInt(field.innerText || field.textContent);
            if (isNaN( current )) current = 0;
            var diff = data.value - current;
            
            
            
            if (diff) {
                if (current == 99 || data.value == 99) {
                    window.location.reload();
                }
                
                if (field.firstChild) field.removeChild(field.childNodes[0]);
                var newTextNode = document.createTextNode(data.value);
                field.appendChild(newTextNode);
                $(field).effect("highlight", {color: '#5F5'}, 30000);
                
                // Round
                {
                    var totfield = document.getElementById("r" + data.pid + "_rt");
                    var ctot = parseInt(totfield.innerText || totfield.textContent);
                    if (isNaN(ctot)) ctot = 0;
                    
                    if (totfield.childNodes.length) totfield.removeChild(totfield.childNodes[0]);
                    totfield.appendChild(document.createTextNode(ctot + diff));
                    $(totfield).effect("highlight", {color: '#55F'}, 30000);
                                    
                    var pmfield = document.getElementById("r" + data.pid + "_rpm");
                    
                    var cpm = parseInt(pmfield.innerText || pmfield.textContent);
                    if (isNaN(cpm)) cpm = 0;
                    
                    
                    var par;
                    if (data.hole == "p") par = 0;
                    else par = holes[data.hole];
                    
                    if (data.value == 0) {
                        newpm = cpm - (current - par);
                    } else if (current == 0) {
                        newpm = cpm + (data.value - par);
                    } else {
                        newpm = cpm + diff;
                    }
                    
                    if (pmfield.childNodes.length) pmfield.removeChild(pmfield.childNodes[0]);
                    pmfield.appendChild(document.createTextNode(newpm));
                    $(pmfield).effect("highlight", {color: '#55F'}, 30000);
                }
                
                
                // Cumulative
                {
                    var totfield = document.getElementById("r" + data.pid + "_ct");
                    var ctot = parseInt(totfield.innerText || totfield.textContent);
                    if (isNaN(ctot)) ctot = 0;
                    
                    if (totfield.childNodes.length) totfield.removeChild(totfield.childNodes[0]);
                    totfield.appendChild(document.createTextNode(ctot + diff));
                    $(totfield).effect("highlight", {color: '#55F'}, 30000);
                                    
                    var pmfield = document.getElementById("r" + data.pid + "_cpm");
                    
                    var cpm = parseInt(pmfield.innerText || pmfield.textContent);
                    if (isNaN(cpm)) cpm = 0;
                    
                    var par = holes[data.hole];
                    
                    if (data.value == 0) {
                        newpm = cpm - (current - par);
                    } else if (current == 0) {
                        newpm = cpm + (data.value - par);
                    } else {
                        newpm = cpm + diff;
                    }
                    
                    if (pmfield.childNodes.length)pmfield.removeChild(pmfield.childNodes[0]);
                    pmfield.appendChild(document.createTextNode(newpm));
                    $(pmfield).effect("highlight", {color: '#55F'}, 30000);
                }
                
                if (data.hole != "sd" && data.hole != "p") {
                    var suffix;
                    if (data.holenum <= out_hole_index) {
                        suffix = "out";
                    } else {
                        suffix = "in";
                    }
                    
                    var totfield = document.getElementById("r" + data.pid + "_" + suffix);
                    var ctot = parseInt(totfield.innerText || totfield.textContent);
                    if (isNaN(ctot)) ctot = 0;
                    
                    if (totfield.childNodes.length) totfield.removeChild(totfield.childNodes[0]);
                    totfield.appendChild(document.createTextNode(ctot + diff));
                    $(totfield).effect("highlight", {color: '#55F'}, 30000);
                }
                
                if (diff < 0)  {
                    moveUpIfNecessary(field);
                } else {
                    moveDownIfNecessary(field);
                }
                
                if (anySwaps) redoPositions();
                
            }
            

        } else {
//            alert('reloading  ' + fieldid);
            window.location.reload();
        }
        anyChanges = true;
    }
    
    function updateBatchDone() {        
        anyChanges = false;
    }
    
    function redoPositions() {
        var last = -9999;
        var lastpos = 0;
        
        $(".tr").each(function() {
            if (tr.className != 'resultrow') {
               if (tr.className = "class_border") {
                  last = -9999;
                  lastpos = 0;
                  return;
               }
               return;
            }
            var val = parseInt($(this).find(".cpm").text());
            
            if (val == last) {
                setPosition(this, lastpos);
            } else {
                lastpos++;
                setPosition(this, lastpos);
                last = val;
            }
        });
    }
    
    function setPosition(tr, pos) {
        var td = $(tr).find("td").get(0);
        
        $(td).empty();
        td.appendChild(document.createTextNode(pos));
        
    }
    
    function updatePenaltyField(data) {
        var field = $("#r" + data.pid + "_px");
        if (!field.get(0)) return;
        if (!data.value) {
            field.empty();            
            field.get(0).className = "penaltytd";
        } else {

            field.empty();
            field.get(0).className = "penaltytd penalty";
            field.get(0).appendChild(document.createTextNode(penaltyText));
        }
    }
    
    function moveDownIfNecessary(field) {
        
        var row = $(field).closest("tr").get(0);
        var nextrow = nextResultRow(row);
        
        if (!nextrow) return;
        
        var c = compareRows(row, nextrow);
        
        if (c == 1) {
            swapRows(row, nextrow);
            anySwaps = true;
            moveDownIfNecessary(field);
        }
        
    }
    
    function moveUpIfNecessary(field) {
        var row = $(field).closest("tr").get(0);
        var nextrow = prevResultRow(row);
        
        if (!nextrow) return;
        
        
        var c = compareRows(row, nextrow);
        
        if (c == -1) {
            swapRows(row, nextrow);
            anySwaps = true;
            moveUpIfNecessary(field);
        }
        
    }
    
    function prevResultRow(row) {
        var r=  row.previousSibling;
        
        while (r) {
            if (r.tagName && r.tagName.match(/tr/i)) {
                if (r.className == 'resultrow') return r;
                if (r.className == 'class_border') return null;
            }
            
            r = r.previousSibling;
        }
        return null;
    }
    
    function nextResultRow(row) {
        var r = row.nextSibling;
        
        while (r) {
            if (r.tagName && r.tagName.match(/tr/i)) {
                if (r.className == 'resultrow') return r;
                if (r.className == 'class_border') return null;
            }
            
            r = r.nextSibling;
        }
        return null;
    }
    
    function compareRows(a, b) {
        
        var acell = $(a).find(".cpm").get(0);
        var bcell = $(b).find(".cpm").get(0);
        
        if (!acell || !bcell) {
            if (acell == bcell) return 0;
            if (!acell) return 1;
            return -1;
        }
        
        var avalue = parseInt(acell.textContent || acell.innerText);
        var bvalue = parseInt(bcell.textContent || bcell.innerText);
        
        
        
        if (avalue == bvalue) return 0;
        if (avalue < bvalue) return -1;
        
        
        return 1;
        
    }
    
    function swapRows(a, b) {       
        var aa = a.nextSibling;
        var ab = b.nextSibling;
        
        b.parentNode.insertBefore(a, ab);
        a.parentNode.insertBefore(b, aa);
    }
    
    {/literal}
    
    
    //]]>
    </script>    

{/if}