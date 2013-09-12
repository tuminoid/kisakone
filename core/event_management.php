<?php
/**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * This file defines functions used for manageing events
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

/** ****************************************************************************
 * Function for signing up a user to an event
 *
 * Returns null for success or an Error object in case the signup fails
 *
 * @param int $eventId
 * @param int $userId
 * @param int $classId
 */
function SignUpUser( $eventId, $userId, $classId)
{
    $playerid = null;
    
    $player = GetUserPlayer( $userId);
    if( isset( $player))
    {
        $retValue = SetPlayerParticipation( $player->id, $eventId, $classId);
    }
    else
    {
        $retValue = new Error();
        $retValue->title = "error_invalid_argument";
        $retValue->description = translate( "error_invalid_argument_description");
        $retValue->internalDescription = "Invalid user id, no corresponding player found";
        $retValue->function = "SignUpUser()";
        $retValue->IsMajor = true;
        $retValue->data = "User id: " . $userId;
    }
    
    return $retValue;
}

/** ****************************************************************************
 * Function for marking event participation fee payment
 *
 * Returns null for success or an Error object in case of an error
 *
 * @param int  $participationId
 * @param bool $newfee
 */
function MarkEventFeePayments($eventId, $payments)
{
    $errors = array();
    $retValue = null;
    
    foreach ($payments as $payment) {
        $outcome = MarkEventFeePayment($eventId, $payment['participationId'], $payment['payment']);
        if (is_a($outcome, 'Error')) {
            $errors[] = $outcome;
        }
    }
    if (count($errors)) {
        $retValue = $errors[0];
    }
    return $retValue;
}
/* ****************************************************************************
 * End of file
 * */
?>