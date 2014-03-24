{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Email editor UI
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

{if !$inline}
{translate assign=title id=editcontentpage_title}
{include file='include/header.tpl'}
{/if}

<div style="float: left; max-width: 300px; background-color: #DDD; margin: 8px;">
    <p>{translate id=email_token_info}</p>
    <table>
        {foreach from=$tokens item=ignored key=token}
        <tr>
            {capture assign=description}email_token_{$token}{/capture}
            <td>{$token}</td>
            <td>{translate id=$description|escape}</td>
        </tr>
        {/foreach}
    </table>
</div>

{if $error}
<p class="error">{$error}</p>
{/if}

{if $smarty.request.preview}

{$preview_email->text|escape|nl2br}

{/if}

{if !$inline}
<form method="post" class="evenform" id="form">
{/if}
<table class="narrow"><tr><td style="padding-right: 32px">

 {if !$inline}
    <input type="hidden" name="formid" value="edit_global_page" />
{/if}
    <input type="hidden" name="mode" value="email" />

    <div>
        <label for="title">{translate id=title}</label>
        <input id="title" type="text" name="title" value="{$page->title|escape}" />

    </div>

    <div>
        <label for="textcontent">{translate id=content}</label><br />
        <textarea id="textcontent" rows="20" name="textcontent" cols="80">{$page->content|escape}</textarea>
        <br />
    </div>


    <hr />
    <div>
        {if !$save_text}
            {translate assign=save_text id='form_save'}
        {/if}
        <input type="submit" value="{$save_text}" name="save" />
        <input id="previewbutton" type="submit" value="{translate id='form_preview'}" name="preview" />
        <input type="submit" id="cancelButton" value="{translate id='form_cancel'}" name="cancel" />


    </div>




<script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
    CheckedFormField('form', 'title', NonEmptyField, null);


});



{/literal}


//]]>
</script>
</td></tr></table>

{if !$inline}
</form>


{include file='include/footer.tpl' noad=1}
{/if}
