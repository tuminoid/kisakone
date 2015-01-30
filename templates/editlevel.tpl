{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Level editor UI
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
{translate assign=title id=editlevel_title}
{include file='include/header.tpl' title=$title}

<form method="post" class="evenform" id="form">
<table class="narrow"><tr><td style="padding-right: 32px">
<h2>{translate id=editlevel_title}</h2>

    <input type="hidden" name="formid" value="edit_level" />

    <div>
        <label for="name">{translate id=name}</label>
        <input id="name" type="text" name="name" value="{$level.name|escape}" />
        {formerror field='name'}
    </div>

    <div>
        <label for="scoreCalculationMethod">{translate id=scorecalculation}</label>
        <select id="scoreCalculationMethod" name="scoreCalculationMethod">
            {html_options options=$scoreOptions selected=$level.scoreCalculationMethod}
        </select>
    </div>


    <div>
        <input type="checkbox" id="available" name="available" {if $level.available || $smarty.get.id == 'new'} checked="checked" {/if}
        />
        <label class="checkboxlabel" for="available">{translate id=available}</label>
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

    $("#cancelButton").click(CancelSubmit);

});


{/literal}


//]]>
</script>
</td><td style="border-left: 1px dotted #AAA; padding-left: 32px;">
{if $smarty.get.id != 'new'}
    <h2>{translate id=delete_level}</h2>

    {if $deletable}
        <p>{translate id=can_delete_level}</p>
        <p><input type="submit" name="delete" value="{translate id=delete}" /></p>
    {else}
        <p>{translate id=cant_delete_level}</p>
    {/if}
{/if}

</td></tr></table>
</form>

{include file='include/footer.tpl' noad=1}
