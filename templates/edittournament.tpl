{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Tourmanet editor ui
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
{translate assign=title id=edittournament_title}
{include file='include/header.tpl' title=$title}

<form method="post" class="evenform" id="form">
<table class="narrow"><tr><td style="padding-right: 32px">
<h2>{translate id=edittournament_title}</h2>

     <input type="hidden" name="formid" value="edit_tournament" />

    <div>
        <label for="name">{translate id=name}</label>
        <input id="name" type="text" name="name" value="{$tournament->name|escape}" />
        {formerror field='name'}
    </div>

    <div>
        <label for="year">{translate id=year}</label>
        <input id="year" type="text" name="year" value="{$tournament->year|escape}" />
        {formerror field='year'}
    </div>

    <div>
        <label for="scoreCalculationMethod">{translate id=scorecalculation}</label>
        <select id="scoreCalculationMethod" name="scoreCalculationMethod">
            {html_options options=$scoreOptions selected=$tournament->scoreCalculationMethod}
        </select>
    </div>

    <div>
        <label for="level">{translate id=level}</label>
        <select id="level" name="level">
            {html_options options=$levelOptions selected=$tournament->level}
        </select>
    </div>

    <div>
        <input type="checkbox" id="available" name="available" {if $tournament->available || $smarty.get.id == 'new'} checked="checked" {/if}
        />
        <label class="checkboxlabel" for="available">{translate id=available}</label>
    </div>





<script type="text/javascript">
//<![CDATA[
{literal}
$(document).ready(function(){
    CheckedFormField('form', 'name', NonEmptyField, null);
    CheckedFormField('form', 'year', PositiveIntegerField, null);

    $("#cancelButton").click(CancelSubmit);

});


{/literal}


//]]>
</script>
</td><td style="border-left: 1px dotted #AAA; padding-left: 32px;">
{if $smarty.get.id != 'new'}
    <h2>{translate id=delete_tournament}</h2>

    {if $deletable}
        <p>{translate id=can_delete_tournament}</p>
        <p><input type="submit" name="delete" value="{translate id=delete}" /></p>
    {else}
        <p>{translate id=cant_delete_tournament}</p>
    {/if}
{/if}

</td></tr></table>
<div>{translate id=description}</div>
<textarea name="description" cols="80" rows="20">{$tournament->description|escape}</textarea>

<hr />
    <div>
        <input type="submit" value="{translate id='form_save'}" name="save" />
        <input type="submit" id="cancelButton" value="{translate id='form_cancel'}" name="cancel" />

    </div>

</form>

{include file='include/footer.tpl' noad=1}