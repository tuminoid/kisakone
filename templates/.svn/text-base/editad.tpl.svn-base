{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * AD editor UI
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
 {translate assign=title id=editad_title}
 {capture assign=extrahead}
 <style type="text/css">{literal}

select, input[type="text"], input[type="file"] {
    min-width: 300px;
}

{/literal}</style>
{/capture}
{include file='include/header.tpl'}

{if $event}
    {capture assign=locid}ad_event_location_{$ad->contentId}{/capture}
{else}
    {capture assign=locid}ad_location_{$ad->contentId}{/capture}
{/if}
        {translate assign=typetext id=$locid}
    
<p>{translate id=ad_inline_help adtype=$typetext}</p>

<div class="nojs">
{translate id=page_requires_javascript}
</div>



{if $error}
    <p class="error">{$error|escape}</p>
{/if}

<div class="jsonly">
<form method="post" enctype="multipart/form-data">
    <input name="formid" type="hidden" value="edit_ad" />
    <h2>{translate id=ad_type_heading}</h2>
    <ul class="nobullets">
        {if $smarty.get.id && $smarty.get.id != 'default'}
            <li><input type="radio" {if $ad->type =='eventdefault'}checked="checked"{/if} name="ad_type"
            value="eventdefault" class="ad_type_selector" /> {translate id=ad_type_eventdefault}</li>
        {/if}
        <li><input type="radio" name="ad_type" {if $ad->type =='default'}checked="checked"{/if}
        value="default" class="ad_type_selector" /> {translate id=ad_type_default}</li>
        
        <li><input type="radio" name="ad_type" {if $ad->type =='imageandlink'}checked="checked"{/if}
        value="imageandlink" class="ad_type_selector" /> {translate id=ad_type_imageandlink}</li>
        
        <li><input type="radio" name="ad_type" {if $ad->type =='html'}checked="checked"{/if}
        value="html" class="ad_type_selector" /> {translate id=ad_type_html}</li>
        
        <li><input type="radio" name="ad_type" {if $ad->type =='reference'}checked="checked"{/if}
        value="reference" class="ad_type_selector" /> {translate id=ad_type_reference}</li>
        
        <li><input type="radio" name="ad_type" {if $ad->type =='disabled'}checked="checked"{/if}
        value="disabled" class="ad_type_selector" /> {translate id=ad_type_disabled}</li>
    </ul>
    
    <h2>{translate id=ad_details_heading}</h2>
    <div class="ad_details" id="add_eventdefault">
        <p>{translate id=ad_eventdefault_description}</p>
    </div>
    
    <div class="ad_details" id="add_default">
        <p>{translate id=ad_default_description}</p>
    </div>
    
    <div class="ad_details" id="add_disabled">
        <p>{translate id=ad_disabled_description}</p>
    </div>
    
    <div class="ad_details" id="add_html">
        <p>{translate id=ad_html_description}</p>
        <textarea name="html" cols="80" rows="10">{if $ad->type == 'html'}{$ad->longData|escape}{/if}</textarea>
    
    </div>
    
    <div class="ad_details" id="add_imageandlink">
        <p>{translate id=ad_imageandlink_description}</p>
        <table class="narrow">
            <tr><td>{translate id=ad_link}</td>
                <td colspan="2"><input name="url" value="{$ad->url|escape}" size="50" type="text" /></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td rowspan="6">{translate id=ad_image}</td>
                <td rowspan="2">
                    <input type="radio" name="image_type" value="internal"
                            {if $ad->imageReference !== null}checked="checked"{/if}/></td>
                <td>{translate id=ad_select}</td>            
            </tr>
            <tr><td>
                <select  class="selectRadioOnChange" name="image_ref">
                    {html_options options=$images selected=$ad->imageReference}
                </select>
            </td></tr>
            <tr><td rowspan="2"><input type="radio" name="image_type" value="upload"/></td><td>{translate id=ad_upload}</td>
            </tr>
            <tr><td>
                <input name="image_file"  class="selectRadioOnChange" type="file" />
                </td></tr>
            <tr><td rowspan="2"><input type="radio" name="image_type" value="link"
                            {if $ad->imageReference === null}checked="checked"{/if}/></td><td>{translate id=ad_link}</td>
            </tr>
            <tr><td>
                <input name="image_url" class="selectRadioOnChange" {if $ad->type == 'imageandlink'}value="{$ad->imageURL|escape}"{/if} type="text" />
                </td></tr>
        </table>
    </div>
    
    <div class="ad_details" id="add_reference">
        {assign var=ref_sel value=false}
        {if $ad->type == 'reference'}
            {assign var=ref_sel value=$ad->longData}
        {/if}
        <p>{translate id=ad_reference_description}</p>
        <table><tr><td>
        <ul class="nobullets">
            {foreach from=$globalReferenceOptions item=a}
            {capture assign=locid}ad_location_{$a}{/capture}
            
                <li><input type="radio" name="ad_ref" value="{$a}"
                           {if $a == $ref_sel}checked="checked"{/if}
                           /> {translate id=$locid}</li>
            {/foreach}
        </ul>
        </td>
        {if $eventReferenceOptions}
            <td>
                <ul class="nobullets">
                {foreach from=$eventReferenceOptions item=a}
                {capture assign=locid}ad_event_location_{$a}{/capture}
                
                    <li><input type="radio" name="ad_ref" value="e-{$a}"
                               {capture assign=ea}e-{$a}{/capture}
                               
                               {if $ea == $ref_sel}checked="checked"{/if}
                               /> {translate id=$locid}</li>
                {/foreach}
            </ul>
            </td>
        {/if}
        
        </tr></table>
    </div>
    
    <hr />
    <input type="submit" value="{translate id=save}" />
    <input type="submit" value="{translate id=preview}" name="preview" />
    <input type="submit" value="{translate id=cancel}" name="cancel" />
    
    
    <script type="text/javascript">
    //<![CDATA[
    {literal}
    $(document).ready(function(){
        $(".ad_details").hide();
        $(".ad_type_selector").click(changeType);
        
        var newel = document.getElementById("add_{/literal}{$ad->type}{literal}");
        //alert("add_" +  this.name);
        selected = newel;
        $(newel).show();
        
        $(".selectRadioOnChange").change(selectPreviousRadio);
        $("input.selectRadioOnChange").keyup(selectPreviousRadioOnChange);
        //$(".selectRadioOnChange").keydown(selectPreviousRadio);
    });
    
    var lt = null;
    
    // Usage: When the value of an input is changed, the radio box before it gets selected
    function selectPreviousRadioOnChange() {        
        if (lt != null){
            if (this.value != lt) {
                lt = this.value;
                this.sp = selectPreviousRadio;
                this.sp();                
            }
        } else {
            lt = this.value;
        }
        
    }
    
    // Selects the radio button before the current input
    function selectPreviousRadio() {
        
        var prev =this.parentNode.parentNode.previousSibling;
        while (!prev.tagName) prev = prev.previousSibling;
        var input = $(prev).find("input").get(0)
        var name = input.name;
        //$("input[name='" + name + "']").each(function(){this.checked = false;});
        input.checked = true;
    }
    
    var selected = null;
    
    // Closes the current ad panel and displays the one matching the new type selection
    function changeType() {
        if (!this.name) return;
        if (selected) $(selected).hide();
        
        var newel = document.getElementById("add_" + this.value);
        //alert("add_" +  this.name);
        selected = newel;
        $(newel).show();
        
    }
    
    {/literal}
    
    
    //]]>
    </script>
    </form>
</div>
{if $smarty.request.preview}
{include file='include/footer.tpl'}
{else}
{include file='include/footer.tpl' noad=1 }
{/if}
