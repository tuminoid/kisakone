{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmº
 *
 * Language selection bar (not in use)
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
 * along *}

{* Should be moved to stylesheet if taken into use *}
<style type="text/css">{literal}
    .languagebar {
        float: right;
        text-align: center;
        width: auto !important;

    }

    .languagebar td {
        vertical-align: middle;

    }
{/literal}</style>
<table class="languagebar">
<tr><td>
{if $language=='fi-FI'}
    {translate id=language-fi-FI}
{else}
    <a href="?action=set_language&amp;language=fi-FI">{translate id=language-fi-FI}</a>
{/if}
</td><td>
{if $language=='sv'}
    {translate id=language-sv}
{else}
    <a href="?action=set_language&amp;language=sv">{translate id=language-sv}</a>
{/if}
</td><td><a href="?action=set_language&amp;language=RESET">[RESET_LANGUAGE]</a></td>
</tr></table>