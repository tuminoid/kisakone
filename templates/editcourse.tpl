{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Course editor UI
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
input[type="text"] { min-width: 200px; }
{/literal}</style>

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
{translate assign=title id=editcourse_title}
{include file='include/header.tpl' title=$title}

{if $holeChooser}
    <form method="get">
        {initializeGetFormFields}
        <p>{translate id=num_holes} <input type="text" name="holes" value="18" /></p>
        <p><input type="submit" value="{translate id=proceed}" /></p>
    </form>
{else}
{if $error}
<p class="error">{$error}</p>
{/if}

{if $warning}
<p class="error">{translate id=course_edit_warning}</p>
{/if}

<form method="post">
    <input type="hidden" name="formid" value="manage_courses" />
    <div  class="buttonarea">
        <input type="submit" value="{translate id=save}" />
        <input type="submit" name="cancel" value="{translate id=cancel}" />
	{if !$warning}<input type="submit" style="margin-left: 200px" name="delete" value="{translate id=delete}" />{/if}
    </div>

    <div class="round">
        <h2>{translate id=course}</h2>
        <table class="narrow">
            <tr>
                <td>{translate id=name}</td>
                <td><input type="text" name="name" value="{$course.Name|escape}" /></td>
            </tr>
            <tr>
                <td>{translate id=map_url}</td>
                <td><input type="text" name="map" value="{$course.Map|escape}" /></td>
            </tr>
            <tr>
                <td>{translate id=link}</td>
                <td><input type="text" name="link" value="{$course.Link|escape}" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>{translate id=description}</p>
                    <textarea cols="80" rows="25" name="description">{$course.Description|escape}</textarea>
                </td>
            </tr>

            <tr>
                 <td>{translate id=holes_list}   </td>
                 <td>
                    <table class="narrow">
                        <tr>
                            <td>{translate id=hole_number}</td>
                            <td>{translate id=hole_text}</td>
                            <td>{translate id=par}</td>
                            <td>{translate id=hole_length}</td>
                        </tr>
                        {foreach from=$holes item=hole}
                        <tr>
                            <td>
                                {$hole->holeNumber}
                            </td>
                            <td>
                                <input type="text" size="4" maxlength="4" name="h_{$hole->holeNumber}_{$hole->id}_text" value="{$hole->holeText|escape}" />
                            </td>
                            <td>
                                <input type="text" size="4" maxlength="2" name="h_{$hole->holeNumber}_{$hole->id}_par" value="{$hole->par}" />
                            </td>
                            <td>
                                <input type="text" size="4" maxlength="4" name="h_{$hole->holeNumber}_{$hole->id}_len" value="{$hole->length}" />
                            </td>
                        </tr>
                        {/foreach}
                    </table>
                 </td>
            </tr>
        </table>
    </div>

    <div  class="buttonarea">
        <input type="submit" value="{translate id=save}" />
        <input type="submit" name="cancel" value="{translate id=cancel}" />
	{if !$warning}<input type="submit" style="margin-left: 200px" name="delete" value="{translate id=delete}" />{/if}
    </div>
</form>
{/if}

{include file='include/footer.tpl' noad=1}
