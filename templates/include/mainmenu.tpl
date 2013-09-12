{*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmº
 *
 * Main menu
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
{assign var='test' value='a & b'}
<ul id="mainmenu">

    {section name=menuitem loop=$mainmenu}
    <li {if $mainmenuselection eq $mainmenu[menuitem].title} class="selected"{/if}>
        <a
           href="{url page=$mainmenu[menuitem].url}">{translate id=$mainmenu[menuitem].title}</a> 
    </li>
    {/section}
    {* help disabled due to there being no help files 
    <li style="float: right; border-left: 1px outset gray; border-right: 1px outset gray; margin: 2px; height: 28px;" >
        
        <a id="helplink" href="{url extend_current=true showhelp=1}"><span id="helpfile" style="display: none">{$helpfile|escape}</span>            
            {translate id=mainmenu_help}</a> 
    </li>*}
</ul>
