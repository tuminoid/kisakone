{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Class editor UI
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
{translate assign=title id=editclass_title}
{include file='include/header.tpl' title=$title}

<form method="post" class="evenform" id="form">
<table class="narrow"><tr><td style="padding-right: 32px">
<h2>{translate id=editclass_title}</h2>

    <input type="hidden" name="formid" value="edit_class" />
    
    <div>
        <label for="Name">{translate id=name}</label>
        <input type="text" id="Name" name="Name" value="{$class->name|escape}" />
        {formerror field='Name'}
    </div>
    
    <div>
        <label for="MinimumAge">{translate id=minage}</label>
        <input type="text" id="MinimumAge" name="MinimumAge" value="{$class->minAge|escape}" />
        {formerror field='MinimumAge'}
    </div>
    <div>
        <label for="MaximumAge">{translate id=maxage}</label>
        <input type="text" id="MaximumAge" name="MaximumAge" value="{$class->maxAge|escape}" />
        {formerror field='MaximumAge'}
    </div>
    
    <div>
        <label for="GenderRequirement">{translate id=gender}</label>
        <select name="GenderRequirement" id="GenderRequirement">            
            {html_options options=$genderOptions selected=$class->gender}
        </select>

    </div>
    
    <div>
        <input type="checkbox" id="Available" name="Available" {if $class->available || $smarty.get.id == 'new'} checked="checked" {/if}
        />
        <label class="checkboxlabel" for="Available">{translate id=available}</label>
    </div>
<hr />
<div>
        <input type="submit" value="{translate id='form_save'}" name="save" />
        <input type="submit" id="cancelButton" value="{translate id='form_cancel'}" name="cancel" />
        
    </div>    



<script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
    CheckedFormField('form', 'Name', NonEmptyField, null);
    CheckedFormField('form', 'MinimumAge', PositiveIntegerField, true);
    CheckedFormField('form', 'MaximumAge', PositiveIntegerField, true);
    
    $("#cancelButton").click(CancelSubmit);
    
});


{/literal}


//]]>
</script>
</td><td style="border-left: 1px dotted #AAA; padding-left: 32px;">
{if $smarty.get.id != 'new'}
    <h2>{translate id=delete_class}</h2>
    
    {if $deletable}
        <p>{translate id=can_delete_class}</p>
        <p><input type="submit" name="delete" value="{translate id=delete}" /></p>
    {else}
        <p>{translate id=cant_delete_class}</p>
    {/if}
{/if}

</td></tr></table>
</form>

{include file='include/footer.tpl' noad=1} 