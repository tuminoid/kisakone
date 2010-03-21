{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Printable score card
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
      <title>{translate id=site_name}</title>
      <link rel="stylesheet" href="{$url_base}ui/elements/style.css" type="text/css" />
      
 <style type="text/css">{literal}
 table {
   border-collapse: collapse;
 }
 html, body {
      padding: 4px;
 }
 
 td,th  {
   border: 1px solid black;
   text-align: center;
   padding: 3px;
 }
 
 .out, .in {
   background-color: #DDD;
 }
 
 #last_head_row th {
   border-bottom: 2px solid black;
 }
 
 .autowidth {
   width: auto !important;
 }
 
 
 .group {
      page-break-inside: avoid;
      
      margin-bottom: 80px;
 }
 
 .sign_row {
      text-align: right;
      padding-right: 300px;
 }
 
 .endofpage {
      page-break-after: always;
 }
 
 .noprint {
      background-color: #eee;
      padding: 16px;
      margin: 16px;
 }
 
 .sign {
      min-width: 160px;
 }
 {/literal}
 
 td {ldelim}
   width: {$hole_percentage}%;
   height: 2em;
 {rdelim}
 </style>
 <style type="text/css" media="print">
 .noprint {ldelim} display: none; {rdelim}
 body {ldelim}
      font-size: 0.8em;
      
       {rdelim}
 </style>
</head>

 {math assign=hole_percentage equation="75 / (x+4)" x=$numHoles}
 {assign var=perpage value=$smarty.get.perpage}
 {if !($perpage % 99)}{assign var=perpage value=3}{/if}
 
 
<body>
      {assign var=signature value=$smarty.get.signature}
<div class="noprint">
      <form method="get">
            {initializeGetFormFields signature=false perpage=false}
      <p>{translate id=scorecard_sign_help}</p>
      <ul class="nobullets">
            <li><input type="radio" name="signature" value="" {if $signature == ''}checked="checked"{/if} /> {translate id=signature_none}</li>
            <li><input type="radio" name="signature" value="column" {if $signature == 'column'}checked="checked"{/if} /> {translate id=signature_column}</li>
            <li><input type="radio" name="signature" value="row" {if $signature == 'row'}checked="checked"{/if} /> {translate id=signature_row}</li>
      </ul>
      <p>{translate id=scorecard_perpage} <input name="perpage"  type="text" value="{$perpage|escape}" /></p>
      <p><input type="submit" value="{translate id=update}" /></p>
      </form>
</div>
      
{foreach from=$groups item=group}
{counter assign=groupcounter}
<div class="group {if $groupcounter % $perpage == 0} endofpage{/if}">      
   {assign var=firstgroup value=$group.0}

   
   <h1>{$event->name}, {$event->venue} {$event->fulldate}</h1>
   <h3>{translate id=round_number    number=$round->roundNumber}, {$round->starttime|date_format:"%d.%m.%Y"}</h3>
   <h3>{translate id=group_number number=$firstgroup.PoolNumber},   
   {if $round->starttype=='sequential'}
   {capture assign=groupstart}{$firstgroup.StartingTime|date_format:"%H:%M"}{/capture}
   {translate id=group_starting start=$groupstart}
   {else}{translate id=your_group_starting_hole hole=$firstgroup.StartingHole}{/if}
   </h3>
      
    <table>
         
            <tr class="thr">
                <th class="rightside" colspan="2">
                    {translate id=hole_num}
                </th>
                {foreach from=$holes key=index item=hole}                
                        <th>{$hole->holeNumber}</th>
                        {if $hole->holeNumber == $out_hole_index}
                           <th class="out">{translate id=hole_out}</th>
                        {/if}
                {/foreach}
                <th class="in">{translate id=hole_in}</th>
                <th>+/-</th>
                <th>{translate id=total}</th>
                {if $signature == 'column'}
                <th rowspan="3" class="sign">{translate id=signature}</th>
                {/if}
            </tr>
            <tr class="thr">
                <th class="rightside" colspan="2">
                    {translate id=hole_par}
                </th>
                {assign var=combined value=0}
                {foreach from=$holes key=index item=hole}                
                        <th>{$hole->par}</th>
                        {math assign=combined equation="x+y" x=$combined y=$hole->par}
                        {if $hole->holeNumber == $out_hole_index}
                           {assign var=out value=$combined}
                           <th class="out">{$combined}</th>
                        {/if}
                {/foreach}
                
                <th class="in">{math equation="x-y" x=$combined y=$out}</th>
                <th>{$combined}</th>
                <th>{$combined}</th>
            </tr>
            
            <tr class="thr" id="last_head_row">
                <th class="rightside" colspan="2">
                    {translate id=hole_length}
                </th>
                {assign var=combined value=0}
                {foreach from=$holes key=index item=hole}                
                        <th>{$hole->length}</th>
                        {math assign=combined equation="x+y" x=$combined y=$hole->length}
                        {if $hole->holeNumber == $out_hole_index}
                           {assign var=out value=$combined}
                           <th class="out">{$combined}</th>
                        {/if}
                {/foreach}            
                
                <th class="in">{math equation="x-y" x=$combined y=$out}</th>
                <th></th>
                <th>{$combined}</th>
                
            </tr>
            
            
            {foreach from=$group key=index item=player}
            <tr>
                
                <td class="autowidth" {if $signature == 'row'} rowspan="2"{/if}>{math equation="x+1" x=$index}</td>
                <td class="autowidth" {if $signature == 'row'} rowspan="2"{/if}>
                    {$player.FirstName} {$player.LastName}
                </td>
                {foreach from=$holes key=index item=hole}                
                        <td></td>                        
                {/foreach}
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                {if $signature == 'column'}
                        <td></td>
                  {/if} 
                
            </tr>
            {if $signature == 'row'}
            <tr>
                  <td colspan="{math equation="x +4 " x=$numHoles}" class="sign_row">{translate id=signature}:</td>
       
            </tr>
            {/if}
            {/foreach}
        
    </table>
</div>
{/foreach}
</body>
</html>