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
require_once 'core/player.php';
require_once 'data/config.php';


function payment_enabled() {
    return GetConfig(PAYMENT_ENABLED);
}


/**
 * Stores or removes the event fee payment of a single player
 */
function MarkEventFeePayment($eventid, $participationId, $payment)
{
    $eventid = (int) $eventid;
    $participationId = (int) $participationId;
    $payment = $payment ? time() : "NULL";

    $query = format_query("UPDATE :Participation
                            SET EventFeePaid = FROM_UNIXTIME($payment), Approved = 1
                            WHERE id = $participationId AND Event = $eventid");
    $result = execute_query($query);

    if (!$result)
        return Error::Query($query);
}



function EventRequiresLicenses($eventid)
{
    $eventid = (int) $eventid;

    $query = format_query("SELECT LicensesRequired FROM :Event WHERE id = $eventid");
    $result = execute_query($query);

    $retVal = null;
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_assoc($result);
        $retVal = $row['LicensesRequired'];
    }
    mysql_free_result($result);

    return $retVal;
}
