<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2013 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Configuration options.
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

// Yes, we use SFL for payment checks
// Affects menu choices etc
define("USE_SFL_PAYMENTS", true);

// ignore payment status, ie return as if everything is paid (useful for clubs, debug etc)
define("IGNORE_PAYMENTS", false);

// defines for licences, mandated by SFL membership database
define("LICENSE_MEMBERSHIP", 1);
define("LICENSE_A", 2);
define("LICENSE_B", 6);

?>
