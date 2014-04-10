{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013 Tuomo Tanskanen <tumi@tumi.fi>
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
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <title>{$title} - {translate id=site_name}</title>
      <link rel="stylesheet" href="{$url_base}css/style.css" type="text/css" />
      <link rel="apple-touch-icon" href="{$url_base}images/apple-touch-icon.png" />
      <script type="text/javascript" src="{$url_base}js/jquery/jquery-1.11.0.min.js"></script>
      <script type="text/javascript" src="{$url_base}javascript/base"></script>
      {if $ui}
      <script type="text/javascript" src="{$url_base}js/jquery/jquery-ui-1.10.4.custom.min.js"></script>
      <link rel="stylesheet" href="{$url_base}js/jquery/jquery-ui-1.10.4.custom.min.css" type="text/css" />
      <meta http-equiv="Content-Type" content="{$contentType}" />
      {/if}
      {if $timepicker}
      <script type="text/javascript" src="{$url_base}js/jquery/jquery-ui-timepicker-addon.min.js"></script>
      <script type="text/javascript" src="{$url_base}js/jquery/jquery-ui-sliderAccess.js"></script>
      <link rel="stylesheet" href="{$url_base}js/jquery/jquery-ui-timepicker-addon.min.css" type="text/css" />
      {/if}
      {if $autocomplete}
      <script type="text/javascript" src="{$url_base}js/jquery.autocomplete-min.js"></script>
      {/if}
      {if $analytics}
      <script type="text/javascript" src="{$url_base}js/analytics.js"></script>
      {/if}
      {$extrahead}
</head>
<body>
<table id="contentcontainer" cellpadding="0" cellspacing="0">
      <tr id="headtr">
            <td colspan="3">

      <div id="header">
      {include file="include/loginbox.tpl"}
      {if $smarty.get.languagebar }
            {* Disabled from normal use as we only have a single language *}
            {include file='include/languagebar.tpl'}
      {/if}
      <img id="sitelogo" src="{$url_base}images/sitelogo.png" alt="{translate id=site_name}" />

      <h1 id="sitename">{translate id=site_name_long}</h1>
      <div id="pagename">{$title}</div>
      </div>
      {include file="include/mainmenu.tpl"}
            </td></tr>
    <tr id="maintr2">
        <td id="submenucontainer">        <br />
            {$submenu_content}

            {include file="include/submenu.tpl"}
        </td>
        <td id="content">
