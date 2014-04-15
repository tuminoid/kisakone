{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Event page editor UI backend. Also used for global text content
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
<script type="text/javascript" src="{$url_base}js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({ldelim}
	theme : "advanced",
	mode : "textareas",
	plugins : "table",
	theme_advanced_buttons3_add : "tablecontrols",
        theme_advanced_toolbar_location : "top",

        theme_advanced_toolbar_align : "left",

        theme_advanced_statusbar_location : "bottom",

        theme_advanced_resizing : true
{rdelim});
</script>
{/capture}
{translate assign=title id=editcontentpage_title}
{include file='include/header.tpl'}

{if $error}
<p class="error">{$error}</p>
{/if}

{if $smarty.post.preview}

{if $smarty.get.mode == 'news'}
<h2>{$page->GetProperTitle()|escape}</h2>
{/if}
{$page->formattedText}
<hr />
{/if}

<form method="post" class="evenform" id="form">
<table class="narrow"><tr><td style="padding-right: 32px">

        {if $global}
        <input type="hidden" name="formid" value="edit_global_page" />
        {else}
     <input type="hidden" name="formid" value="edit_event_page" />
    {/if}
    {if !$global || $custom}
    <div>
        <label for="title">{translate id=title}</label>
        <input id="title" type="text" name="title" value="{$page->title|escape}" />

        {if $smarty.get.mode != custom && $smarty.get.mode != news}
        {capture assign=transkey}pagetitle_{$page->type}{/capture}
        {translate assign=pagetitle id=$transkey}
        <p>{translate id=default_title_for_page title=$pagetitle}</p>
        {/if}
    </div>
    {/if}

    <div class="yui-skin-sam">
        <label for="textcontent">{translate id=content}</label><br />
        <textarea id="textcontent" rows="20" name="textcontent" cols="120">{$page->content|escape}</textarea>
        <br />
    </div>

    {if $global && $smarty.get.mode == custom}
        <div>
            <label for="access">{translate id=content_access}</label><br />
            <select name="type" id="access">
                <option value="custom" {if $page->type==custom}selected="selected"{/if}>{translate id=access_all}</option>
                <option value="custom_man" {if $page->type=='custom_man'}selected="selected"{/if}>{translate id=access_management}</option>
                <option value="custom_adm" {if $page->type=='custom_adm'}selected="selected"{/if}>{translate id=access_admin}</option>
            </select>
        </div>
    {/if}

    <hr />
    <div>
        <input type="submit" value="{translate id='form_save'}" name="save" />
        <input id="previewbutton" type="submit" value="{translate id='form_preview'}" name="preview" />
        <input type="submit" id="cancelButton" value="{translate id='form_cancel'}" name="cancel" />

        {if $smarty.get.content != '*'}
        <input style="margin-left: 60px;" type="submit" value="{translate id='delete'}" name="delete" />

        {/if}
    </div>




<script type="text/javascript">
//<![CDATA[
{if $smarty.get.mode == 'custom'}
{literal}
$(document).ready(function(){
    CheckedFormField('form', 'name', NonEmptyField, null);


    $("#cancelButton").click(CancelSubmit);


});



{/literal}
{/if}


//]]>
</script>
</td></tr></table>
</form>


{include file='include/footer.tpl' noad=1}
