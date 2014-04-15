{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Help
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
{if $smarty.get.inline}
<?xml version="1.0" ?>
<div>
{* Note: in inline form this is actually XML rather than XHTML -- the conversion
is done on browser *}
{capture assign=fullhelpfile}help/{$helpfile}.tpl{/capture}
{include file=$fullhelpfile}
</div>
{else}
{*
* This file defines the contents of the main page.
*}
{translate assign=title id=help_title}
{include file='include/header.tpl'}


{capture assign=fullhelpfile}help/{$helpfile}.tpl{/capture}
{include file=$fullhelpfile}

<script type="text/javascript">
    //<![CDATA[
    {literal}
$("document").ready(function() {
   $("#helplink").parent().remove();
   $("#helpcontainer").remove();
   DisplayHelp = DisplayHelp_Local;

});

function DisplayHelp_Local(helpfile) {
    alert('x');
    //document.location = "http://10.0.0.12";
}
{/literal}

// ]]>
</script>

{include file='include/footer.tpl'}

{/if}