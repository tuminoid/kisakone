{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Participant list export to TSV for exporting to PDGA Tour Manager
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
 {if $mode == "head"}

<style type="text/css">{literal}
    .resultrow td, .resultrow th {
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        text-align: center;
        margin: 0;
    }

    .results td, .results th {
        background-color: #EEE;
        text-align: center;
        border: 2px solid white;
    }

    .round_selection_table .selected {
        background-color: #DDD;
    }

    .results {
        border-collapse: collapse;
    }

    .rightside {
        text-align: right !important;
    }
    .leftside {
        text-align: left !important;
    }

    .sdtd {
        background-color: white !important;
    }

    .sd {
        background-color: #EEE !important;
        font-weight: bold;
        min-width: 16px;
    }

{/literal}</style>
{else}
 <div id="event_content">
    {$page->formattedText}
</div>


{assign var=extrahead value=$xtrahead}
<p class="preliminary" style="display: none">
    {translate id=preliminary_results}
</p>

<p class="searcharea">{translate id=participant_cvs_help}</p>

<textarea cols=120 rows=140>
{counter assign=rowind start=-1}{foreach from=$resultsByClass key=class item=results}
{foreach from=$results item=result}{counter assign=rowind}{if $rowind == 0}
{translate id=result_division}{""|indent:1:"\t"}{translate id=result_firstname}{""|indent:1:"\t"}{translate id=result_lastname}{""|indent:1:"\t"}PDGA{""|indent:1:"\t"}
{/if}
{$result.classShort}{""|indent:1:"\t"}{$result.user->firstname|escape}{""|indent:1:"\t"}{$result.user->lastname|escape}{""|indent:1:"\t"}{$result.player->pdga|escape}{""|indent:1:"\t"}
{/foreach}
{/foreach}
{/if}
</textarea>

