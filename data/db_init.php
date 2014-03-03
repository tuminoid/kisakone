<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Data access module. Access the database server directly.
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

   // Connects to the database
   function InitializeDatabaseConnection()
   {
      $retValue = null;
      global $settings;
      $con = @mysql_connect($settings['DB_ADDRESS'], $settings['DB_USERNAME'], $settings['DB_PASSWORD']);

      if (!($con && @mysql_select_db($settings['DB_DB']))) {
         $retValue = new Error();
         $retValue->isMajor = true;
         $retValue->title = 'error_db_connection';
         $retValue->description = translate('error_db_connection_description');
      }

      return $retValue;
   }
