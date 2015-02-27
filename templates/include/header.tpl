{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Layout before content
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
<!doctype html>
<html lang="fi-FI">
<meta charset="utf-8">

<title>{$title} - {translate id=site_name}</title>

<link rel="stylesheet" href="{$url_base}css/style.css">
<link rel="apple-touch-icon" href="{$url_base}images/apple-touch-icon.png">
<script src="{$url_base}js/jquery-1.11.2.min.js"></script>
<script src={if $mod_rewrite}"{$url_base}javascript/base"{else}"{$url_base}index.php?page=javascript/base"{/if} defer></script>

<link rel="stylesheet" href="{$url_base}css/flag-icon/css/flag-icon.min.css">

{if $ui}
<script src="{$url_base}js/jquery-ui-1.11.2.min.js" defer></script>
<link rel="stylesheet" href="{$url_base}js/jquery-ui-lightness/jquery-ui.min.css">
{/if}
{if $timepicker}
<script src="{$url_base}js/jquery/jquery-ui-timepicker-addon.min.js" defer></script>
<script src="{$url_base}js/jquery/jquery-ui-sliderAccess.js" defer></script>
<link rel="stylesheet" href="{$url_base}js/jquery/jquery-ui-timepicker-addon.min.css">
{/if}
{if $autocomplete}
<script src="{$url_base}js/jquery/jquery.autocomplete-min.js" defer></script>
{/if}
{if $tooltip}
{literal}<script>$(function() { $( document ).tooltip(); });{/literal} </script>
{/if}
{if $analytics}
<script src="{$url_base}js/analytics.js" defer></script>
{/if}
{if $trackjs}
<script src="https://d2zah9y47r7bi2.cloudfront.net/releases/current/tracker.js" data-token="{$trackjs}" defer></script>
{/if}
{if $calendar}
<script src="{$url_base}js/addthisevent/ate.min.js" defer></script>
<link rel="stylesheet" href="{$url_base}js/addthisevent/ate.css" />
{/if}
{$extrahead}
<meta name="x-kisakone-version" content="{$kisakone_version}">

<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<body>

<table id="contentcontainer" cellpadding="0" cellspacing="0">
    <tr id="headtr">
    <td colspan="3">
        <header id="header">
            {include file="include/loginbox.tpl"}
            {if $smarty.get.languagebar }
                {* Disabled from normal use as we only have a single language *}
                {include file='include/languagebar.tpl'}
            {/if}
            <img id="sitelogo" src="{$url_base}images/sitelogo.png" alt="{translate id=site_name}" />

            <h1 id="sitename">{translate id=site_name_long}</h1>
            <div id="pagename">{$title}</div>
        </header>
    {include file="include/mainmenu.tpl"}
    </td>
    </tr>

    <tr id="maintr2">
        <td id="submenucontainer">        <br />
            {$submenu_content}

            {include file="include/submenu.tpl"}
        </td>
        <td id="content">
