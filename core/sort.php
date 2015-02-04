<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * This file provides general functionality needed in the core module
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
 * */

/**
 * This function is used to convert fields names from database capitalized format
 * into the class field name format.
 *
 * Ie. db field User.Username
 * $field = core_ProduceFieldName("Username")
 * // $field == 'username'
 * $object->$field = $value  // works then
 *
 */
function core_sort_by_count($a, $b)
{
    $ac = count($a);
    $bc = count($b);
    if ($ac == $bc) return 0;
    if ($ac < $bc) return 1;
    return -1;
}

function data_string_in_array($string, $array)
{
   foreach ($array as $value)
      if ($string === $value)
         return true;

   return false;
}



function data_sort_leaderboard($a, $b)
{
   $ac = $a['Classification'];
   $bc = $b['Classification'];
   if ($ac != $bc) {
      if ($ac < $bc)
         return -1;
      return 1;
   }

   $astand = $a['Standing'];
   $bstand = $b['Standing'];
   if ($astand != $bstand) {
      if ($astand < $bstand)
         return -1;
      return 1;
   }

   $asd = $a['SuddenDeath'];
   $bsd = $b['SuddenDeath'];
   if ($asd != $bsd) {
      if ($asd < $bsd)
         return -1;
      return 1;
   }

   $ar = $a['Results'];
   $br = $b['Results'];

   $keys = array_reverse(array_keys($ar));
   foreach ($keys as $key) {
      $ae = @$ar[$key]['Total'];
      $be = @$br[$key]['Total'];
      if ($ae != $be) {
         if ($ae < $be)
            return -1;
         return 1;
      }
   }

   $as = $ar[$keys[0]]['StartId'];
   $bs = $br[$keys[0]]['StartId'];
   if ($as < $bs)
      return -1;
   return 1;
}


function data_Result_Sort($a, $b)
{
   $dnfa = (bool) $a['DidNotFinish'];
   $dnfb = (bool) $b['DidNotFinish'];
   if ($dnfa != $dnfb) {
      if ($dnfa)
         return 1;
      return -1;
   }

   $compa = $a['Completed'];
   $compb = $b['Completed'];
   if ($compa != $compb && ($compa == 0 || $compb == 0)) {
      if ($compa == 0)
         return 1;
      return -1;
   }

   $cpma = $a['CumulativePlusminus'];
   $cpmb = $b['CumulativePlusminus'];
   if ($cpma != $cpmb) {
      if ($cpma > $cpmb)
         return 1;
      return -1;
   }

   $sda = $a['SuddenDeath'];
   $sdb = $b['SuddenDeath'];
   if ($sda != $sdb) {
      if ($sda < $sdb)
         return -1;
      return 1;
   }

   global $data_extraSortInfo;
   foreach ($data_extraSortInfo as $round) {
      $ad = @$round[$a['PlayerId']];
      $bd = @$round[$b['PlayerId']];

      if ($ad == null && $bd == null)
         continue;
      if ($ad == null || $bd == null) {
         if ($ad == null)
            return 1;
         return -1;
      }

      if ($ad['Result'] != $bd['Result']) {
         if ($ad['Result'] < $bd['Result'])
            return -1;
         return 1;
      }
   }

   foreach ($data_extraSortInfo as $round) {
      $ad = @$round[$a['PlayerId']];
      $bd = @$round[$b['PlayerId']];

      if ($ad == null && $bd == null)
         continue;

      if ($ad['StartId'] < $bd['StartId'])
         return -1;

      return 1;
   }
}


