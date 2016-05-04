<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
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

require_once 'data/db.php';
require_once 'data/configs.php';


/**
 * Stores or removes the event fee payment of a single player
 */
function MarkEventFeePayment($eventid, $participationid, $payment)
{
    $eventid = esc_or_null($eventid, 'int');
    $participationId = esc_or_null($participationid, 'int');
    $payment = $payment ? time() : "NULL";

    return db_exec("UPDATE :Participation
                            SET EventFeePaid = FROM_UNIXTIME($payment), Approved = 1
                            WHERE id = $participationid AND Event = $eventid");
}


function EventRequiresLicenses($eventid)
{
    $eventid = esc_or_null($eventid, 'int');

    $row = db_one("SELECT LicensesRequired FROM :Event WHERE id = $eventid");

    if (db_is_error($row))
        return $row;

    return $row['LicensesRequired'];
}
