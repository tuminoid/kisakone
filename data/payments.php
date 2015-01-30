<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Payments
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

require_once 'data/db_init.php';


function GetFeePayments($relevantOnly = true, $search = '', $sortedBy = '', $forcePlayer = null)
{
   require_once 'core/player.php';

   if ($forcePlayer)
      $search = format_query( ":Player.player_id = %d", (int) $forcePlayer);
   else
      $search = data_ProduceSearchConditions($search, array('FirstName', 'LastName', 'pdga', 'Username'));

   $sortOrder = data_CreateSortOrder($sortedBy, array('name' => array('LastName', 'FirstName'), 'LastName' => true, 'FirstName' => true, 'pdga', 'gender' => 'sex', 'Username'));
   $year = date("Y");

   $query = "SELECT :User.id AS UserId, Username, Role, FirstName, LastName, Email,
                                :Player.player_id AS PlayerId, pdga PDGANumber, sex Sex, YEAR(birthdate) YearOfBirth,
                                :MembershipPayment.Year AS MSPYear,
                                :LicensePayment.Year AS LPYear
                  FROM :User
                  INNER JOIN :Player ON :Player.player_id = :User.Player
                  LEFT JOIN :MembershipPayment ON :MembershipPayment.Player = :Player.player_id ".($relevantOnly ? "AND :MembershipPayment.Year >= $year " : "")."
                  LEFT JOIN :LicensePayment ON :LicensePayment.Player = :Player.player_id".($relevantOnly ? " AND :LicensePayment.Year >= $year" : "").
                   " WHERE %s
                   ORDER BY %s, UserId, :MembershipPayment.Year, :LicensePayment.Year";

   $query = format_query($query, $search, $sortOrder);
   $result = execute_query($query);

   $userid = -1;
   $pdata = array();
   $retValue = array();

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         if ($userid != $row['UserId']) {
            if (!empty($pdata)) {
               if (!isset($pdata['licensefees'][$year ]))
                  $pdata['licensefees'][$year] = false;
               if (!isset($pdata['licensefees'][$year + 1]))
                  $pdata['licensefees'][$year + 1] = false;

               if (!isset($pdata['membershipfees'][$year ]))
                  $pdata['membershipfees'][$year] = false;
               if (!isset($pdata['membershipfees'][$year + 1]))
                  $pdata['membershipfees'][$year + 1] = false;

               ksort($pdata['membershipfees']);
               ksort($pdata['licensefees']);

               $retValue[] = $pdata;
            }

            $userid = $row['UserId'];
            $pdata = array();

            $pdata['user'] = new User($row['UserId'], $row['Username'], $row['Role'], $row['FirstName'], $row['LastName'], $row['Email'], $row['PlayerId']);
            $pdata['player'] = new Player($row['PlayerId'], $row['PDGANumber'], $row['Sex'], $row['YearOfBirth'], $row['FirstName'], $row['LastName'], $row['Email']);
            $pdata['licensefees'] = array();
            $pdata['membershipfees'] = array();
         }

         if ($row['MSPYear'] != null)
            $pdata['membershipfees'][$row['MSPYear']] = true;

         if ($row['LPYear'] != null)
            $pdata['licensefees'][$row['LPYear']] = true;
      }

      if (!empty($pdata)) {
         if (!isset($pdata['licensefees'][$year ]))
            $pdata['licensefees'][$year] = false;
         if (!isset($pdata['licensefees'][$year + 1]))
            $pdata['licensefees'][$year + 1] = false;

         if (!isset($pdata['membershipfees'][$year ]))
            $pdata['membershipfees'][$year] = false;
         if (!isset($pdata['membershipfees'][$year + 1]))
            $pdata['membershipfees'][$year + 1] = false;

         ksort($pdata['membershipfees']);
         ksort($pdata['licensefees']);

         $retValue[] = $pdata;
      }
   }
   mysql_free_result($result);

   return $retValue;
}


/**
 * Stores or removes the event fee payment of a single player
 */
function MarkEventFeePayment($eventid, $participationId, $payment)
{
   $query = format_query("UPDATE :Participation SET EventFeePaid = FROM_UNIXTIME(%s), Approved = 1 WHERE id = %d AND Event = %d",
                          ($payment ? time() : "NULL"), (int) $participationId, (int) $eventid);
   $result = execute_query($query);

   if (!$result)
      return Error::Query($query);
}


function StorePayments($payments)
{
   foreach ($payments as $userid => $payments) {
      $user = GetUserDetails($userid);
      $playerid = $user->player;

      if (isset($payments['license'])) {
         foreach ($payments['license'] as $year => $paid) {
            $query = format_query("DELETE FROM :LicensePayment WHERE Player = %d AND Year = %d", $playerid, $year);
            execute_query($query);

            if ($paid) {
               $query = format_query("INSERT INTO :LicensePayment (Player, Year) VALUES (%d, %d)", $playerid, $year);
               execute_query($query);
            }
         }
     }

     if (isset($payments['membership'])) {
         foreach ($payments['membership'] as $year => $paid) {
            $query = format_query("DELETE FROM :MembershipPayment WHERE Player = %d AND Year = %d", $playerid, $year);
            execute_query($query);

            if ($paid) {
               $query = format_query("INSERT INTO :MembershipPayment (Player, Year) VALUES (%d, %d)", $playerid, $year);
               execute_query($query);
            }
         }
      }
   }
}


/**
*Determines if license and membership fees have been paid for a given year
* Suggested usage:
* list($license, $membership) = GetUserFees($playerid, $year);
*/
function GetUserFees($playerid, $year)
{
   $query = format_query("SELECT 1 FROM :LicensePayment WHERE Player = %d AND Year = %d",
                      $playerid, $year);
   $result = execute_query($query);
   $license = mysql_num_rows($result);
   mysql_free_result($result);

   $query = format_query("SELECT 1 FROM :MembershipPayment WHERE Player = %d AND Year = %d",
                      $playerid, $year);
   $result = execute_query($query);
   $membership = mysql_num_rows($result);
   mysql_free_result($result);

   return array($license, $membership);
}


function EventRequiresFees($eventid)
{
   $query = format_query("SELECT FeesRequired FROM :Event WHERE id = %d", $eventid);
   $result = execute_query($query);

   $row = mysql_fetch_assoc($result);
   mysql_free_result($result);

   return $row['FeesRequired'];
}


