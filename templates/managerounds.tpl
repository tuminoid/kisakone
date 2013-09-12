{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Round management
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
 {translate assign=title id=managerounds_title}
{include file=include/header.tpl}


{include file=support/eventlockhelper.tpl}
{capture assign=link}{url page=managecourses id=$smarty.get.id}{/capture}
<p>{translate id=round_course_edit_help link=$link}</p>

<form method="post">
    <input type="hidden" name="formid" value="manage_rounds" />
    <div  class="buttonarea">
        <input type="submit" value="{translate id=save}" />
        <input type="submit" name="cancel" value="{translate id=cancel}" />
    </div>
    {counter start=0 assign=globalHole}
    {foreach from=$rounds item=round key=index}
        {math assign=number equation="x + 1" x=$index}
        <div class="round">
            <h2>{translate id=round_number number=$number}</h2>
            <table class="narrow">
                <tr>
                    {* todo: proper selection *}
                    <td>{translate id=date}</td>
                    <td><input type="text" name="{$round->id}_date" value="{$round->starttime|date_format:"%Y-%m-%d %H:%M"}" /></td>
                </tr>
                <tr>
                    <td>{translate id=starttype}</td>
                    <td>
                        <input type="radio" name="{$round->id}_starttype" value="sequential"
                               {if $round->starttype=='sequential'} checked="checked"{/if} /> {translate id=sequential} <br />
                        <input type="radio" name="{$round->id}_starttype" value="simultaneous"
                               {if $round->starttype=='simultaneous'} checked="checked"{/if}
                               /> {translate id=simultaneous} <br />
                    </td>
                    
                </tr>
                <tr>                   
                    <td>{translate id=group_interval}</td>
                    <td><input type="text" name="{$round->id}_interval" value="{$round->interval}" /></td>
                </tr>
                <tr>                   
                    
                    <td colspan="2">
                        <input type="checkbox" name="{$round->id}_valid" {if $round->validresults}checked="checked"{/if} />
                        {translate id=round_valid}
                    </td>
                </tr>
                <tr>
                    <td>{translate id=round_course}</td>
                    <td>
                        <select name="{$round->id}_course">
                            <option value="">{translate id=select_none}</option>
                            {foreach from=$courses item=course}
                                <option value="{$course.id}" {if $round->course == $course.id}selected="selected"{/if}>{$course.Name|escape} </option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
            </table>
            
        </div>
    {/foreach}
    
    <div  class="buttonarea">
        <input type="submit" value="{translate id=save}" />
        <input type="submit" name="cancel" value="{translate id=cancel}" />
    </div>
</form>

{include file=include/footer.tpl}