<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010,2013 Kisakone projektiryhmä
 *
 * User details page
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
 * Initializes the variables and other data necessary for showing the matching template
 * @param Smarty $smarty Reference to the smarty object being initialized
 * @param Error $error If input processor encountered a minor error, it will be present here
 */
if (!is_callable('InitializeSmartyVariables')) {
   function InitializeSmartyVariables(&$smarty, $error) {
      return User_InitializeSmartyVariables($smarty, $error);
      
   }
   /**
    * Determines which main menu option this page falls under.
    * @return String token of the main menu item text.
    */
   function getMainMenuSelection() {
       return 'users';
   }
}

function User_InitializeSmartyVariables(&$smarty, $error) {

   $getId = $_GET['id'];
   if (is_numeric($getId)) $userid= $getId;
   else $userid = GetUserId($getId);
   
   if (!$userid) return Error::NotFound('user');
   
   $user = GetUserDetails($userid);
   if (is_a($user, 'Error')) return $user;
 
   if (!$user) return Error::NotFound('user_record');
   
   
   $player = $user->GetPlayer();
   
   $smarty->assign('userinfo', $user);
   $smarty->assign('player', $player);
   
   $itsme = $user->username == @$_SESSION['user']->username;
   $smarty->assign('itsme', $itsme);
   
   if ($itsme) {
      $ad = GetAd(null, 'myinfo');
      if ($ad) $smarty->assign('ad', $ad);
   }
   
   if (IsAdmin() || $itsme) {
      if (OVERRIDE_PAYMENTS) {
         $fees = array('membership' => array(), 'aLicense' => array(), 'bLicense' => array());
         
         $currentYear = date('Y');
         $years = array($currentYear, $currentYear + 1);
         foreach ($years as $year) {
            list($aLicense, $membership, $bLicense) = SFL_FeesPaidForYear($user->id, $year);
            $fees['aLicense'][$year] = $aLicense;
            $fees['membership'][$year] = $membership;
            $fees['bLicense'][$year] = $bLicense;
         }
         
         $smarty->assign('fees', $fees);
      }
   }

   $smarty->assign('isadmin', @$_SESSION['user']->role == "admin");
}

?>
