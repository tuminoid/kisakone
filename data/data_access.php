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

require_once 'data/db_init.php';

/* ****************************************************************************
 * Utility data structures and functions
 *
 * */

   // Returns $param as a database safe string surrounded by apostrophes
   // Returns 'NULL' if $param is null
   // The type controls how the parameter should be escaped
   function esc_or_null($param, $type = 'string')
   {
      $retValue = "NULL";

      if ($param !== null) {
         switch ($type) {
            case 'string':
               $retValue = "'".mysql_real_escape_string($param)."'";
               break;
            case 'long':
            case 'int':
               $retValue = (int) $param;
               break;
            case 'double':
            case 'float':
            case 'decimal':
               $retValue = (float) $param;
               break;
            case 'gender':
               $param = strtoupper($param);
               if ($param == 'M' || $param == 'F') {
                  $retValue = "'".$param."'";
               }
               break;
            case 'bool':
               if ($param) {
                  $retValue = 1;
               } else {
                  $retValue = 0;
               }
            default:
               echo "Unknown type in function esc_or_null: $type (param = $param)";
               die();
               break;
         }
      }

      return $retValue;
   }

   // Returns a User object if $username and $password matched a user in the database
   // Returns null if no match was found
   // Returns an Error object if there was a connection error or if the user is banned
   function CheckUserAuthentication($username, $password)
   {
      if (empty($username) || empty($password)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = null;

      $usr = mysql_real_escape_string($username);
      $pw = md5($password);

      $query = data_query("SELECT id, Username, UserEmail, Role, UserFirstname, UserLastname,
                                       :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM, Player
                                       FROM :User
                                       LEFT JOIN :Player ON :User.Player = :Player.player_id
                                       WHERE Username = '%s' AND Password = '%s'", $usr, $pw);

      $result = mysql_query($query);
      if (!$result) return Error::Query($query);

      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         if (strpos($row['Role'], 'ban') !== false) {
            $error = new Error();
            $error->title = 'banned';
            $error->description = translate('banned2');
            $error->isMajor= true;

            return $error;
         }
         $retValue = new User($row['id'], $row['Username'] , $row['Role'],
                              data_GetOne($row['UserFirstname'], $row['pFN']),
                              data_GetOne($row['UserLastname'], $row['pLN']),
                              data_GetOne($row['UserEmail'], $row['pEM']), $row['Player']);
      }
      mysql_free_result($result);

      return $retValue;
   }

/* ****************************************************************************
 * Functions for retrieving data
 *
 * */

   // Gets the user id for the username
   // Returns null if the user was not found
   function GetUserId($username)
   {
      if (empty($username)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $uname = mysql_real_escape_string($username);

      $query = data_query("SELECT id FROM :User WHERE Username = '$uname'");
      $result = mysql_query($query);

      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $retValue = $row['id'];
      }
      mysql_free_result($result);

      return $retValue;
   }

   // Returns true if the user is a staff member in any tournament
   function UserIsManagerAnywhere($userid)
   {
      if (empty($userid)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = false;
      $userid = (int) $userid;

      $query = data_query("SELECT :User.id FROM :User
                            INNER JOIN :EventManagement ON :User.id = :EventManagement.User
                            WHERE :User.id = $userid AND (:EventManagement.Role = 'TD' OR :EventManagement.Role = 'Official')");
      $result = mysql_query($query);

      if (!$result) return Error::Query($query);

      if (mysql_num_rows($result) == 1) {
         $retValue = true;
      }
      mysql_free_result($result);

      return $retValue;
   }

   // Returns a User object for the user whose email is $email
   // Returns null if no user was found
   function GetUserIdByEmail($email)
   {
      if (empty($email)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $email = mysql_real_escape_string($email);
      // Note: email is not indexed, but this is such a rare query so we'll just let mysql scan the table

      // Todo: use :Player.email? not really necessary though
      $result = mysql_query(data_query("SELECT id FROM :User WHERE UserEmail = '$email'"));

      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $retValue = $row['id'];
      }
      mysql_free_result($result);

      return $retValue;
   }

   // Returns an array of User objects
   function GetUsers($searchQuery = '', $sortOrder = '')
   {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = array();

      $query = "SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname, :User.Player,
               :Player.lastname pLN, :Player.firstname pFN, :Player.email pEM
      FROM :User
      LEFT JOIN :Player ON :User.Player = :Player.player_id
      ";

        $query .= " WHERE %s " ;

      if ($sortOrder) {
        $query .= " ORDER BY " . data_CreateSortOrder($sortOrder, array('name' => array('UserLastname', 'UserFirstname'), 'UserFirstname', 'UserLastname', 'pdga', 'Username' ));
      } else {
        $query .= " ORDER BY Username";
      }
      $prefix = $GLOBALS['settings']['DB_PREFIX'];
      $query = data_query($query, data_ProduceSearchConditions($searchQuery, array('UserFirstname', 'UserLastname', 'Username', $prefix . 'Player.lastname', $prefix. 'Player.firstname')));

      $result = mysql_query($query);


      if (!$result) return Error::Query($query);

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $temp = new User($row['id'], $row['Username'], $row['Role'],
                             data_GetOne( $row['UserFirstname'], $row['pFN']),
                             data_GetOne( $row['UserLastname'], $row['pLN']),
                             data_GetOne( $row['UserEmail'], $row['pEM']), $row['Player']
                             );
            $retValue[] = $temp;
         }
      }
      mysql_free_result($result);

      return $retValue;
   }

   // Returns an array of User objects for users who are also Players
   // (optionally filtered by search conditions provided in $query)
   function GetPlayerUsers($query = '', $sortOrder = '')
   {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = array();
      $searchConditions = data_ProduceSearchConditions($query, array('Username', 'pdga', 'UserFirstname', 'UserLastname'));

      $query = (data_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname, Player FROM :User
                                       INNER JOIN :Player ON :Player.player_id = :User.Player
                            WHERE :User.Player IS NOT NULL AND %s", $searchConditions));

      if ($sortOrder) {
        $query .= " ORDER BY " . data_CreateSortOrder($sortOrder, array('name' => array('UserLastname', 'UserFirstname'), 'UserFirstname', 'UserLastname', 'pdga', 'Username' ));
      } else {
        $query .= " ORDER BY Username";
      }

      $result = mysql_query($query);

      if (!$result) {
        echo mysql_error();
      }
      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $temp = new User($row['id'], $row['Username'], $row['Role'], $row['UserFirstname'], $row['UserLastname'], $row['UserEmail'], $row['Player']);
            $retValue[] = $temp;
         }
      }
      mysql_free_result($result);

      return $retValue;
   }

   // Gets a User object by the PDGA number of the associated Player
   // Returns null if no user was found
   function GetUsersByPdga($pdga)
   {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $pdga = (int) $pdga;

      $retValue = array();

      $result = mysql_query(data_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname,
                            :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM
                            FROM :User
                            INNER JOIN :Player ON :Player.player_id = :User.Player WHERE :Player.pdga = '$pdga'
                            "));

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $temp = new User($row['id'], $row['Username'], $row['Role'],
                             data_GetOne($row['UserFirstname'], $row['pFN']),
                             data_GetOne($row['UserLastname'], $row['pLN']),
                             data_GetOne($row['UserEmail'], $row['pEM']));
            $retValue[] = $temp;
         }
      }
      mysql_free_result($result);

      return $retValue;
   }

   // Gets a User object by the id number
   // Returns null if no user was found
   function GetUserDetails($userid)
   {
      if (empty($userid)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $id = (int) $userid;

      $query = data_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname,
                                       :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM,
                                       :User.Player
                                       FROM :User
                                       LEFT JOIN :Player on :Player.player_id = :User.Player
                                       WHERE id = $id");
      $result = mysql_query($query);
      if (!$result) return Error::Query($query);
      if (mysql_num_rows($result) == 1) {

         $row = mysql_fetch_assoc($result);
         $retValue = new User($row['id'], $row['Username'], $row['Role'], data_GetOne($row['UserFirstname'], $row['pFN']), data_GetOne($row['UserLastname'], $row['pLN']), data_GetOne($row['UserEmail'], $row['pEM']), $row['Player']);
      }

      mysql_free_result($result);

      return $retValue;
   }

   // Returns an MD5 hash calculated from the User properties
   // Returns null if the user was not found
   function GetUserSecurityToken($userid)
   {
      if (empty($userid)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $id = (int) $userid;


      // Note: the hash of the user's password is included, so changing the password
      // invalidates the token, which is good.
      $result = mysql_query(data_query("SELECT * FROM :User WHERE id = $id"));

      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $text = '';

         foreach ($row as $field) $text .= $field;
         $retValue = substr(md5($text), 0, 10);
      }

      mysql_free_result($result);

      return $retValue;
   }

   // Gets an MD5 hash of the User properties
   function GetAutoLoginToken($userid)
   {
      if (empty($userid)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $id = (int) $userid;

      // Note: the hash of the user's password is included, so changing the password
      // invalidates the token, which is good.
      $result = mysql_query(data_query("SELECT * FROM :User WHERE id = $id"));

      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $text = '';

         foreach ($row as $field) $text .= $field;
         $retValue = md5($text);
      }

      mysql_free_result($result);

      return $retValue;
   }

   // Gets a Player object by id or null if the player was not found
   function GetPlayerDetails($playerid)
   {
      if (empty($playerid)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = null;
      $id = (int) $playerid;

      $result = mysql_query(data_query("SELECT player_id id, pdga PDGANumber, sex Sex, YEAR(birthdate) YearOfBirth
                                         FROM :Player
                                         WHERE player_id = $id"));

      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $retValue = new Player($row['id'], $row['PDGANumber'], $row['Sex'], $row['YearOfBirth']);
      }

      mysql_free_result($result);

      return $retValue;
   }

   // Gets a User object associated with Playerid
   function GetPlayerUser($playerid = null)
   {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      if ($playerid === null)
         return null;

      $playerid = (int) $playerid;
      $result = mysql_query(data_query("SELECT :User.id, Username, UserEmail, Role, UserFirstname, UserLastname,
                            :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM
                            FROM :User
                            INNER JOIN :Player ON :Player.player_id = :User.Player WHERE :Player.player_id = '$playerid'
                            "));

      if (mysql_num_rows($result) === 1) {
         while ($row = mysql_fetch_assoc($result)) {
            $temp = new User($row['id'], $row['Username'], $row['Role'],
                             data_GetOne($row['UserFirstname'], $row['pFN']),
                             data_GetOne($row['UserLastname'], $row['pLN']),
                             data_GetOne($row['UserEmail'], $row['pEM']), $playerid);

            return $temp;
         }
      }
      mysql_free_result($result);

      return null;
   }

   // Gets a Player object for the User by userid or null if the player was not found
   function GetUserPlayer($userid)
   {
      require_once 'core/player.php';
      if (empty($userid)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = null;
      $id = (int) $userid;

      $query = data_query("SELECT :Player.player_id id, pdga PDGANumber, sex Sex, YEAR(birthdate) YearOfBirth, firstname, lastname, email
                                         FROM :Player INNER JOIN :User ON :User.Player = :Player.player_id
                                         WHERE :User.id = $id");

      $result = mysql_query($query);
      if (!$result) return Error::Query($query);
      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $retValue = new Player($row['id'], $row['PDGANumber'], $row['Sex'], $row['YearOfBirth'], $row['firstname'], $row['lastname'], $row['email']);
      }

      return $retValue;
   }

   // Gets an array of Event objects where the conditions match
   function data_GetEvents($conditions, $sort_mode = null)
   {
      $retValue = array();
      $dbError = InitializeDatabaseConnection();

      if ($dbError) {
         return $dbError;
      }


      global $event_sort_mode;
      if ($sort_mode !== null) {
         $sort = "`$sort_mode`";
      } elseif (!$event_sort_mode) {
        $sort = "`Date`";
      } else {
        $sort = data_CreateSortOrder($event_sort_mode, array('Name', 'VenueName' => 'Venue', 'Date', 'LevelName'));
      }
      global $user;

      if ($user) {
         $uid = $user->id;
         $player = $user->GetPlayer();

         if (is_a($player, 'Error'))
            return $player;

         if ($player)
            $playerid = $player->id;
         else
            $playerid = -1; // -1 impossible normally


         $query = data_query("SELECT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament, Level, :Event.Name, UNIX_TIMESTAMP(Date) Date, Duration,
                               UNIX_TIMESTAMP(ActivationDate) ActivationDate, UNIX_TIMESTAMP(SignupStart) SignupStart, UNIX_TIMESTAMP(SignupEnd) SignupEnd, ResultsLocked,
                               :Level.Name LevelName,
                                    :EventManagement.Role AS Management, :Participation.Approved, :Participation.EventFeePaid, :Participation.Standing
                                         FROM :Event
                                         LEFT JOIN :EventManagement ON (:Event.id = :EventManagement.Event AND :EventManagement.User = $uid)
                                         LEFT JOIN :Participation ON :Participation.Event = :Event.id AND :Participation.Player = $playerid
                                         LEFT JOIN :Level ON :Event.Level = :Level.id
                                         INNER Join :Venue ON :Venue.id = :Event.Venue
                                         WHERE $conditions
                                         ORDER BY %s ", $sort);

      } else {

         $query = data_query("SELECT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament, Level, :Event.Name, UNIX_TIMESTAMP(Date) Date, Duration,
                               UNIX_TIMESTAMP(ActivationDate) ActivationDate, UNIX_TIMESTAMP(SignupStart) SignupStart, UNIX_TIMESTAMP(SignupEnd) SignupEnd, ResultsLocked,
                               :Level.Name LevelName
                                         FROM :Event
                                         INNER Join :Venue ON :Venue.id = :Event.Venue
                                         LEFT JOIN :Level ON :Event.Level = :Level.id
                                         WHERE $conditions
                                         ORDER BY %s ", $sort);
      }

      $result =mysql_query($query);

      if (!$result) {
         return Error::Query($query);
      }

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $temp = new Event($row);
            $retValue[] = $temp;
         }
      }
      mysql_free_result($result);

      return $retValue;
   }

   // Gets events for a specific tournament
   function GetTournamentEvents($tournamentId)
   {
      $tournamentId = (int) $tournamentId;

      $conditions = ":Event.Tournament = $tournamentId";

      return data_GetEvents($conditions);

   }

   // Gets the number of people who have signed up for a tournament
   function GetTournamentParticipantCount($tournamentId)
   {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = null;
      $tournamentId = (int) $tournamentId;

      $query = data_query("SELECT COUNT(DISTINCT :Participation.Player) Count FROM :Event
                     INNER JOIN :Participation ON :Participation.Event = :Event.id
                     WHERE :Event.Tournament = $tournamentId AND :Participation.EventFeePaid IS NOT NULL");

      $result = mysql_query($query);


      if (mysql_num_rows($result) > 0) {
         $temp = mysql_fetch_assoc($result);
         $retValue = $temp['Count'];
      } else {

      }
      mysql_free_result($result);

       return $retValue;
   }

   // Gets an Event object by ID or null if the event was not found
   function GetEventDetails($eventid)
   {
      // Often this method is called for the same event from many places. This is
    // a bit of a problem, so we'll cache the results to avoid unnecessary database access.
      static $cache;
      if ($eventid == "clear_cache") {
         $cache = array();

         return;
      }

      if (!is_array($cache))
         $cache = array();

      if (empty($eventid)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $id = (int) $eventid;

      if (array_key_exists($id, $cache))
         return $cache[$id];

      global $user;
      if ($user) {
         $uid = $user->id;
         $player = $user->GetPlayer();
         if ($player)
            $pid = $player->id;
         else
            $pid = -1;

         $query = data_query("SELECT DISTINCT :Event.id, :Venue.Name AS Venue, :Venue.id AS VenueID, Tournament, AdBanner, :Event.Name, ContactInfo,
                                         UNIX_TIMESTAMP(Date) Date, Duration, PlayerLimit, UNIX_TIMESTAMP(ActivationDate) ActivationDate, UNIX_TIMESTAMP(SignupStart) SignupStart,
                                         UNIX_TIMESTAMP(SignupEnd) SignupEnd, ResultsLocked,
                                         :EventManagement.Role AS Management, :Participation.Approved, :Participation.EventFeePaid, :Participation.Standing, :Level.id LevelId,
                                         :Level.Name Level, :Tournament.id TournamentId, :Tournament.Name Tournament, :Participation.SignupTimestamp
                                         FROM :Event
                                         LEFT JOIN :EventManagement ON (:Event.id = :EventManagement.Event AND :EventManagement.User = $uid)
                                         LEFT JOIN :Participation ON (:Participation.Event = :Event.id AND :Participation.Player = $pid)
                                         LEFT Join :Venue ON :Venue.id = :Event.Venue
                                         LEFT JOIN :Level ON :Level.id = :Event.Level
                                         LEFT JOIN :Tournament ON :Tournament.id = :Event.Tournament
                                         WHERE :Event.id = $id ");

      } else {
         $query = data_query("SELECT DISTINCT :Event.id id, :Venue.Name AS Venue, Tournament, AdBanner, :Event.Name, UNIX_TIMESTAMP(Date) Date, Duration, PlayerLimit, UNIX_TIMESTAMP(ActivationDate) ActivationDate, ContactInfo,
                               UNIX_TIMESTAMP(SignupStart) SignupStart, UNIX_TIMESTAMP(SignupEnd) SignupEnd, ResultsLocked, :Level.id LevelId, :Level.Name Level,
                               :Tournament.id TournamentId, :Tournament.Name Tournament
                                         FROM :Event
                                         LEFT JOIN :Level ON :Level.id = :Event.Level
                                         LEFT JOIN :Tournament ON :Tournament.id = :Event.Tournament
                                         LEFT Join :Venue ON :Venue.id = :Event.Venue
                                         WHERE :Event.id = $id ");
      }

      $result = mysql_query($query);
      if (mysql_error()) return Error::Query($query);

      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $retValue = new Event($row);
      }

      $cache[$id] = $retValue;
      mysql_free_result($result);

      return $retValue;
   }

   // Gets an array of strings containing Venue names that match the searchQuery
   function GetVenueNames($searchQuery = '')
   {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $query = "SELECT DISTINCT Name FROM :Venue";

         $query .= " WHERE %s";

      $query .= " ORDER BY Name";

      $query = data_query($query, data_ProduceSearchConditions($searchQuery, array('Name')));

      $result = mysql_query($query);

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {

            $retValue[] = $row['Name'];
         }
      }
      mysql_free_result($result);

      return $retValue;
   }

   // Gets an array of Tournament objects for a specific year
   function GetTournaments($year, $onlyAvailable = false)
   {
      require_once 'core/tournament.php';
      if ($year && ($year < 2000 || $year > 2100)) return Error::InternalError();

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

    $query = data_query("SELECT id, Level, Name, ScoreCalculationMethod, Year, Available FROM :Tournament WHERE 1 ");
    if ($year) {
      $year = (int) $year;
      $query .= " AND Year = $year ";
    }
    if ($onlyAvailable) {
         $query .= " AND Available <> 0";
    }

    $query .= " ORDER BY Year, Name";

    $retValue = array();
    $result = mysql_query($query);

    if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $retValue[] = new Tournament($row['id'], $row['Level'], $row['Name'], $row['Year'], $row['ScoreCalculationMethod'], $row['Available']);
      }
    }
    mysql_free_result($result);

    return $retValue;
   }

   // Gets an array of Level objects (optionally filtered by the Available bit)
   function GetLevels($availableOnly = false)
   {
      require_once 'core/level.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $query = "SELECT id, Name, ScoreCalculationMethod, Available FROM :Level";

      if ($availableOnly) {
         $query .= " WHERE Available <> 0";
      }
      $query = data_query($query);
      $result = mysql_query($query);

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $retValue[] = new Level($row['id'], $row['Name'], $row['ScoreCalculationMethod'], $row['Available']);
         }
      }
      mysql_free_result($result);

      return $retValue;
   }

   // Gets a Level object by id
   function GetLevelDetails($levelId)
   {
      require_once 'core/level.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $levelId = (int) $levelId;

      $result = mysql_query(data_query("SELECT id, Name, ScoreCalculationMethod, Available FROM :Level WHERE id = $levelId"));

      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $retValue = new Level($row['id'], $row['Name'], $row['ScoreCalculationMethod'], $row['Available']);
      }
      mysql_free_result($result);

      return $retValue;
   }

   // Gets an array of Classification objects (optionally filtered by the Available bit)
   function GetClasses($onlyAvailable = false)
   {
      require_once 'core/classification.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = array();

      $query = "SELECT id, Name, MinimumAge, MaximumAge, GenderRequirement, Available FROM :Classification";
      if ($onlyAvailable) {
         $query .= " WHERE Available <> 0";
      }
      $query .= " ORDER BY Name";
      $query = data_query($query);

      $result = mysql_query($query);
      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $retValue[] = new Classification($row['id'], $row['Name'], $row['MinimumAge'],
                                                      $row['MaximumAge'], $row['GenderRequirement'], $row['Available']);
         }
      }

        mysql_free_result($result);

      return $retValue;
   }

   // Gets a Classification object by id
   function GetClassDetails($classId)
   {
      require_once 'core/classification.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $classId = (int) $classId;

      $query = data_query("SELECT id, Name, MinimumAge, MaximumAge, GenderRequirement, Available FROM :Classification WHERE id = $classId");
      $result = mysql_query($query);
      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $retValue = new Classification($row['id'], $row['Name'], $row['MinimumAge'],
                                                      $row['MaximumAge'], $row['GenderRequirement'], $row['Available']);
      }

      mysql_free_result($result);

      return $retValue;
   }

   // Gets a Section object by id
   function GetSectionDetails($sectionId)
   {
      require_once 'core/section.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $sectionId = (int) $sectionId;

      $result = mysql_query(data_query("SELECT id, Name, Round, Priority, UNIX_TIMESTAMP(StartTime) StartTime, Present, Classification FROM :Section WHERE id = $sectionId"));

      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $retValue = new Section($row);
      }

      mysql_free_result($result);

      return $retValue;
   }

/**
 * Function for creating a new event
 *
 * Returns the new event id for success or
 * an Error in case there was an error in creating a new event.
 */
function CreateEvent($name, $venue, $duration, $playerlimit, $contact, $tournament, $level, $start,
                      $signup_start, $signup_end, $classes, $td, $officials, $requireFees)
{
    $retValue = null;

    $dbError = InitializeDatabaseConnection();
    if ($dbError) {
        return $dbError;
    }

    $query = data_query( "INSERT INTO :Event (Venue, Tournament, Level, Name, Date, Duration, PlayerLimit, SignupStart, SignupEnd, ContactInfo, FeesRequired) VALUES
                     (%d, %d, %d, '%s', FROM_UNIXTIME(%d), %d, %d, FROM_UNIXTIME(%s), FROM_UNIXTIME(%s), '%s', %d)",
                      esc_or_null($venue, 'int'), esc_or_null($tournament, 'int'), esc_or_null($level, 'int'), mysql_real_escape_string($name),
                      (int) $start, (int) $duration, (int) $playerlimit,
                      esc_or_null($signup_start, 'int'), esc_or_null($signup_end,'int'), mysql_escape_string($contact),
                      $requireFees );

    if ( mysql_query($query)) {
        $eventid = mysql_insert_id();
        $retValue = $eventid;

        $retValue = SetClasses( $eventid, $classes);
        if ( !is_a( $retValue, 'Error')) {
            $retValue = SetTD( $eventid, $td);
            if ( !is_a( $retValue, 'Error')) {
                $retValue = SetOfficials( $eventid, $officials);
            }
        }

    } else {
        return Error::Query($query, 'CreateEvent');
    }

    if (!is_a($retValue, 'Error')) {
      $retValue = $eventid;

    }

    return $retValue;
}

   // Edits users user and player information
   function EditUserInfo($userid, $email, $firstname, $lastname, $gender, $pdga, $dobyear)
   {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $user_query = data_query("UPDATE :User SET UserEmail = %s, UserFirstName = %s, UserLastName = %s WHERE id = %d",
                                      esc_or_null($email), esc_or_null(data_fixNameCase($firstname)), esc_or_null(data_fixNameCase($lastname)), (int) $userid);

      if (!mysql_query($user_query) ) {
          return Error::Query($user_query);
      }

      $u = GetUserDetails($userid);
      $player = $u->GetPlayer();
      if ($player) {
      $playerid = $player->id;

         $plr_query = data_query("UPDATE :Player SET sex = %s, pdga = %s,
                                 birthdate = '%s', firstname = %s, lastname = %s,
                                 email = %s

                                 WHERE player_id = %d",
                                       strtoupper($gender) == 'M' ? "'male'" : "'female'", esc_or_null($pdga, 'int'), (int) $dobyear . '-1-1',
                                       esc_or_null(data_fixNameCase($firstname)), esc_or_null(data_fixNameCase($lastname)), esc_or_null($email),
                                       (int) $playerid);

         if ( !mysql_query($plr_query)) {
             return Error::Query($plr_query);
         }
      }
   }

   // Gets Events by date
   function GetEventsByDate($start, $end)
   {
      $start = (int) $start;
      $end = (int) $end;

      return  data_GetEvents("Date BETWEEN FROM_UNIXTIME($start) AND FROM_UNIXTIME($end)");
   }

   // Get all Classifications in an Event
   function GetEventClasses($event)
   {
      require_once 'core/classification.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $event = (int) $event;

      $result = mysql_query(
         data_query("SELECT :Classification.id, Name, MinimumAge, MaximumAge, GenderRequirement, Available
                     FROM :Classification, :ClassInEvent
                     WHERE :ClassInEvent.Classification = :Classification.id AND
                           :ClassInEvent.Event = $event
                           ORDER BY Name"));

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $retValue[] = new Classification($row);
         }
         mysql_free_result($result);
      }

      return $retValue;
   }

   /* Get Quotas for Classes in Event */
   function GetEventQuotas($eventId)
   {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $event = (int) $eventId;

      // All classes as assoc array
      $result = mysql_query(
         data_query("SELECT :Classification.id, Name, :ClassInEvent.MinQuota, :ClassInEvent.MaxQuota
                     FROM :Classification, :ClassInEvent
                     WHERE :ClassInEvent.Classification = :Classification.id AND
                           :ClassInEvent.Event = $eventId
                           ORDER BY Name"));

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $retValue[] = $row;
         }
         mysql_free_result($result);
      }

      return $retValue;
   }

   // Return min and max quota for a class
   function GetEventClassQuota($eventid, $classid)
   {
      $quotas = GetEventQuotas($eventid);
      foreach ($quotas as $quota) {
         if ($quota['id'] == $classid)
            return array($quota['MinQuota'], $quota['MaxQuota']);
      }
      // not found, give defaults
      return array(0, 999);
   }

   // Set class's min quota
   function SetEventClassMinQuota($eventid, $classid, $quota)
   {
      $query = data_query("UPDATE :ClassInEvent SET MinQuota = %d WHERE Event = %d AND Classification = %d",
                    $quota, $eventid, $classid);
      $res = mysql_query($query);
      if (!$res)
         return Error::Query($query);
      return mysql_affected_rows() == 1;
   }

   // Set class's max quota
   function SetEventClassMaxQuota($eventid, $classid, $quota)
   {
      $query = data_query("UPDATE :ClassInEvent SET MaxQuota = %d WHERE Event = %d AND Classification = %d",
                    $quota, $eventid, $classid);
      $res = mysql_query($query);
      if (!$res)
         return Error::Query($query);
      return mysql_affected_rows() == 1;
   }

   // Get sections for a Round
   function GetSections($round, $order = 'time')
   {
      require_once 'core/section.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $roundId = (int) $round;

      $query = "SELECT :Section.id,  Name,
                            UNIX_TIMESTAMP(StartTime) StartTime, Priority, Classification, Round, Present

                                         FROM :Section

                                         WHERE :Section.Round = $roundId ORDER BY "

                                         ;

      if ($order == 'time') {
         $query .= "Priority, StartTime, Name";
         } else {
            $query .= "Classification, Name";
         }
         $query = data_query($query);
      $result = mysql_query($query);

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $retValue[] = new Section($row);
         }
      }

      mysql_free_result($result);

      return $retValue;
   }

   // Get rounds for an event by event id
   function GetEventRounds($event)
   {
      require_once 'core/round.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $event = (int) $event;

      $result = mysql_query(data_query("SELECT id, Event, Course, StartType,UNIX_TIMESTAMP(StartTime) StartTime,
                            `Interval`, ValidResults, GroupsFinished FROM :Round WHERE Event = $event ORDER BY StartTime"));

      if (mysql_num_rows($result) > 0) {
         $index = 1;
         while ($row = mysql_fetch_assoc($result)) {
            $newRound =  new Round($row['id'], $row['Event'], $row['StartType'], $row['StartTime'], $row['Interval'], $row['ValidResults'], 0, $row['Course'], $row['GroupsFinished']);
            $newRound->roundnumber = $index++;
            $retValue[] = $newRound;

         }
      }

      mysql_free_result($result);

      return $retValue;
   }

   // Get a Round object by id
   function GetRoundDetails($roundid)
   {
      require_once 'core/round.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = null;
      $id = (int) $roundid;

      $result = mysql_query(data_query("SELECT id, Event, Course, StartType,UNIX_TIMESTAMP(StartTime) StartTime, `Interval`, ValidResults, GroupsFinished FROM `:Round` WHERE id = $id ORDER BY StartTime"));

      if (mysql_num_rows($result) == 1) {
         while ($row = mysql_fetch_assoc($result)) {
            $retValue =  new Round($row['id'], $row['Event'], $row['StartType'], $row['StartTime'], $row['Interval'], $row['ValidResults'], 0, $row['Course'], $row['GroupsFinished']);

         }
      }

      mysql_free_result($result);

      return $retValue;
   }

   // Get event officials for an event
   function GetEventOfficials($event)
   {
      require_once 'core/event_official.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $event = (int) $event;

      $result = mysql_query(data_query("SELECT :User.id as UserId, Username, UserEmail, :EventManagement.Role, UserFirstname, UserLastname, Event ,
                                       :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM, Player
                                       FROM :EventManagement, :User
                                       LEFT JOIN :Player ON :User.Player = :Player.player_id
                                         WHERE :EventManagement.User = :User.id
                                         AND :EventManagement.Event = $event ORDER BY :EventManagement.Role DESC, Username ASC"));

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $tempuser = new User($row['UserId'], $row['Username'], $row['Role'],
                                 data_GetOne( $row['UserFirstname'], $row['pFN']),
                                 data_GetOne($row['UserLastname'], $row['pLN']),
                                 data_GetOne($row['UserEmail'], $row['pEM']),
                                 $row['Player']);

            $retValue[] = new EventOfficial($row['UserId'], $row['Event'], $tempuser, $row['Role']);
         }
      }

      mysql_free_result($result);

      return $retValue;
   }

   // Edit event information
   function EditEvent($eventid, $name, $venuename, $duration, $playerlimit, $contact, $tournament, $level, $start, $signup_start, $signup_end, $state, $requireFees)
    {
      $venueid = GetVenueId($venuename);
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      if ($state == 'active' || $state =='done') {
         $activation = time();

      } else {
         $activation = 'NULL';
      }

      if ($state =='done') {
        $locking = time();
      } else {
        $locking = 'NULL';
      }

      $query = data_query("UPDATE `:Event` SET `Venue` = %d, `Tournament` = %s, Level = %d, `Name` = '%s', `Date` = FROM_UNIXTIME(%d),
                       `Duration` = %d, `PlayerLimit` = %d, `SignupStart` = FROM_UNIXTIME(%s), `SignupEnd` = FROM_UNIXTIME(%s),
                       ActivationDate = FROM_UNIXTIME( %s), ResultsLocked = FROM_UNIXTIME(%s), ContactInfo = '%s', FeesRequired = %d

                       WHERE id = %d", $venueid,
                               esc_or_null($tournament, 'int'), $level, mysql_real_escape_string($name), (int) $start,
                               (int) $duration, (int) $playerlimit,
                               esc_or_null($signup_start,'int'), esc_or_null($signup_end,'int'), $activation,
                               $locking,
                               mysql_real_escape_string($contact),  $requireFees , (int) $eventid);

      if (!mysql_query($query)) {
            return Error::Query($query);
      }

    }

/**
 * Function for setting the tournament director for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the TD.
 */
function SetTD($eventid, $td)
{
    $retValue = Null;
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

    if ( isset( $eventid) and isset( $td)) {
      $eventid  = (int) $eventid;
      mysql_query(data_query("DELETE FROM :EventManagement WHERE Event = $eventid AND Role = 'td'"));

        $query = data_query( "INSERT INTO :EventManagement (User, Event, Role) VALUES (%d, %d, '%s');",
                          (int) $td, (int) $eventid, 'td');

        if ( !mysql_query( $query)) {
            $err = new Error();
            $err->title = "error_db_query";
            $err->description = translate( "error_db_query_description");
            $err->internalDescription = "Failed SQL INSERT query";
            $err->function = "SetTD()";
            $err->IsMajor = true;
            $err->data = "Event id: " . $eventid . "; TD: ". $td;
            $retValue = $err;
        } else {

        }
    } else {
        $err = new Error();
        $err->title = "error_invalid_argument";
        $err->description = translate( "error_invalid_argument_description");
        $err->internalDescription = "Event id or td argument is not set.";
        $err->function = "SetTD()";
        $err->IsMajor = true;
        $err->data = "event id:" . $eventid . "; td:" . $td;
        $retValue = $err;
    }

    return $retValue;
}

/**
 * Function for setting the officials for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the official.
 */
function SetOfficials($eventid, $officials)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }
   $eventid = (int) $eventid;

   $retValue = null;
   if ( isset( $eventid)) {
      $clearingQuery = data_query("DELETE FROM :EventManagement WHERE Event = %d AND Role = 'official'", $eventid);
      mysql_query($clearingQuery);

      foreach ($officials as $official) {
            $query = data_query( "INSERT INTO :EventManagement (User, Event, Role) VALUES (%d, %d, '%s');",
                              (int) $official, (int) $eventid, 'official');
            if ( !mysql_query( $query)) {
                $err = new Error();
                $err->title = "error_db_query";
                $err->description = translate( "error_db_query_description");
                $err->internalDescription = "Failed SQL INSERT query";
                $err->function = "SetOfficials()";
                $err->IsMajor = true;
                $err->data = "Event id: " . $eventid . "; official: ". $official;
                $retValue = $err;
                break;
            }
        }
    } else {
        $err = new Error();
        $err->title = "error_invalid_argument";
        $err->description = translate( "error_invalid_argument_description");
        $err->internalDescription = "Event id argument is not set.";
        $err->function = "SetOfficials()";
        $err->IsMajor = true;
        $err->data = "event id:" . $eventid;
        $retValue = $err;
    }

    return $retValue;
}

/**
 * Function for setting the classes for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the class.
 */
function SetClasses($eventid, $classes)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }
   $retValue = null;
   $eventid = (int) $eventid;

   if (isset( $eventid)) {
      // get quotas for later restoring
      $quotas = GetEventQuotas($eventid);

      mysql_query(data_query("DELETE FROM :ClassInEvent WHERE Event = $eventid"));
      foreach ($classes as $class) {
         $query = data_query("INSERT INTO :ClassInEvent (Classification, Event) VALUES (%d, %d);",
                           (int) $class, (int) $eventid);
         if (!mysql_query($query)) {
            return Error::Query($query);
         }
      }

      // Fix limits back.. do not bother handling errors as some classes may be removed
      foreach ($quotas as $quota) {
         $cid = (int) $quota['id'];
         $min = (int) $quota['MinQuota'];
         $max = (int) $quota['MaxQuota'];

         mysql_query(data_query("UPDATE :ClassInEvent SET MinQuota = %d, MaxQuota = %d
                                 WHERE Event = %d AND Classification = %d",
                                 $min, $max, $eventid, $cid));
      }
    } else {
        $err = new Error();
        $err->title = "error_invalid_argument";
        $err->description = translate( "error_invalid_argument_description");
        $err->internalDescription = "Event id argument is not set.";
        $err->function = "SetClasses()";
        $err->IsMajor = true;
        $err->data = "event id:" . $eventid;
        $retValue = $err;
    }

    return $retValue;
}

/**
 * Function for setting the rounds for en event
 *
 * Returns null for success or
 * an Error in case there was an error in setting the round.
 */
function SetRounds( $eventid, $rounds, $deleteRounds = array())
{
    $dbError = InitializeDatabaseConnection();
    if ($dbError) {
        return $dbError;
    }

    $retValue = null;

    $eventid = (int) $eventid;
    foreach ($deleteRounds as $toDelete) {
      $toDelete = (int) $toDelete;
      $query = "DELETE FROM :Round WHERE Event = $eventid AND id = $toDelete";
      $query = data_query($query);
      mysql_query($query);
    }

    foreach ($rounds as $round) {

        //list( $date, $time, $holes, $datestring, $roundid) = $round;
        $date = $round['date'];
        $time = $round['time'];
        $datestring = $round['datestring'];
        $roundid = $round['roundid'];

        $r_event = (int) $eventid;
        $r_course = null;
        $r_starttype = "sequential";
        $r_starttime = (int) $date;
        $r_interval = 10;
        $r_validresults = 1;

        if ( empty( $roundid) || $roundid == '*') {
            // Create new round
            $query = data_query( "INSERT INTO :Round (Event, Course, StartType, StartTime, `Interval`, ValidResults) VALUES (%d, %s, '%s', FROM_UNIXTIME(%d), %d, %d);",
                              $r_event, esc_or_null($r_course, 'int'), $r_starttype, $r_starttime, $r_interval, $r_validresults);

            if ( mysql_query( $query)) {
                $roundid = mysql_insert_id();
            } else {
                $err = new Error();
                $err->title = "error_db_query";
                $err->description = translate( "error_db_query_description");
                $err->internalDescription = "Failed SQL INSERT query (Round)\n$query\n" . mysql_error();
                $err->function = "SetRounds()";
                $err->IsMajor = true;
                $err->data = "Event id: " . $r_event;
                $retValue = $err;
                break;
            }

        } else {
            // We don't actually support editing rounds, so it's either deleting or
            // creating new -- nothing to be done here.
        }
    }

    return $retValue;
}

/**
 * Function for setting the round course
 *
 * Returns cource id for success or an Error
 */
function GetOrSetRoundCourse($roundid)
{
    $dbError = InitializeDatabaseConnection();
    if ($dbError) {
        return $dbError;
    }

    $courseid = null;

    // Get the existing round
    $query = data_query( "SELECT Course FROM :Round WHERE id = %d",
                      (int) $roundid);
    $result = mysql_query( $query);
    if ( mysql_num_rows( $result) == 1) {
         $row = mysql_fetch_assoc( $result);
         $course = $row['Course'];
         mysql_free_result($result);
    } else {
        // Invalid round id
        $err = new Error();
        $err->title = "error_invalid_argument";
        $err->description = translate( "error_invalid_argument_description");
        $err->internalDescription = "Invalid round id argument";
        $err->function = "GetOrSetRoundCourse()";
        $err->IsMajor = true;
        $err->data = "Round id: " . $roundid;
        $courseid = $err;
    }
    if ( !isset( $courseid)) {
        // Create a new course for the round
        $query = data_query( "INSERT INTO :Course (Venue, Name, Description, Link, Map) VALUES (NULL, '%s', '%s', '%s', '%s');",
                          "", "", "", "");
        if ( mysql_query( $query)) {
            $courseid = mysql_insert_id();
        } else {
            $err = new Error();
            $err->title = "error_db_query";
            $err->description = translate( "error_db_query_description");
            $err->internalDescription = "Failed SQL INSERT query (Course)\n$query\n" . mysql_error();
            $err->function = "GetOrSetRoundCourse()";
            $err->IsMajor = true;
            $err->data = "Round id: " . $roundid;
            $courseid = $err;

            return $err;
        }

        // Update round's course field
        $query = data_query( "UPDATE :Round SET Course = %d WHERE id = %d;",
                          $courseid, $roundid);
        if ( !mysql_query( $query)) {
            $err = new Error();
            $err->title = "error_db_query";
            $err->description = translate( "error_db_query_description");
            $err->internalDescription = "Failed SQL UPDATE query (Round)\n$query" . mysql_error();
            $err->function = "GetOrSetRoundCourse()";
            $err->IsMajor = true;
            $err->data = "Course id: " . $courseid .
                         "; Round id: " . $roundid;;
            $courseid = $err;
        }
    }

    return $courseid;
}

/**
 * Function for setting the holes for a course
 *
 * Returns null for success or an Error
 *
 * Seems to be unused now
 */
function SetCourseHoles($courseid, $holes)
{
    $dbError = InitializeDatabaseConnection();
    if ($dbError) {
        return $dbError;
    }

    $retValue = null;

    for ($holenumber = 1; $holenumber <= $holes; $holenumber++) {
        $h_holeid = null;
        $h_par = 0;
        $h_length = 0;

        // Get the existing hole
        $query = data_query( "SELECT id, Par, Length FROM :Hole WHERE Course = %d AND HoleNumber = %d",
                          (int) $courseid, $holenumber);
        $result = mysql_query( $query);
        $nbr_of_results = mysql_num_rows( $result);
        if ($nbr_of_results == 1) {
            mysql_free_result($result);
            // One and only valid hole
            $row = mysql_fetch_assoc( $result);
            $h_holeid = $row['id'];
            $h_pr = $row['Par'];
            $h_length = $row['Length'];
        } elseif ($nbr_of_results == 0) {
            mysql_free_result($result);
            // No existing hole, create new
            $query = data_query( "INSERT INTO :Hole (Course, HoleNumber, Par, Length) VALUES (%d, %d, %d, %d);",
                              $courseid, $holenumber, $h_par, $h_length);
            if ( !mysql_query( $query)) {
                $err = new Error();
                $err->title = "error_db_query";
                $err->description = translate( "error_db_query_description");
                $err->internalDescription = "Failed SQL INSERT query (Hole)";
                $err->function = "SetCourseHoles()";
                $err->IsMajor = true;
                $err->data = "Course id: ". $courseid .
                             "; Hole number: " . $holenumber;
                $retValue = $err;
                break;
            }
        } else {
            // Found more than one hole with same number, report error
            $err = new Error();
            $err->title = "error_db_integrity";
            $err->description = translate( "error_db_integrity_description");
            $err->internalDescription = "More than one one Course-HoleNumber record in the database.";
            $err->function = "SetCourseHoles()";
            $err->IsMajor = true;
            $err->data = "Course id: ". $courseid .
                         "; Hole number: " . $holenumber;
            $retValue = $err;
            break;
        }
    }

    return $retValue;
}

/** ****************************************************************************
 * Function for checking if player fits event quota or should be queued
 *
 * Returns true for direct signup, false for queue
 *
 * @param int  $eventId   Event ID
 * @param int  $playerId  Player ID
 * @param int  $classId   Classification ID
 */
function CheckSignUpQuota($eventId, $playerId, $classId)
{
    $event = GetEventDetails($eventId);
    $participants = $event->GetParticipants();
    $limit = $event->playerLimit;
    $total = count($participants);

    // Too many players registered already
    if ($limit > 0 && $total >= $limit) {
        return false;
    }

    // Calculate some limits and counts
    list($minquota, $maxquota) = GetEventClassQuota($eventId, $classId);
    $classcounts = GetEventParticipantCounts($eventId);
    $classcount = isset($classcounts[$classId]) ? $classcounts[$classId] : 0;

    // Check versus class maxquota
    if ($classcount >= $maxquota) {
        return false;
    }

    // If there is unused quota in class, allow player in
    if ($classcount < $minquota) {
        return true;
    }

    // Calculate unused quota in other divisions, if there is global limit set
    if ($limit > 0) {
        $unusedQuota = 0;
        $quotas = GetEventQuotas($eventId);

        foreach ($quotas as $idx => $quota) {
            $cquota = $quota['MinQuota'];
            $ccount = (isset($classcounts[$quota['id']]) ? $classcounts[$quota['id']] : 0);
            $cunused = $cquota - $ccount;

            if ($cunused > 0)
                $unusedQuota += $cunused;
        }
        $spots_left = $limit - $total - $unusedQuota;

        // Deny if there is no unreserved space left
        if ($spots_left <= 0) {
            return false;
        }
    }

    // ok, we have space left
    return true;
}


/**
 * Function for setting the user participation on an event
 *
 * Returns true for success, false for successful queue signup or an Error
 */
function SetPlayerParticipation($playerid, $eventid, $classid, $signup_directly = true)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
     return $dbError;
   }
   $retValue = $signup_directly;

   if ($signup_directly === true)
      $table = "Participation";
   else
      $table = "EventQueue";

   // Inputmapping is already checking player's re-entry, so this is merely a cleanup from queue
   // and double checking that player will not be in competition table twice
   CancelSignup($eventid, $playerid, false);

   $query = data_query("INSERT INTO :$table (Player, Event, Classification) VALUES (%d, %d, %d);",
                         (int) $playerid, (int) $eventid, (int) $classid);

   if (!mysql_query($query)) {
     $err = new Error();
     $err->title = "error_db_query";
     $err->description = translate( "error_db_query_description");
     $err->internalDescription = "Failed SQL INSERT query (Participation)";
     $err->function = "SetPlayerParticipation()";
     $err->IsMajor = true;
     $err->data = "Player id: " . $playerid .
                  "; Event id: " . $eventid .
                  "; Classification id: ". $classid;
     $retValue = $err;
   }

   return $retValue;
}


// Check if we can raise players from queue after someone left
function CheckQueueForPromotions($eventId)
{
   $queuers = GetEventQueue($eventId, '', '');
   foreach ($queuers as $queuer) {
      $playerId = $queuer['player']->id;
      $classId = $queuer['classId'];

      if (CheckSignupQuota($eventId, $playerId, $classId)) {
         $retVal = PromotePlayerFromQueue($eventId, $playerId);
         if (is_a($retVal, 'Error')) {
            error_log("Error promoting player $playerId to event $eventId at class $classId");
         }
      }
   }

   return null;
}


// Raise competitor from queue to the event
function PromotePlayerFromQueue($eventId, $playerId)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
     return $dbError;
   }

   // Get data from queue
   $result = mysql_query(data_query("SELECT * FROM :EventQueue WHERE Player = $playerId AND Event = $eventId"));
   if (mysql_num_rows($result) > 0) {
      $row = mysql_fetch_assoc($result);

      // Insert into competition
      $query = data_query("INSERT INTO :Participation (Player, Event, Classification, SignupTimestamp) VALUES (%d, %d, %d, FROM_UNIXTIME(%d));",
                         (int) $row['Player'], (int) $row['Event'], (int) $row['Classification'], time());
      if (!mysql_query($query)) {
         return Error::Query($query);
      }

      // Remove data from queue
      if (!mysql_query(data_query("DELETE FROM :EventQueue WHERE Player = $playerId AND Event = $eventId"))) {
         return Error::Query($query);
      }

      $user = GetPlayerUser($playerId);
      if ($user !== null) {
         require_once 'core/email.php';
         error_log("Sending email to ".print_r($user, true));
         SendEmail(EMAIL_PROMOTED_FROM_QUEUE, $user->id, GetEventDetails($eventId));
      } else {
         error_log("Cannot send promotion email: user !== null failed, playerId = ".$playerId);
      }
   }
   mysql_free_result($result);

   return null;
}


// Cancels a players signup for an event
function CancelSignup($eventId, $playerId, $check_promotion = true)
{
    $dbError = InitializeDatabaseConnection();
    if ($dbError) {
        return $dbError;
    }

    // Delete from event and queue
    mysql_query(data_query("DELETE FROM :Participation WHERE Player = $playerId AND Event = $eventId"));
    mysql_query(data_query("DELETE FROM :EventQueue WHERE Player = $playerId AND Event = $eventId"));

    if ($check_promotion === false)
      return null;

    // Check if we can lift someone into competition
    return CheckQueueForPromotions($eventId);
}

/**
 * Function for setting the venue
 *
 * Returns venue id for success or an Error
 */
function GetVenueId($venue)
{
    $dbError = InitializeDatabaseConnection();
    if ($dbError) {
        return $dbError;
    }

    $venueid = null;

    // Get the existing venue
    $query = data_query( "SELECT id FROM :Venue WHERE Name = '%s'",
                      mysql_real_escape_string( $venue));
    $result = mysql_query( $query);
    if ( mysql_num_rows( $result) >= 1) {
         $row = mysql_fetch_assoc( $result);
         $venueid = $row['id'];

         mysql_free_result($result);
    }

    if ( !isset( $venueid)) {
        // Create a new venue
        $query = data_query( "INSERT INTO :Venue (Name) VALUES ('%s');",
                          mysql_real_escape_string( $venue));
        if ( mysql_query( $query)) {
            $venueid = mysql_insert_id();
        } else {
            $err = new Error();
            $err->title = "error_db_query";
            $err->description = translate( "error_db_query_description");
            $err->internalDescription = "Failed SQL INSERT query (Venue)";
            $err->function = "GetOrSetVenue()";
            $err->IsMajor = true;
            $err->data = "Venue: " . $venue;
            $venueid = $err;
        }
    }

    return $venueid;
}

 function CreateNewsItem($eventid, $title, $text)
 {
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

    $query = data_query("INSERT INTO :TextContent(Event, Title, Date, Content, Type) VALUES(%d, '%s', NOW(), '%s', 'news')",
                            (int) $eventid, mysql_real_escape_string($title), mysql_real_escape_string($text));

    if ( !mysql_query($query)) {
          $err = new Error();
          $err->title = "error_db_query";
          $err->description = translate( "error_db_query_description");
          $err->internalDescription = "Failed SQL INSERT";
          $err->function = "CreateNewsItem()";
          $err->IsMajor = true;
          $err->data = "Event id: " . $eventid;

          return $err;
    }
}

function EditNewsItem($itemid, $title, $text)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $query = data_query("UPDATE :TextContent SET Title = '%s', Content = '%s' WHERE id = %d",
                          mysql_real_escape_string($title), mysql_real_escape_string($text), (int) $itemid);

    if ( !mysql_query($query)) {
          $err = new Error();
          $err->title = "error_db_query";
          $err->description = translate( "error_db_query_description");
          $err->internalDescription = "Failed SQL UPDATE";
          $err->function = "EditNewsItem()";
          $err->IsMajor = true;
          $err->data = "Event id: " . $eventid;

          return $err;
    }
 }

/* ****************************************************************************
 * Functions for changing user data
 *
 * */

/**
 * Function for setting or changing the user data.
 *
 * @param class User $user - single system users personal data
 */

function SetUserDetails($user)
{
    $retValue = null;

    if ( is_a( $user,"User")) {
        $dbError = InitializeDatabaseConnection();
        if ($dbError) {
           return $dbError;
        }


        if ($user->username !== null) {
            $u_username_quoted  = "'" .  mysql_real_escape_string( $user->username) . "'";
        } else {
            $u_username_quoted = 'NULL';
        }
        $u_email     = mysql_real_escape_string( $user->email);
        $u_password  = $user->password;
        $u_role      = mysql_real_escape_string( $user->role);
        $u_firstname = mysql_real_escape_string( data_fixNameCase($user->firstname));
        $u_lastname  = mysql_real_escape_string( data_fixNameCase($user->lastname));

        // Check that username is not already in use
        if ( !GetUserId( $user->username)) {
            // Username is unique, proceed to insert into table
            $query = data_query( "INSERT INTO :User (Username, UserEmail, Password, Role, UserFirstName, UserLastName, Player) VALUES (%s, '%s', '%s', '%s', '%s', '%s', %s);",
                              $u_username_quoted, $u_email, $u_password, $u_role, $u_firstname, $u_lastname, esc_or_null($user->player, 'int'));


            if ( mysql_query( $query)) {
                // Get id for the new user
                $u_id = mysql_insert_id();
                $user->SetId( $u_id);
                $retValue = $user;
            } else {
                echo mysql_error();

                return Error::Query($query);
            }

        } else {
            // Username already in use, report error
            $err = new Error();
            $err->title = "error_invalid_argument";
            $err->description = translate( "error_invalid_argument_description");
            $err->internalDescription = "Username is already in use";
            $err->function = "SetUserDetails()";
            $err->IsMajor = false;
            $err->data = "username:" . $u_username .
                         "; role:" . $u_role .
                         "; firstname:" . $u_firstname .
                         "; lastname:" . $u_lastname;
            $retValue = $err;
        }
    } else {
        // Wrong class as argument, report error
        $err = new Error();
        $err->title = "error_argument";
        $err->description = translate( "error_argument_description");
        $err->internalDescription = "Wrong class as argument";
        $err->function = "SetUserDetails()";
        $err->IsMajor = true;
        $err->data = "argument class:" . get_class( $user) .
                     ", expected User";
        $retValue = $err;
    }

return $retValue;
}

/**
 * Function for setting or changing the player data.
 *
 * @param class Player $player - single system users player data
 */

function SetPlayerDetails($player)
{
    $retValue = null;
    if ( is_a( $player, "Player")) {
        $dbError = InitializeDatabaseConnection();
        if ($dbError) {
           return $dbError;
        }



        $query = data_query( "INSERT INTO :Player (pdga, sex, lastname, firstname, birthdate, email) VALUES (
                            %s, '%s', %s, %s, '%s', %s
                            );",
                          esc_or_null($player->pdga),
                          $player->gender == 'M' ? 'male' : 'female',
                          esc_or_null(data_fixNameCase($player->lastname)),
                          esc_or_null(data_fixNameCase($player->firstname)),
                          (int) $player->birthyear . '-1-1',
                          esc_or_null($player->email)
                          );

        if ( mysql_query( $query)) {
            // Get id for the new user
            $p_id = mysql_insert_id();
            $player->SetId( $p_id);
            $retValue = $player;
        } else {
            echo $query;
            echo mysql_error();

            return Error::Query($query);
        }
    } else {
        // Wrong class as argument, report error
        $err = new Error();
        $err->title = "error_argument";
        $err->description = translate( "error_argument_description");
        $err->internalDescription = "Wrong class as argument";
        $err->function = "SetPlayerDetails()";
        $err->IsMajor = true;
        $err->data = "argument class:" . get_class( $player) .
                     ", expected Player";
        $retValue = $err;
    }

return $retValue;
}


   function GetAllTextContent($eventid)
   {
      require_once 'core/textcontent.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = array();

      if ($eventid) $eventCond = " = " . (int) $eventid;
      else $eventCond = " IS NULL";

      $eventid =  esc_or_null( $eventid, 'int');
      $result = mysql_query(data_query("SELECT id, Event, Title, Content, UNIX_TIMESTAMP(Date)
                                       Date, Type, `Order`  FROM :TextContent
                                       WHERE Event $eventCond AND Type !=  'news' ORDER BY `order`"));

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $temp = new TextContent($row);
            $retValue[] = $temp;
         }
      }

      mysql_free_result($result);

      return $retValue;
   }

   function GetEventNews($eventid, $from, $count)
   {
      require_once 'core/textcontent.php';
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = array();
      $eventid = (int) $eventid;
      $from = (int) $from;
      $count = (int) $count;
      $result = mysql_query(data_query("SELECT id, Event, Title, Content, UNIX_TIMESTAMP(Date) Date,
                                       Type, `Order`  FROM :TextContent
                                       WHERE Event = $eventid AND Type =  'news' ORDER BY `date` DESC
                                       LIMIT $from, $count"));

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $temp = new TextContent($row);
            $retValue[] = $temp;
         }
      }

      mysql_free_result($result);

      return $retValue;
   }

   function GetTextContent($pageid)
   {
      if (empty($pageid)) {
         return null;
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $id = (int) $pageid;

      $result = mysql_query(data_query("SELECT id, Event, Title, Content, Date, Type, `Order` FROM :TextContent WHERE id = $id "));

      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $retValue = new TextContent($row);
      }

      mysql_free_result($result);

      return $retValue;
   }

function GetTextContentByEvent($eventid, $type)
{
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $id = (int) $eventid;
      $type = mysql_real_escape_string($type);

      if ($id) $eventCond = "= $id";
      else $eventCond = "IS NULL";

      $result = mysql_query(data_query("SELECT id, Event, Title, Content, Date, Type, `Order` FROM :TextContent WHERE event $eventCond AND `type` = '$type' "));


      if (mysql_num_rows($result) != 0) {
         $row = mysql_fetch_assoc($result);
         $retValue = new TextContent($row);
      }

      mysql_free_result($result);

      return $retValue;
   }

   function GetTextContentByTitle($eventid, $title)
   {


      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;
      $id = (int) $eventid;
      $title = mysql_real_escape_string($title);

      if ($id) $eventCond = "= $id";
      else $eventCond = "IS NULL";

      $result = mysql_query(data_query("SELECT id, Event, Title, Content, Date, Type, `Order` FROM :TextContent WHERE event $eventCond AND `title` = '$title' "));


      if (mysql_num_rows($result) == 1) {
         $row = mysql_fetch_assoc($result);
         $retValue = new TextContent($row);
      }

      mysql_free_result($result);

      return $retValue;
   }

   function EditClass($id, $name, $minage, $maxage, $gender, $available)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $query = data_query("UPDATE :Classification SET Name = '%s', MinimumAge = %s, MaximumAge = %s, GenderRequirement = %s, Available = %d
                           WHERE id = %d",
                    mysql_real_escape_string($name), esc_or_null($minage,'int'), esc_or_null($maxage, 'int'), esc_or_null($gender, 'gender'), $available ? 1:0, $id);

   if (!mysql_query($query)) {
       $err = new Error();
       $err->title = "error_db_query";
       $err->description = translate( "error_db_query_description");
       $err->internalDescription = "Failed SQL UPDATE";
       $err->function = "EditClass()";
       $err->IsMajor = true;
       $err->data = "Class id: " . $id;

       return $err;
   }
}

function CreateClass($name, $minage, $maxage, $gender, $available)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $query = data_query("INSERT INTO :Classification (Name, MinimumAge, MaximumAge, GenderRequirement, Available) VALUES ('%s', %s, %s, %s, %d);",
                    mysql_real_escape_string($name), esc_or_null($minage, 'int'), esc_or_null($maxage, 'int'), esc_or_null($gender, 'gender'), $available ? 1:0);

   if (!mysql_query($query)) {
       $err = new Error();
       $err->title = "error_db_query";
       $err->description = translate( "error_db_query_description");
       $err->internalDescription = "Failed SQL INSERT";
       $err->function = "CreateClass()";
       $err->IsMajor = true;
       $err->data = "Class name: " . $name;

       return $err;
   }
}

function DeleteClass($id)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   if (!mysql_query(data_query("DELETE FROM :Classification WHERE id = ". (int) $id))) {
       $err = new Error();
       $err->title = "error_db_query";
       $err->description = translate( "error_db_query_description");
       $err->internalDescription = "Failed SQL DELETE";
       $err->function = "DeleteClass()";
       $err->IsMajor = true;
       $err->data = "Class id: " . $id;

       return $err;
   }
}

// Returns true if the provided class is being used in any event, false otherwise
function ClassBeingUsed($id)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $retValue = true;
   $id = (int) $id;

   $query = data_query("SELECT COUNT(*)   AS Events FROM :ClassInEvent WHERE Classification = %d"
                          , $id);

   $result = mysql_query($query);

   if (mysql_num_rows($result) > 0) {
      $temp = mysql_fetch_assoc($result);

      $retValue = ($temp['Events']) > 0;
   }

   mysql_free_result($result);

    return $retValue;
}

function EditLevel($id, $name, $method, $available)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $query = data_query("UPDATE :Level SET Name = '%s', ScoreCalculationMethod = '%s', Available = %d WHERE id = %d",
                            mysql_real_escape_string($name), mysql_real_escape_string($method), $available ? 1:0, (int) $id);

   if (!mysql_query($query)) {
       $err = new Error();
       $err->title = "error_db_query";
       $err->description = translate( "error_db_query_description");
       $err->internalDescription = "Failed SQL UPDATE";
       $err->function = "EditLevel()";
       $err->IsMajor = true;
       $err->data = "Level id: " . $id;

       return $err;
   }
}

function CreateLevel($name, $method, $available)
{

    $retValue = null;

    $dbError = InitializeDatabaseConnection();
    if ($dbError) {
       return $dbError;
    }

    $query = data_query( "INSERT INTO :Level (Name, ScoreCalculationmethod, Available) VALUES ('%s', '%s', %d);",
                      mysql_real_escape_string( $name), mysql_real_escape_string($method), $available ? 1:0);

    if ( mysql_query( $query)) {
        // Get id for the new level
        $level_id = mysql_insert_id();
        $retValue = $level_id;
    } else {
        // Insert query error
        $err = new Error();
        $err->title = "error_db_query";
        $err->description = "error_db_query_description";
        $err->internalDescription = "Failed SQL INSERT query";
        $err->function = "CreateLevel()";
        $err->IsMajor = true;
        $err->data = "name:" . $name . " ;method:" . $method;
        $retValue = $err;
    }

    return $retValue;
}


function DeleteLevel($id)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   if (!mysql_query(data_query("DELETE FROM :Level WHERE id = ". (int) $id))) {
       $err = new Error();
       $err->title = "error_db_query";
       $err->description = translate( "error_db_query_description");
       $err->internalDescription = "Failed SQL DELETE";
       $err->function = "DeleteLevel()";
       $err->IsMajor = true;
       $err->data = "Level id: " . $id;

       return $err;
   }
}


// Returns true if the provided level is being used in any event or tournament, false otherwise
function LevelBeingUsed($id)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $retValue = true;
   $id = (int) $id;

   $query = data_query("SELECT (SELECT COUNT(*) FROM :Event WHERE Level = %d) AS Events,
                           (SELECT COUNT(*) FROM :Tournament WHERE Level = %d) AS Tournaments", $id, $id);

   $result = mysql_query($query);

   if (mysql_num_rows($result) > 0) {
      $temp = mysql_fetch_assoc($result);
      $retValue = ($temp['Events'] + $temp['Tournaments']) > 0;
   }

   mysql_free_result($result);

    return $retValue;
}

function EditTournament($id, $name, $method, $level, $available, $year, $description)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $query = data_query("UPDATE :Tournament SET Name = '%s', ScoreCalculationMethod = '%s', Level = %d, Available = %d, Year = %d,
                       Description = '%s'
                       WHERE id = %d",
                           mysql_real_escape_string($name), mysql_real_escape_string($method), (int) $level, $available ? 1:0, (int) $year,
                           mysql_real_escape_string($description),(int) $id);

   if (!mysql_query($query)) {
       $err = new Error();
       $err->title = "error_db_query";
       $err->description = translate( "error_db_query_description");
       $err->internalDescription = "Failed SQL UPDATE";
       $err->function = "EditTournament()";
       $err->IsMajor = true;
       $err->data = "Tournament id: " . $id;

       return $err;
   }
}

function CreateTournament($name, $method, $level, $available, $year, $description)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $query = data_query("INSERT INTO :Tournament(Name, ScoreCalculationMethod, Level, Available, Year, Description) VALUES('%s', '%s', %d, %d, %d, '%s')",
                           mysql_real_escape_string($name), mysql_real_escape_string($method), (int) $level, $available ? 1:0, (int) $year,
                           mysql_real_escape_string($description));

   if (!mysql_query($query)) {
       $err = new Error();
       $err->title = "error_db_query";
       $err->description = translate( "error_db_query_description");
       $err->internalDescription = "Failed SQL INSERT";
       $err->function = "CreateTournament()";
       $err->IsMajor = true;
       $err->data = "Tournament name: " . $name;

       return $err;
   }
}

function DeleteTournament($id)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   if (!mysql_query(data_query("DELETE FROM :Tournament WHERE id = ". (int) $id))) {
       $err = new Error();
       $err->title = "error_db_query";
       $err->description = translate( "error_db_query_description");
       $err->internalDescription = "Failed SQL DELETE";
       $err->function = "DeleteTournament()";
       $err->IsMajor = true;
       $err->data = "Tournament id: " . $id;

       return $err;
   }
}


// Returns true if the provided tournament is being used in any event, false otherwise
function TournamentBeingUsed($id)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }


   $retValue = true;
   $result = mysql_query(data_query("SELECT COUNT(*) AS n FROM :Event WHERE Tournament = ". (int) $id));


   if (mysql_num_rows($result) > 0) {

      $temp = mysql_fetch_assoc($result);

      $retValue = $temp['n'] > 0;

   }

   mysql_free_result($result);

    return $retValue;
}

function GetTournamentDetails($id)
{
    require_once 'core/tournament.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
    $id = (int) $id;
    $query = data_query("SELECT id, Level, Name, ScoreCalculationMethod, Year, Available, Description FROM :Tournament WHERE id = $id");



    $retValue = array();
    $result = mysql_query($query);

    if (mysql_num_rows($result) == 1) {
      while ($row = mysql_fetch_assoc($result)) {
         $retValue = new Tournament($row['id'], $row['Level'], $row['Name'], $row['Year'], $row['ScoreCalculationMethod'], $row['Available'], $row['Description']);
      }
    }

    mysql_free_result($result);

    return $retValue;
}

function GetTournamentYears()
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $retValue = array();
   $result = mysql_query(data_query("SELECT DISTINCT Year FROM :Tournament ORDER BY Year"));


   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $retValue[] = $row['Year'];
      }
   }

   mysql_free_result($result);

   return $retValue;
}


function GetTournamentLeader($tournamentId)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $tournamentId = (int) $tournamentId;
   $retValue = array();
   $result = mysql_query(data_query("SELECT :User.id FROM
                           :TournamentStanding
                           INNER JOIN :Player ON :TournamentStanding.Player = :Player.player_id
                           INNER JOIN :User ON :Player.player_id = :User.Player
                           WHERE :TournamentStanding.Tournament = $tournamentId
                           ORDER BY Standing
                           LIMIT 1

                         "));


   if (mysql_num_rows($result) == 1) {
      while ($row = mysql_fetch_assoc($result)) {
         $retValue = GetUserDetails($row['id']);
      }
   }

   mysql_free_result($result);

   return $retValue;
}

function GetEventsByYear($year)
{
   $year = (int) $year;

   $start = mktime(0,0,0,1,1,$year);
   $end = mktime(0,0,0,12,31,$year);

   return GetEventsByDate($start, $end) ;
}

function GetEventYears()
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $retValue = array();
   $result = mysql_query(data_query("SELECT DISTINCT(YEAR(Date)) AS year FROM :Event ORDER BY YEAR(Date) ASC"));

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $retValue[] = $row['year'];
      }
   }

   mysql_free_result($result);

    return $retValue;
}


function GetUserEvents($ignored, $eventType = 'all')
{

   $conditions = '';
   if ($eventType == 'participant' || $eventType == 'all') {
      $conditions = ':Participation.Player IS NOT NULL';
   }

   if ($eventType == 'manager' || $eventType == 'all') {
      if ($conditions) $conditions .= " OR ";
      $conditions = ':EventManagement.Role IS NOT NULL';
   }

   return data_GetEvents($conditions);
}

function GetFeePayments($relevantOnly = true, $search = '', $sortedBy = '', $forcePlayer = null)
{
    require_once 'core/player.php';
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

    if ($forcePlayer) {
        $search  = data_query( ":Player.player_id = %d", (int) $forcePlayer);
    } else {
        $search = data_ProduceSearchConditions($search, array('FirstName', 'LastName', 'pdga', 'Username'));
    }



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
                   ORDER BY %s, UserId, :MembershipPayment.Year, :LicensePayment.Year"
                  ;

   $query = data_query($query, $search, $sortOrder);

   $result = mysql_query($query);


   $userid = -1;
   $pdata = array();
   $retValue = array();

   if (mysql_num_rows($result) > 0) {

      while ($row = mysql_fetch_assoc($result)) {
         if ($userid != $row['UserId']) {
            if (!empty($pdata)) {
               if (!isset($pdata['licensefees'][$year ])) $pdata['licensefees'][$year] = false;
               if (!isset($pdata['licensefees'][$year + 1])) $pdata['licensefees'][$year + 1] = false;

               if (!isset($pdata['membershipfees'][$year ])) $pdata['membershipfees'][$year] = false;
               if (!isset($pdata['membershipfees'][$year + 1])) $pdata['membershipfees'][$year + 1] = false;

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

         if ($row['MSPYear'] != null) {
            $pdata['membershipfees'][$row['MSPYear']] = true;
         }

         if ($row['LPYear'] != null) {
            $pdata['licensefees'][$row['LPYear']] = true;
         }
      }

      if (!empty($pdata)) {
            if (!isset($pdata['licensefees'][$year ])) $pdata['licensefees'][$year] = false;
            if (!isset($pdata['licensefees'][$year + 1])) $pdata['licensefees'][$year + 1] = false;

            if (!isset($pdata['membershipfees'][$year ])) $pdata['membershipfees'][$year] = false;
            if (!isset($pdata['membershipfees'][$year + 1])) $pdata['membershipfees'][$year + 1] = false;

            ksort($pdata['membershipfees']);
            ksort($pdata['licensefees']);

            $retValue[] = $pdata;
      }
   }

   mysql_free_result($result);

   return $retValue;
}

/* Return event's participant counts by class */
function GetEventParticipantCounts($eventId)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $eventId = (int) $eventId;
   $query = data_query("SELECT count(*) as cnt, Classification
      FROM :Participation
      WHERE Event = $eventId
      GROUP BY Classification");
   $result = mysql_query($query);

   $ret = array();
   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $ret[$row['Classification']] = $row['cnt'];
      }
   }

   return $ret;
}

 function GetEventParticipants($eventId, $sortedBy, $search)
 {
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $retValue = array();
   $eventId = (int) $eventId;

   $sortOrder = data_CreateSortOrder($sortedBy, array('name' => array('LastName', 'FirstName'), 'class' => 'ClassName', 'LastName' => true, 'FirstName' => true, 'birthyear' => 'YEAR(birthdate)', 'pdga', 'gender' => 'sex', 'Username'));
   if (is_a($sortOrder, 'Error')) return $sortOrder;
   if ($sortOrder == 1) $sortOrder = " LastName, FirstName";

   $query = "SELECT :User.id AS UserId, Username, Role, UserFirstName, UserLastName, UserEmail, :Player.firstname pFN, :Player.lastname pLN,
                                :Player.email pEM,
                               :Player.player_id AS PlayerId, pdga PDGANumber, Sex, YEAR(birthdate) YearOfBirth, :Classification.Name AS ClassName,
                               :Participation.id AS ParticipationID, UNIX_TIMESTAMP(EventFeePaid) EventFeePaid,
                               UNIX_TIMESTAMP(SignupTimestamp) SignupTimestamp, :Classification.id AS ClassId
                  FROM :User
                  INNER JOIN :Player ON :Player.player_id = :User.Player
                  INNER JOIN :Participation ON :Participation.Player = :Player.player_id AND :Participation.Event = ".$eventId ."
                  INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                  WHERE %s
                  ORDER BY $sortOrder

                  ";

   $query = data_query($query, data_ProduceSearchConditions($search, array('FirstName', 'LastName', 'pdga', 'Username', 'birthdate')));

   $result = mysql_query($query);
   require_once 'core/player.php';
   echo mysql_error();
   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
           $pdata = array();

           $firstname = data_GetOne( $row['UserFirstName'], $row['pFN']);
           $lastname = data_GetOne( $row['UserLastName'], $row['pLN']);
           $email = data_GetOne($row['UserEmail'], $row['pEM']);

           $pdata['user'] = new User($row['UserId'], $row['Username'], $row['Role'], $firstname, $lastname, $email, $row['PlayerId']);
           $pdata['player'] = new Player($row['PlayerId'], $row['PDGANumber'], $row['Sex'], $row['YearOfBirth'], $firstname, $lastname, $email);

           $pdata['eventFeePaid'] = $row['EventFeePaid'];
           $pdata['participationId'] = $row['ParticipationID'];
           $pdata['signupTimestamp'] = $row['SignupTimestamp'];
           $pdata['className'] = $row['ClassName'];
           $pdata['classId'] = $row['ClassId'];
           $retValue[] = $pdata;
      }
   }

   mysql_free_result($result);

   return $retValue;
}

/* Return event's queue counts by class */
function GetEventQueueCounts($eventId)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $eventId = (int) $eventId;
   $query = data_query("SELECT count(*) as cnt, Classification
      FROM :EventQueue
      WHERE Event = $eventId
      GROUP BY Classification");
   $result = mysql_query($query);

   $ret = array();
   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $ret[$row['Classification']] = $row['cnt'];
      }
   }

   return $ret;
}

   // This is more or less copypaste from ^^
   // FIXME: Redo to a simpler form sometime
 function GetEventQueue($eventId, $sortedBy, $search)
 {
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $retValue = array();
   $eventId = (int) $eventId;

   $query = "SELECT :User.id AS UserId, Username, Role, UserFirstName, UserLastName, UserEmail,
               :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM, :Player.player_id AS PlayerId,
               pdga PDGANumber, Sex, YEAR(birthdate) YearOfBirth, :Classification.Name AS ClassName,
               :EventQueue.id AS QueueId,
               UNIX_TIMESTAMP(SignupTimestamp) SignupTimestamp, :Classification.id AS ClassId
                  FROM :User
                  INNER JOIN :Player ON :Player.player_id = :User.Player
                  INNER JOIN :EventQueue ON :EventQueue.Player = :Player.player_id AND :EventQueue.Event = ".$eventId ."
                  INNER JOIN :Classification ON :EventQueue.Classification = :Classification.id
                  WHERE %s
                  ORDER BY SignupTimestamp ASC
                  ";

   $query = data_query($query, data_ProduceSearchConditions($search, array('FirstName', 'LastName', 'pdga', 'Username', 'birthdate')));

   $result = mysql_query($query);
   require_once 'core/player.php';
   echo mysql_error();
   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
           $pdata = array();

           $firstname = data_GetOne( $row['UserFirstName'], $row['pFN']);
           $lastname = data_GetOne( $row['UserLastName'], $row['pLN']);
           $email = data_GetOne($row['UserEmail'], $row['pEM']);

           $pdata['user'] = new User($row['UserId'], $row['Username'], $row['Role'], $firstname, $lastname, $email, $row['PlayerId']);
           $pdata['player'] = new Player($row['PlayerId'], $row['PDGANumber'], $row['Sex'], $row['YearOfBirth'], $firstname, $lastname, $email);
           $pdata['queueId'] = $row['QueueId'];
           $pdata['signupTimestamp'] = $row['SignupTimestamp'];
           $pdata['className'] = $row['ClassName'];
           $pdata['classId'] = $row['ClassId'];
           $retValue[] = $pdata;
      }
   }

   mysql_free_result($result);

   return $retValue;
}

function GetParticipantsForRound($previousRoundId)
 {
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $retValue = array();

   $rrid = (int) $previousRoundId;

   $query = "SELECT :User.id AS UserId, Username, :Player.firstname FirstName, :Player.lastname LastName, Role, :Player.email Email, Sex, YEAR(birthdate) YearOfBirth,

                               :Player.player_id AS PlayerId, pdga PDGANumber, Classification,
                               :Participation.id AS ParticipationID,
                               :RoundResult.Result, :Participation.DidNotFinish

                  FROM `:Round`
                  INNER JOIN :RoundResult ON :RoundResult.`Round` = `:Round`.id
                  INNER JOIN :Participation ON (:Participation.Player = :RoundResult.Player AND :Participation.Event = `:Round`.Event)
                  INNER JOIN :Player ON :RoundResult.Player = :Player.player_id
                  INNER JOIN :User ON :Player.player_id = :User.Player
                  WHERE :RoundResult.Round = $rrid
                  ORDER BY :Participation.Standing
                  ";
   $query = data_query($query);
   $result = mysql_query($query);
   echo mysql_error();

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
           $pdata = array();

           $pdata['user'] = new User($row['UserId'], $row['Username'], $row['Role'], $row['FirstName'], $row['LastName'], $row['Email'], $row['PlayerId']);
           $pdata['player'] = new Player($row['PlayerId'], $row['PDGANumber'], $row['Sex'], $row['YearOfBirth'], $row['FirstName'], $row['LastName'], $row['Email']);

           //$pdata['eventFeePaid'] = $row['EventFeePaid'];
           $pdata['participationId'] = $row['ParticipationID'];
           //$pdata['signupTimestamp'] = $row['SignupTimestamp'];
           //$/pdata['className'] = $row['ClassName'];

           $pdata['classification'] = $row['Classification'];
           $pdata['result'] = $row['Result'];
           $pdata['didNotFinish']=  $row['DidNotFinish'];

           $retValue[] = $pdata;
      }
   }
   mysql_free_result($result);

   return $retValue;
}

function SaveTextContent($page)
   {

      if (!is_a($page, 'TextContent')) {
         return new Error();
      }

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      if (!$page->id) {
         $query = data_query("INSERT INTO :TextContent (Event, Title, Content, Date, Type, `Order`)
                          VALUES (%s, '%s', '%s', FROM_UNIXTIME(%d), '%s', %d)",
                          esc_or_null($page->event, "int"),
                          mysql_real_escape_string($page->title),
                          mysql_real_escape_string($page->content),
                          time(),
                          mysql_real_escape_string($page->type),
                          0
                     );

      } else {
         $query = data_query("UPDATE :TextContent
                              SET
                                 Title = '%s',
                                 Content = '%s',
                                 Date = FROM_UNIXTIME(%d),
                                 `Type` = '%s'
                                 WHERE id = %d",

                                 mysql_real_escape_string($page->title),
                                 mysql_real_escape_string($page->content),
                                 time(),
                                 $page->type,
                                 (int) $page->id
                                 );

      }

      if (!mysql_query($query)) {
        echo mysql_error();
         $retValue = new Error();
                $retValue->title = "error_db_query";
                $retValue->description = translate( "error_db_query_description");
                $retValue->internalDescription = "Failed SQL INSERT query:" . $query;
                $retValue->function = "SaveTextContent()";
                $retValue->IsMajor = true;
      }
   }

  function ChangeUserPassword($userid, $password)
  {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $password  = esc_or_null($password, 'string');
      $userid = (int) $userid;

      $query = data_query("UPDATE :User SET Password = md5(%s) WHERE id = %d", $password, $userid);

      if (!mysql_query($query)) {
         $err = new Error();
         $err->title = "error_db_query";
         $err->description = translate( "error_db_query_description");
         $err->internalDescription = "Failed SQL UPDATE";
         $err->function = "ChangeUserPassword()";
         $err->IsMajor = true;
         $err->data = "User id: " . $userid;

         return $err;
      }
   }

  function GetRoundHoles($roundId)
  {
      require_once 'core/hole.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $roundId = (int) $roundId;

      $query = data_query("SELECT :Hole.id, :Hole.Course, HoleNumber, Par, Length, :Round.id Round
                            FROM :Hole
                            INNER JOIN :Course ON (:Course.id = :Hole.Course)
                            INNER JOIN :Round ON (:Round.Course = :Course.id)
                            WHERE :Round.id = $roundId
                            ORDER BY HoleNumber");

      $result = mysql_query($query);
      echo mysql_error();
      if (mysql_num_rows($result) > 0) {
         $index = 1;
         while ($row = mysql_fetch_assoc($result)) {
            $hole =  new Hole($row);
            $retValue[] = $hole;

         }
      }
      mysql_free_result($result);

      return $retValue;
   }

   function GetCourseHoles($courseId)
   {
      require_once 'core/hole.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();

      $query= data_query("SELECT id, Course, HoleNumber, Par, Length FROM :Hole
                            WHERE Course = %d
                            ORDER BY HoleNumber", $courseId);
      $result = mysql_query($query);
      if (is_a($result, 'Error')) return $result;

      if (mysql_num_rows($result) > 0) {
         $index = 1;
         while ($row = mysql_fetch_assoc($result)) {
            $hole =  new Hole($row);
            $retValue[] = $hole;

         }
      }

      mysql_free_result($result);

      return $retValue;
   }

   function CourseUsed($courseId)
   {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $query = data_query("SELECT id FROM `:Round` WHERE `:Round`.Course = %d LIMIT 1", $courseId);
      $res = mysql_query($query);

      if (!$res) return Error::Query($query);
      return mysql_num_rows($res) == 1;
   }

   function GetEventHoles($eventId)
   {
      require_once 'core/hole.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $eventId = (int) $eventId;

      $result = mysql_query(data_query("SELECT :Hole.id, :Hole.Course, HoleNumber, Par, Length, :Round.id AS Round FROM :Hole
                            INNER JOIN :Course ON (:Course.id = :Hole.Course)
                            INNER JOIN :Round ON (:Round.Course = :Course.id)
                            INNER JOIN :Event ON :Round.Event = :Event.id
                            WHERE :Event.id = $eventId
                            ORDER BY :Round.StartTime, HoleNumber"));

      if (mysql_num_rows($result) > 0) {
         $index = 1;
         while ($row = mysql_fetch_assoc($result)) {
            $hole =  new Hole($row);
            $retValue[] = $hole;

         }
      }

      mysql_free_result($result);

      return $retValue;
   }

   function GetHoleDetails($holeid)
   {
      require_once 'core/hole.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = null;
      $holeid = (int) $holeid;

      $query = data_Query("SELECT :Hole.id, :Hole.Course, HoleNumber, Par, Length,
                            :Course.id CourseId, :Round.id RoundId FROM :Hole
                            LEFT JOIN :Course ON (:Course.id = :Hole.Course)
                            LEFT JOIN :Round ON (:Round.Course = :Course.id)
                            WHERE :Hole.id = $holeid
                            ORDER BY HoleNumber");
      $result = mysql_query($query);
      if (!$result) return Error::Query($query);
      if (mysql_num_rows($result) > 0) {
         $index = 1;
         $row = mysql_fetch_assoc($result);

         $retValue =  new Hole($row);

      }

      mysql_free_result($result);

      return $retValue;
   }

   function GetRoundResults($roundId, $sortedBy)
   {
      require_once 'core/hole.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $groupByClass = false;
      if ($sortedBy == 'resultsByClass') $groupByClass = true;

      $retValue = array();
      $roundId = (int) $roundId;

      $query = "SELECT :Player.player_id as PlayerId, :Player.firstname FirstName, :Player.lastname LastName, :Player.pdga PDGANumber,
                    :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                    :StartingOrder.PoolNumber, (:HoleResult.Result - :Hole.Par) AS Plusminus, Completed,
                    :HoleResult.Result AS HoleResult, :Hole.id AS HoleId, :Hole.HoleNumber, :RoundResult.PlusMinus RoundPlusMinus,
                    :Classification.Name ClassName, CumulativePlusminus, CumulativeTotal, :RoundResult.DidNotFinish,
                    :Classification.id Classification

                            FROM :Round
                            LEFT JOIN :Section ON :Round.id = :Section.Round
                            LEFT JOIN :StartingOrder ON (:StartingOrder.Section = :Section.id )

                            LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                            LEFT JOIN :HoleResult ON (:HoleResult.RoundResult = :RoundResult.id AND :HoleResult.Player = :StartingOrder.Player)
                            LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
                            LEFT JOIN :User ON :Player.player_id = :User.Player
                            LEFT JOIN :Participation ON (:Participation.Player = :Player.player_id AND
                                                        :Participation.Event = :Round.Event)
                            LEFT JOIN :Classification ON :Classification.id = :Participation.Classification
                            LEFT JOIN :Hole ON :HoleResult.Hole = :Hole.id
                            WHERE :Round.id = $roundId AND :Section.Present
                            ";

      switch ($sortedBy) {

        case 'group':
            $query .= "ORDER BY :StartingOrder.PoolNumber, :StartingOrder.id";
            break;
        case 'results':
        case 'resultsByClass':

            $query .= "ORDER BY (:RoundResult.DidNotFinish IS NULL OR :RoundResult.DidNotFinish = 0) DESC,  :Hole.id IS NULL, :RoundResult.CumulativePlusminus, :Player.player_id";
            break;
        default:
            return Error::InternalError();
      }

      $query = data_query($query);
      $result = mysql_query($query);

      echo mysql_error();
      if (mysql_num_rows($result) > 0) {
         $index = 1;
         $lastrow = null;
         while ($row = mysql_fetch_assoc($result)) {
            if (!$row['PlayerId']) continue;

            if (@$lastrow['PlayerId'] != $row['PlayerId']) {
                if ($lastrow) {
                    if ($groupByClass) {
                        $class = $lastrow['ClassName'];
                        if (!isset($retValue[$class])) $retValue[$class] = array();
                        $retValue[$class][] = $lastrow;
                    } else {
                        $retValue[] = $lastrow;
                    }
                }
                $lastrow = $row;
                $lastrow['Results'] = array();
                $lastrow['TotalPlusMinus'] = $lastrow['Penalty'];
            }

            $lastrow['Results'][$row['HoleNumber']] = array(
                'Hole' => $row['HoleNumber'],
                'HoleId' => $row['HoleId'],
                'Result' => $row['HoleResult']
                );

            $lastrow['TotalPlusMinus'] += $row['Plusminus'];

         }

        if ($lastrow) {
            if ($groupByClass) {
                $class = $lastrow['ClassName'];
                if (!isset($retValue[$class])) $retValue[$class] = array();
                $retValue[$class][] = $lastrow;
            } else {
                $retValue[] = $lastrow;
            }
        }
    }
      mysql_free_result($result);
    if ($sortedBy == 'resultsByClass') $retValue = data_FinalizeResultSort($roundId, $retValue);
      return $retValue;
   }

   function GetEventResults($eventId)
   {
      require_once 'core/hole.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $eventId = (int) $eventId;

      $query = "SELECT :Participation.*, player_id as PlayerId, :Player.firstname FirstName, :Player.lastname LastName, :Player.pdga PDGANumber,
                    :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                    :StartingOrder.PoolNumber, (:HoleResult.Result - :Hole.Par) AS Plusminus,
                    :HoleResult.Result AS HoleResult, :Hole.id AS HoleId, :Hole.HoleNumber,
                    :Classification.Name ClassName,
                    TournamentPoints, :Round.id RoundId,
                    :Participation.Standing

                            FROM :Round
                            INNER JOIN :Event ON :Round.Event = :Event.id
                            INNER JOIN :Section ON :Section.Round = :Round.id
                            INNER JOIN :StartingOrder ON (:StartingOrder.Section = :Section.id )
                            LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                            LEFT JOIN :HoleResult ON (:HoleResult.RoundResult = :RoundResult.id AND :HoleResult.Player = :StartingOrder.Player)
                            LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
                            LEFT JOIN :Participation ON (:Participation.Event = $eventId AND :Participation.Player = :Player.player_id)
                            LEFT JOIN :Classification ON :Participation.Classification = :Classification.id
                            LEFT JOIN :User ON :Player.player_id = :User.Player
                            LEFT JOIN :Hole ON :HoleResult.Hole = :Hole.id
                            WHERE :Event.id = $eventId AND :Section.Present AND :Participation.EventFeePaid IS NOT NULL
                            ORDER BY :Participation.Standing, player_id, :Round.StartTime, :Hole.HoleNumber

                            ";

      $query = data_query($query);
      $result = mysql_query($query);

      if (!$result) return Error::Query($query);
      $penalties = array();
      if (mysql_num_rows($result) > 0) {

         $index = 1;
         $lastrow = null;
         while ($row = mysql_fetch_assoc($result)) {

            if (!$lastrow || @$lastrow['PlayerId'] != $row['PlayerId']) {
                if ($lastrow) $retValue[] = $lastrow;
                $lastrow = $row;
                $lastrow['Results'] = array();
                $lastrow['TotalPlusMinus'] = $lastrow['Penalty'];
                $penalties[$row['RoundId']] = true;
            }

            if (!@$penalties[$row['RoundId']]) {
                $penalties[$row['RoundId']] = true;
                $lastrow['Penalty'] += $row['Penalty'];
            }

            if ($row['HoleResult']) {
               $lastrow['Results'][$row['RoundId'] . '_' . $row['HoleNumber']] = array(
                   'Hole' => $row['HoleNumber'],
                   'HoleId' => $row['HoleId'],
                   'Result' => $row['HoleResult']
                   );
               $lastrow['TotalPlusMinus'] += $row['Plusminus'];
            }

         }
         if ($lastrow) $retValue[] = $lastrow;
      }

     mysql_free_result($result);

      return $retValue;
   }

   function GetEventResultsWithoutHoles($eventId)
   {
      require_once 'core/hole.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $eventId = (int) $eventId;

      $query = "SELECT :Participation.*, player_id as PlayerId, :Player.firstname FirstName, :Player.lastname LastName, :Player.pdga PDGANumber,
                    :RoundResult.Result AS Total, :RoundResult.Penalty, :RoundResult.SuddenDeath,
                    :StartingOrder.PoolNumber, CumulativePlusminus, Completed  ,
                    :Classification.Name ClassName, PlusMinus, :StartingOrder.id StartId,
                    TournamentPoints, :Round.id RoundId,
                    :Participation.Standing

                            FROM :Round
                            INNER JOIN :Event ON :Round.Event = :Event.id
                            INNER JOIN :Section ON :Section.Round = :Round.id
                            INNER JOIN :StartingOrder ON (:StartingOrder.Section = :Section.id )
                            LEFT JOIN :RoundResult ON (:RoundResult.Round = :Round.id AND :RoundResult.Player = :StartingOrder.Player)
                            LEFT JOIN :Player ON :StartingOrder.Player = :Player.player_id
                            LEFT JOIN :Participation ON (:Participation.Event = $eventId AND :Participation.Player = :Player.player_id)
                            LEFT JOIN :Classification ON :Participation.Classification = :Classification.id
                            LEFT JOIN :User ON :Player.player_id = :User.Player
                            WHERE :Event.id = $eventId AND :Section.Present AND :Participation.EventFeePaid IS NOT NULL
                            ORDER BY :Participation.Standing, player_id, :Round.StartTime

                            ";

      $query = data_query($query);

      $result = mysql_query($query);

      if (!$result) return Error::Query($query);
      $penalties = array();
      if (mysql_num_rows($result) > 0) {

         $index = 1;
         $lastrow = null;
         while ($row = mysql_fetch_assoc($result)) {

            if (!$lastrow || @$lastrow['PlayerId'] != $row['PlayerId']) {
                if ($lastrow) $retValue[] = $lastrow;
                $lastrow = $row;
                $lastrow['Results'] = array();
                $lastrow['TotalCompleted'] = 0;
                $lastrow['TotalPlusminus'] = 0;
            }

            $lastrow['TotalCompleted'] += $row['Completed'];
            $lastrow['TotalPlusminus'] += $row['PlusMinus'];
            $lastrow['Results'][$row['RoundId']] = $row;

         }
         if ($lastrow) $retValue[] = $lastrow;
      }

      usort($retValue, 'data_sort_leaderboard');

            mysql_free_result($result);

      return $retValue;
   }

   function GetTournamentResults($tournamentId)
   {
      require_once 'core/hole.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $retValue = array();
      $tournamentId = (int) $tournamentId;

      $query = "SELECT :Player.player_id as PlayerId, :Player.firstname FirstName , :Player.lastname LastName, :Player.pdga PDGANumber, :User.Username,
                    :TournamentStanding.OverallScore, :TournamentStanding.Standing,
                    :Event.id EventId, :Classification.Name ClassName, TieBreaker,
                    :Participation.Standing AS EventStanding, :Participation.TournamentPoints AS EventScore
                  FROM
                     :Tournament
                     INNER JOIN :Event ON :Event.Tournament = :Tournament.id
                     INNER JOIN :Participation ON :Participation.Event = :Event.id
                     INNER JOIN :Player ON :Participation.Player = :Player.player_id
                     INNER JOIN :User ON :User.Player = :Player.player_id
                     INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                     LEFT JOIN :TournamentStanding ON (:TournamentStanding.Tournament = :Tournament.id AND :TournamentStanding.Player = :Player.player_id)
                     WHERE :Tournament.id = $tournamentId AND :Participation.EventFeePaid IS NOT NULL AND :Event.ResultsLocked IS NOT NULL
                     ORDER BY
                        :TournamentStanding.Standing,
                        :Player.lastname,
                        :Player.firstname


                            ";

      $query = data_query($query);
      $result = mysql_query($query);
      echo mysql_error();
      if (!$result) return Error::Query($query);

      if (mysql_num_rows($result) > 0) {
         $index = 1;
         $lastrow = null;
         while ($row = mysql_fetch_assoc($result)) {
            if (@$lastrow['PlayerId'] != $row['PlayerId']) {
                if ($lastrow) $retValue[] = $lastrow;
                $lastrow = $row;
                $lastrow['Results'] = array();

            }

            $lastrow['Results'][$row['EventId']] = array(
                'Event' => $row['EventId'],
                'Standing' => $row['EventStanding'],
                'Score' => $row['EventScore']
                );

         }
         if ($lastrow) $retValue[] = $lastrow;
      }
      mysql_free_result($result);

      return $retValue;
   }

 function GetSignupsForClass($event, $class)
 {
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }
   $classId = (int) $class;
   $eventId = (int) $event;

   $retValue = array();
   $query = data_query("SELECT :Player.id PlayerId, :User.FirstName, :User.LastName, :Player.PDGANumber,
                    :Participation.id ParticipationId
                 FROM :User
                 INNER JOIN :Player ON User.id = :Player.User
                 INNER JOIN :Participation ON :Participation.Player = :Player.id
                 WHERE :Participation.Classification = $classId
                   AND :Participation.Event = $eventId");

  $result = mysql_query($query);

   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $retValue[] = $row;
      }
   }
   mysql_free_result($result);

   return $retValue;
 }

 function GetQueueForClass($event, $class)
 {
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }
   $classId = (int) $class;
   $eventId = (int) $event;

   $retValue = array();
   $query = data_query("SELECT :Player.id PlayerId, :User.FirstName, :User.LastName, :Player.PDGANumber,
                    :EventQueue.id ParticipationId
                 FROM :User
                 INNER JOIN :Player ON User.id = :Player.User
                 INNER JOIN :Participation ON :EventQueue.Player = :Player.id
                 WHERE :EventQueue.Classification = $classId
                   AND :EventQueue.Event = $eventId");

   $result = mysql_query($query);
   if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_assoc($result)) {
         $retValue[] = $row;
      }
   }
   mysql_free_result($result);

   return $retValue;
 }

    function GetSectionMembers($sectionId)
    {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $sectionId = (int) $sectionId;

      $retValue = array();
      $query = "SELECT :Player.player_id PlayerId, :User.UserFirstName, :User.UserLastName, :Player.pdga PDGANumber,
                    :Player.firstname pFN, :Player.lastname pLN, :Player.email pEM, :Classification.Name Classification,
                       SM.id as MembershipId
                    FROM :User
                    INNER JOIN :Player ON :User.Player = :Player.player_id
                    INNER JOIN :Participation ON :Player.player_id = :Participation.Player
                    INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                    INNER JOIN :SectionMembership SM ON SM.Participation = :Participation.id
                    WHERE SM.Section = $sectionId
                      ORDER BY SM.id
                        ";

      $query = data_query($query);
      $result = mysql_query($query);
      echo mysql_error();

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $row['FirstName'] = data_GetOne($row['UserFirstName'], $row['pFN']);
            $row['LastName'] = data_GetOne($row['UserLastName'], $row['pLN']);
            //$row['Email'] = data_GetOne($row['UserEmail'], $row['pEM']);

            $retValue[] = $row;
         }
      }
      mysql_free_result($result);

      return $retValue;

    }

    function GetAllAds($eventid)
   {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = array();

      if ($eventid) $eventCond = " = " . (int) $eventid;
      else $eventCond = " IS NULL";

      $eventid =  esc_or_null( $eventid, 'int');
      $result = mysql_query(data_query("SELECT id, Event, URL, ImageURL, LongData, ImageReference, Type, ContentId  FROM :AdBanner WHERE Event $eventCond"));

      if (mysql_num_rows($result) > 0) {
         while ($row = mysql_fetch_assoc($result)) {
            $temp = new Ad($row);
            $retValue[] = $temp;
         }
      }
      mysql_free_result($result);

      return $retValue;
   }

   function GetAd($eventid, $contentId)
   {
    require_once 'core/ads.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = null;

      if ($eventid) $eventCond = " = " . (int) $eventid;
      else $eventCond = " IS NULL";

      $contentId = mysql_real_escape_string($contentId);

      $eventid =  esc_or_null( $eventid, 'int');
      $query = data_query("SELECT id, Event, URL, ImageURL, LongData, ImageReference, Type, ContentId  FROM :AdBanner WHERE Event $eventCond AND ContentId = '%s'"
                          ,$contentId);
      $result = mysql_query($query);

      if (!$result) {
         return Error::Query($query);
      }

      if (mysql_num_rows($result) > 0) {
         $row = mysql_fetch_assoc($result);

        $retValue = new Ad($row);

      }
      mysql_free_result($result);

      return $retValue;
   }

   function InitializeAd($eventid, $contentId)
   {
    require_once 'core/ads.php';

      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }
      $retValue = array();

      $contentId = mysql_real_escape_string($contentId);

      //$result = mysql_query("SELECT id, Event, URL, ImageURL, LongData, ImageReference, Type  FROM AdBanner WHERE Event $eventCond AND ContentId = '$contentId'");
      $query = data_query( "INSERT INTO :AdBanner (Event, URL, ImageURL, LongData, ImageReference, Type, ContentId)
                       VALUES (%s, NULL, NULL, NULL, NULL, '%s', '%s')",
                       esc_or_null($eventid, 'int'), ($eventid ? AD_EVENT_DEFAULT : AD_DEFAULT), mysql_real_escape_string($contentId));

      if (!mysql_query($query)) {
        return Error::Query($query, 'InitializeAd');
      }

      return GetAd($eventid, $contentId);

   }

   function data_ProduceSearchConditions($queryString, $fields)
   {
      if (trim($queryString) == "") return "1";

      $words = explode(' ', $queryString);
      $words = array_filter($words, 'data_RemoveEmptyStrings');
      $words = array_map('mysql_real_escape_string', $words);

      $wordSpecificBits = array();

      if (!count($words)) return "1";

      foreach ($words as $word) {
         $fieldSpecificBits = array();
         foreach ($fields as $field) {
            $field = str_replace('.', '`.`', $field);
            $fieldSpecificBits[] = "(`$field` LIKE '%$word%')";
         }
         $wordSpecificBits[] = '('. implode(' OR ', $fieldSpecificBits) . ')';
      }

      return '(' . implode(' AND ', $wordSpecificBits) . ')';
   }

   function data_RemoveEmptyStrings($item)
   {
      return $item !== '';

   }
   function GetResultUpdatesSince($eventId, $roundId, $time)
    {
        if ((int) $time < 10) $time = 10;

      if ($roundId) {
         $query = data_query("SELECT :HoleResult.Player, :HoleResult.Hole, :HoleResult.Result,
                             :RoundResult.`Round`, :Hole.HoleNumber
                          FROM :HoleResult
                          INNER JOIN :RoundResult ON :HoleResult.RoundResult = :RoundResult.id
                          INNER JOIN :Hole ON :Hole.id = :HoleResult.Hole
                          WHERE :RoundResult.`Round` = %d
                          AND :HoleResult.LastUpdated > FROM_UNIXTIME(%d)
                          ", $roundId, $time - 2);
      } else {
         $query = data_query("SELECT :HoleResult.Player, :HoleResult.Hole, :HoleResult.Result,
                             HoleNumber,
                             :RoundResult.`Round`
                          FROM :HoleResult
                          INNER JOIN :RoundResult ON :HoleResult.RoundResult = :RoundResult.id
                          INNER JOIN `:Round` ON `:Round`.id = :RoundResult.`Round`
                          INNER JOIN :Hole ON :Hole.id = :HoleResult.Hole
                          WHERE `:Round`.Event = %d
                          AND :HoleResult.LastUpdated > FROM_UNIXTIME(%d)
                          ", $eventId, $time - 2);
      }

      $out = array();

      $res = mysql_query($query);
      echo mysql_error();

      while (($row = mysql_fetch_assoc($res)) !== false) {
         $out[] = array(
            'PlayerId' => $row['Player'],
            'HoleId' => $row['Hole'],
            'HoleNum' => $row['HoleNumber'],
            'Special' => null,
            'Value' => $row['Result'],
            'RoundId' => $row['Round']

         );
      }

       mysql_free_result($res);
      $query = data_query("SELECT Result, Player, SuddenDeath, Penalty, Round
                       FROM :RoundResult
                       WHERE :RoundResult.`Round` = %d
                       AND LastUpdated > FROM_UNIXTIME(%d)
                       ", $roundId, $time);

      $res = mysql_query($query);
      echo mysql_error();

      while (($row = mysql_fetch_assoc($res)) !== false) {
         $out[] = array(
            'PlayerId' => $row['Player'],
            'HoleId' => null,
            'HoleNum' => 0,
            'Special' => 'Sudden Death',
            'Value' => $row['SuddenDeath'],
            'RoundId' => $row['Round']
         );
         $out[] = array(
            'PlayerId' => $row['Player'],
            'HoleId' => null,
            'HoleNum' => 0,
            'Special' => 'Penalty',
            'Value' => $row['Penalty'],
            'RoundId' => $row['Round']
         );
      }
      mysql_free_result($res);

      return $out;
    }

    function SaveResult($roundid, $playerid, $holeid, $special, $result)
    {
      $dbError = InitializeDatabaseConnection();
      if($dbError)

         return $dbError;
      $rrid = GetRoundResult($roundid, $playerid);
      if (is_a($rrid, 'Error'))
         return $rrid;

      if ($holeid === null) {
         return data_UpdateRoundResult($rrid, $special, $result);
      } else {
         return data_UpdateHoleResult($rrid, $playerid, $holeid, $result);
      }
    }

    function data_UpdateHoleResult($rrid, $playerid, $holeid, $result)
    {
      mysql_query(data_query("LOCK TABLE :HoleResult WRITE"));
      $query = data_query("SELECT id FROM :HoleResult WHERE RoundResult = %d AND Player = %d AND Hole = %d",
         $rrid, $playerid, $holeid);
      $dbres = mysql_query($query);

      if (!mysql_num_rows($dbres)) {
         $query = data_query("INSERT INTO :HoleResult (Hole, RoundResult, Player, Result, DidNotShow, LastUpdated) VALUES (%d, %d, %d, 0, 0, NOW())",
           $holeid, $rrid, $playerid);
         mysql_query($query);
         echo mysql_error();
      }

      $dns = 0;
      if ($result == 99 || $result == 999) {
         $dns = 1;
         $result = 99;
      }

      $query = data_query("UPDATE :HoleResult SET Result = %d, DidNotShow = %d, LastUpdated = NOW() WHERE RoundResult = %d AND Hole = %d AND Player = %d",
                     $result, $dns, $rrid, $holeid, $playerid);
      mysql_query($query);
      echo mysql_error();

      mysql_query(data_query("UNLOCK TABLES"));

      return data_UpdateRoundResult($rrid);
    }

    function data_UpdateRoundResult($rrid, $modifyField = null, $modValue = null)
    {
      $query = data_query("SELECT `Round`, Penalty, SuddenDeath FROM :RoundResult WHERE id = %d",
         $rrid);
      $result = mysql_query($query);
      if (!$result) {
         echo mysql_error();

         return Error::Query($query);
      }
      $details = mysql_fetch_assoc($result);

      $round = GetRoundDetails($details['Round']);
      $numHoles = $round->NumHoles();

      $holeQuery = data_query("SELECT Result, DidNotShow, :Hole.Par FROM :HoleResult
                           INNER JOIN :Hole ON :HoleResult.Hole = :Hole.id
                           WHERE RoundResult = %d", $rrid);
      $result = mysql_query($holeQuery);
      if (!$result) {
         echo mysql_error();

         return Error::Query($holeQuery);
      }

      $holes = $total = $plusminus = $dnf = 0;
      while (($row = mysql_fetch_assoc($result)) !== false) {
         if ($row['DidNotShow']) {
            $dnf = true;
            break;
         } else {
            if ($row['Result']) {
               $total += $row['Result'];
               $ppm = $plusminus;
               $plusminus += $row['Result'] - $row['Par'];
               //echo sprintf("%d %d %d %d %d\n", $row['HoleNumber'], $ppm, $plusminus, $row['Result'], $row['Par']);
               $holes++;
            }
         }
      }
      $total += $details['Penalty'];
      $plusminus += $details['Penalty'];

      //$complete = ($total != 999 && $holes == $numHoles) ? 1 : 0;
      if ($total == 999) {
         $complete = $numHoles;  // all holes complete
      } else {
         $complete = $holes;
      }

      $penalty = $details['Penalty'];
      if ($modifyField == 'Penalty') {
        $total += $modValue - $details['Penalty'];
        $plusminus += $modValue - $details['Penalty'];
        $penalty = $modValue;
      }

      $suddendeath = $details['SuddenDeath'];
      if ($modifyField == 'Sudden Death')
         $suddendeath = $modValue;

      $query = data_query("UPDATE :RoundResult SET Result = %d, Penalty = %d, SuddenDeath = %d, Completed = %d,
                          DidNotFinish = %d, PlusMinus = %d, LastUpdated = NOW() WHERE id = %d",
                       $total, $penalty, $suddendeath, $complete, $dnf ? 1 : 0, $plusminus, $rrid);
      $res = mysql_query($query);
      if (!$res)
         return Error::Query($query);

      UpdateCumulativeScores($rrid);
      UpdateEventResults($round->eventId);
    }

    function UpdateCumulativeScores($rrid)
    {
        $query = data_query("
                SELECT :RoundResult.PlusMinus, :RoundResult.Result, :RoundResult.CumulativePlusminus,
                        :RoundResult.CumulativeTotal, :RoundResult.id,
                        :RoundResult.DidNotFinish
                        FROM :RoundResult
                        INNER JOIN `:Round` ON `:Round`.id = :RoundResult.`Round`
                        INNER JOIN `:Round` RX ON `:Round`.Event = RX.Event
                        INNER JOIN :RoundResult RRX ON RRX.`Round` = RX.id
                        WHERE RRX.id = %d AND RRX.Player = :RoundResult.Player
                        ORDER BY `:Round`.StartTime", $rrid);
        $res = mysql_query($query);
        echo mysql_error();
        $total = 0;
        $pm = 0;
        while (($row = mysql_fetch_assoc($res)) !== false) {
            if (!$row['DidNotFinish']) {
                $total += $row['Result'];
                $pm += $row['PlusMinus'];
            }

            if ($row['CumulativePlusminus'] != $pm || $row['CumulativeTotal'] != $total) {
                $q2 = data_query("UPDATE :RoundResult
                                    SET CumulativeTotal = %d,
                                        CumulativePlusminus = %d
                                    WHERE id = %d",
                                    $total, $pm, $row['id']);
                mysql_query($q2);
                echo mysql_error();
            }
        }
        mysql_free_result($res);
    }

    function GetRoundResult($roundid, $playerid)
    {
      $id = 0;
      $query = data_query("LOCK TABLE :RoundResult WRITE");
      $result = mysql_query($query);
      if ($result) {
         $query = data_query("SELECT id FROM :RoundResult WHERE `Round` = %d AND Player = %d",
            $roundid, $playerid);
         $result = mysql_query($query);

         if ($result) {
            $id = 0;
            $rows = mysql_num_rows($result);
            /* FIXME: Need to pinpoint where exactly does this score mangling happen
             * that causes two roundresult rows for same player on same round be created.
             * Then fix it and then decommission this piece of code. */
            if ($rows > 1) {
               /* Cleanest thing we can do is to throw away all the invalid scores and return error.
                * This way TD knows to reload the scoring page and can alleviate the error by re-entering. */
               $query = data_query("DELETE FROM :RoundResult WHERE `Round` = %d AND Player = %d", $roundid, $playerid);
               mysql_query($query);
               // Fall thru the the end and return Error to get proper cleanup on the way
            } elseif (!mysql_num_rows($result)) {
               $query = data_query("INSERT INTO :RoundResult (`Round`, Player, Result, Penalty, SuddenDeath, Completed, LastUpdated)
                                VALUES (%d, %d, 0, 0, 0, 0, NOW())",
                                $roundid, $playerid);
               $result = mysql_query($query);
               if ($result)
                  $id = mysql_insert_id();
            } else {
               $row = mysql_fetch_assoc($result);
               $id = $row['id'];
            }
         }

         mysql_query(data_query("UNLOCK TABLES"));
      }

      if ($id)
         return $id;

      echo mysql_error();

      return Error::Query($query);
    }

    function CreateSection($round, $baseClassId, $name)
    {
      //@@section
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $round = (int) $round;

      $name = mysql_real_escape_string($name);

      $query = data_query("INSERT INTO :Section(Round, Classification, Name, Present) VALUES(%d, %s, '%s', 1)", $round, esc_or_null($baseClassId, 'int'), $name);

      $retValue = new Error();
      $retValue->title = "error_db_query";
      $retValue->description = translate( "error_db_query_description");
      $retValue->internalDescription = "Query failed";
      $retValue->function = "CreateSubClass()";
      $retValue->IsMajor = true;
      $retValue->data = "Name: " . $name;

      if (mysql_query($query)) {
         $classId = mysql_insert_id();

      } else {
         echo $query;
         die(mysql_error());

         return $retValue;
      }

      return $classId;
    }

    function RenameSection($classId, $newName)
    {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $classId = (int) $classId;
      $newName = mysql_real_escape_string($newName);
      $query = data_query("UPDATE :Section SET Name = '%s' WHERE id = %d", $newName, $classId);

      if (!mysql_query($query)) {
          $retValue = new Error();
          $retValue->title = "error_db_query";
          $retValue->description = translate( "error_db_query_description");
          $retValue->internalDescription = "Query failed";
          $retValue->function = "RenameSubClass()";
          $retValue->IsMajor = true;
          $retValue->data = "ClassId: " . $classId;

          return $retValue;
      }
    }

    function AssignPlayersToSection($roundId, $sectionid, $playerIds)
    {
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

       $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $each = array();
      foreach ($playerIds as $playerId) $each[] = sprintf("(%d, %d)",
                                                        GetParticipationIdByRound($roundId, $playerId),
                                                        $sectionid);

      $data = implode(", ", $each);
      $query = data_query("INSERT INTO :SectionMembership (Participation, Section) VALUES %s"
                      , $data);

       if ( !mysql_query($query)) {
             $err = new Error();
             $err->title = "error_db_query";
             $err->description = translate( "error_db_query_description");
             $err->internalDescription = "Failed SQL UPDATE";
             $err->function = "SectionMembership()";
             $err->isMajor = true;

             return $err;
       }

    }

    function EditSection($roundId, $sectionId, $priority, $startTime)
    {
   //@@section
      $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

      $roundId = (int) $roundId;
      $classId = (int) $classId;
      $priority = esc_or_null($priority, 'int');
      $startTime = esc_or_null($startTime, 'int');

      $query = data_query("UPDATE :ClassOnRound SET Priority = %s, StartTime = FROM_UNIXTIME(%s) WHERE Round = %d AND Classification = %d",
                               $priority, $startTime, $roundId, $classId);

      if (!mysql_query($query)) {
         $retValue = new Error();
          $retValue->title = "error_db_query";
          $retValue->description = translate( "error_db_query_description");
          $retValue->internalDescription = "Query failed";
          $retValue->function = "AdjustClassOnRound()";
          $retValue->IsMajor = true;
          $retValue->data = sprintf("RoundId: %d, ClassId: %d", $roundId, $classId);

          return $retValue;
      }
    }

/**
 * Stores or removes the event fee payment of a single player
 */
function MarkEventFeePayment($eventid, $participationId, $payment)
{
   $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $query = data_query("UPDATE :Participation SET EventFeePaid = FROM_UNIXTIME(%s), Approved = 1 WHERE id = %d AND Event = %d",
                          ($payment ? time() : "NULL"), (int) $participationId, (int) $eventid);

    if ( !mysql_query($query)) {
          $err = new Error();
          $err->title = "error_db_query";
          $err->description = translate( "error_db_query_description");
          $err->internalDescription = "Failed SQL UPDATE";
          $err->function = "MarkEventFeePayment()";
          $err->IsMajor = true;
          $err->data = "Event id: " . $eventid;

          return $err;
    }
}

function SetRoundDetails($roundid, $date, $startType, $interval, $valid, $course)
{
    $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   $query = data_query("UPDATE :Round SET StartTime = FROM_UNIXTIME(%d), StartType = '%s', `Interval` = %d, ValidResults = %d, Course = %s WHERE id = %d",
                    (int) $date,
                    mysql_real_escape_string($startType),
                    (int) $interval,
                    $valid ?  1:  0,
                    esc_or_null($course, 'int'),
                    $roundid);

    if ( !mysql_query($query)) {
          return Error::Query($query);
    }
}

function SaveHole($hole)
{
   //
    $dbError = InitializeDatabaseConnection();
   if ($dbError) {
      return $dbError;
   }

   if ($hole->id) {

      $query = data_query("UPDATE :Hole SET Par = %d, Length = %d, HoleNumber = %d WHERE id = %d",
                       (int) $hole->par,
                       (int) $hole->length,
                       $hole->holeNumber,
                       (int) $hole->id);
   } else {
      $query = data_query("INSERT INTO :Hole (Par, Length, Course, HoleNumber) VALUES (%d, %d, %d, %d)",
                       (int) $hole->par,
                       (int) $hole->length,
                       (int) $hole->course,
                       $hole->holeNumber);

   }

    if ( !mysql_query($query)) {
          return Error::Query($query);
    }

}

function PlayerOnRound($roundid, $playerid)
{
   $dbError = InitializeDatabaseConnection();
    if ($dbError) {
        return $dbError;
    }

    $query = data_query("SELECT :Participation.Player FROM :Participation
                     INNER JOIN :SectionMembership ON :SectionMembership.Participation = :Participation.id
                     INNER JOIN :Section ON :Section.id = :SectionMembership.Section
                     WHERE :Participation.Player = %d
                     AND   :Section.Round = %d

                     LIMIT 1",
                     $playerid,
                     $roundid);
    $res = mysql_query($query);

    return mysql_num_rows($res) != 0;

}

function GetParticipationIdByRound($roundid, $playerid)
{
   $dbError = InitializeDatabaseConnection();
    if ($dbError) {
        return $dbError;
    }

    $query = data_query("SELECT :Participation.id FROM :Participation
                     INNER JOIN :Event ON :Event.id = :Participation.Event
                     INNER JOIN :Round ON :Round.Event = :Event.id

                     WHERE :Participation.Player = %d
                     AND :Round.id = %d
                     ",
                     $playerid,
                     $roundid);
    $res = mysql_query($query);

    $row = mysql_fetch_assoc($res);

    mysql_free_result($res);

    if ($row === false) return null;
    return $row['id'];

}

function RemovePlayersFromRound($roundid, $playerids = null)
{

   if (!is_array($playerids)) $playerids = array($playerids);
    $dbError = InitializeDatabaseConnection();
    if ($dbError) {
        return $dbError;
    }

    $retValue = null;
    $playerids = array_filter($playerids, 'is_numeric');

    $q1 = data_query( "SELECT :SectionMembership.id FROM :SectionMembership
      INNER JOIN :Section ON :Section.id = :SectionMembership.Section
      INNER JOIN :Participation ON :Participation.id = :SectionMembership.Participation
      WHERE :Section.Round = %d AND :Participation.Player IN (%s)",
      $roundid,
      implode(", " ,$playerids));

   $res1 = mysql_query($q1);
   echo mysql_error();
   $ids = array();
   while (($row = mysql_fetch_assoc($res1)) !== false) {
      $ids[] = $row['id'];
   }

   mysql_free_result($res1);
    if (!count($ids)) return;

    $query = data_query( "DELETE FROM :SectionMembership WHERE id IN (%s)",
      implode(", ", $ids ));

    if ( !mysql_query( $query)) {
      die(mysql_error() . "\n\n<br />$query");
        $err = new Error();
        $err->title = "error_db_query";
        $err->description = translate( "error_db_query_description");
        $err->internalDescription = "Failed SQL INSERT query (Participation)";
        $err->function = "CancelSignup()";
        $err->IsMajor = true;

        $retValue = $err;
    }

    return $retValue;
}

function ResetRound($roundid, $resetType = 'full')
{
   $sections = GetSections((int) $roundid);
   $sectIds = array();

   foreach ($sections as $section) {
      $sectIds[] = $section->id;
   }
   $idList = implode(', ', $sectIds);

   if ($resetType == 'groups' || $resetType == 'full') {

      $query = data_query("DELETE FROM :StartingOrder WHERE Section IN ($idList)");

      mysql_query($query);
      echo mysql_error();

   }

   if ($resetType == 'full' || $resetType == 'players') {

      $query = data_query("DELETE FROM :SectionMembership WHERE Section IN ($idList)");

      mysql_query($query);

   }

   if ($resetType == 'full') {

      $query = data_query("DELETE FROM :Section WHERE id IN ($idList)");
      mysql_query($query);
      echo mysql_error();

   }

}

function RemoveEmptySections($round)
{
   $sections = GetSections((int) $round);
   foreach ($sections as $section) {
      $players = $section->GetPlayers();

      if (!count($players)) {
         $query = data_query("DELETE FROM :Section WHERE id = %d", $section->id);
         mysql_query($query);
      }
   }
}

function AdjustSection($sectionid, $priority, $sectionTime, $present)
{
   $query = data_query("UPDATE :Section SET Priority = %d, StartTime = FROM_UNIXTIME(%s), Present = %d WHERE id = %d",
                     $priority,
                     esc_or_null($sectionTime, 'int'),
                     $present ? 1 : 0,
                     $sectionid
                    );

   if (!mysql_query($query)) {
      return Error::Query($query);
   }

}

function GetGroups($sectid)
{
      $query = data_query("
            SELECT
               :Player.player_id PlayerId, :Player.pdga PDGANumber, :StartingOrder.Section,
               :StartingOrder.id, UNIX_TIMESTAMP(:StartingOrder.StartingTime) StartingTime, :StartingOrder.StartingHole, :StartingOrder.PoolNumber,
               :User.UserFirstName, :User.UserLastName, firstname pFN, lastname pLN, :Classification.Name Classification
               FROM :StartingOrder
               INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
               INNER JOIN :User ON :Player.player_id = :User.Player
               INNER JOIN :Section ON :StartingOrder.Section = :Section.id
               INNER JOIN :Round ON :Round.id = :Section.Round
               INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
               INNER JOIN :Classification ON :Participation.Classification = :Classification.id
               WHERE :StartingOrder.`Section` = %d
               ORDER BY PoolNumber",
               $sectid);

      $res = mysql_query($query);
      echo mysql_error();
      if (!$res) return Error::Query($query);

      $current = null;
      $out = array();
      $group = null;

      while (($row = mysql_fetch_assoc($res)) !== false) {
        $row['FirstName'] = data_GetOne($row['UserFirstName'], $row['pFN']);
        $row['LastName'] = data_GetOne($row['UserLastName'], $row['pLN']);
         if ($row['PoolNumber'] != $current) {
            if (count($group)) $out[] = $group;
            $group = $row;
            $group['People'] = array();
            $current = $row['PoolNumber'];
            $group['GroupId'] = sprintf("%d-%d", $row['Section'], $row['PoolNumber']);

            if ($row['StartingHole']) {
               $group['DisplayName'] = $row['StartingHole'];
            } else {
               $group['DisplayName'] = date('H:i', $row['StartingTime']);
            }

         }
         $group['People'][] = $row;
      }

      if (count($group)) $out[] = $group;
      mysql_free_result($res);

      return $out;

  }

  function InsertGroup($group)
  {
   foreach ($group['People'] as $player) {
      $query = data_query("INSERT INTO :StartingOrder
                       (Player, StartingTime, StartingHole, PoolNumber, Section)
                     VALUES (%d, FROM_UNIXTIME(%d), %s, %d, %d)",
                     $player['PlayerId'],
                     $group['StartingTime'],
                     esc_or_null($group['StartingHole'], 'int'),
                     $group['PoolNumber'],
                     $group['Section']);
      mysql_query($query);
      echo mysql_error();
   }
  }

  function InsertGroupMember($data)
  {
   $query = data_query("INSERT INTO :StartingOrder
                    (Player, StartingTime, StartingHole, PoolNumber, Section)
                    VALUES (%d, FROM_UNIXTIME(%d), %s, %d, %d)",
                    $data['Player'],
                    $data['StartingTime'],
                    esc_or_null($data['StartingHole'], 'int'),
                    $data['PoolNumber'],
                    $data['Section']);
   mysql_query($query);
   echo mysql_error();
  }

  function GetAllRoundResults($eventid)
  {
      $query = data_query("SELECT :RoundResult.id, `Round`, Result, Penalty, SuddenDeath, Completed, Player, PlusMinus, DidNotFinish
                        FROM :RoundResult
                       INNER JOIN `:Round` ON `:Round`.id = :RoundResult.`Round`
                       WHERE `:Round`.Event = %d", $eventid);
      $result = mysql_query($query);
      echo mysql_error();

      $out = array();

      while (($row = mysql_fetch_assoc($result)) !== false) {
         $out[] = $row;
      }
      mysql_free_result($result);

      return $out;

  }

  function GetHoleResults($rrid)
  {
   $query = data_query("SELECT Hole, Result FROM :HoleResult WHERE RoundResult = %d", $rrid);
   $result = mysql_query($query);
   $out = array();
   while (($row = mysql_fetch_assoc($result)) !== false) {
      $out[] = $row;
   }
   mysql_free_result($result);

   return $out;
  }

  function GetAllParticipations($eventid)
  {
      $query = data_query("SELECT Classification, :Classification.Name,
                       :Participation.Player, :Participation.id,
                       :Participation.Standing, :Participation.DidNotFinish, :Participation.TournamentPoints,
                       :Participation.OverallResult
                       FROM :Participation
                       INNER JOIN :Classification ON :Classification.id = :Participation.Classification

                       WHERE Event = %d AND EventFeePaid IS NOT NULL", $eventid);

      $result = mysql_query($query);
      echo mysql_error();

      $out = array();

      while (($row = mysql_fetch_assoc($result)) !== false) {
         $out[] = $row;
      }
      mysql_free_result($result);

      return $out;

  }

  function SaveParticipationResults($entry)
  {
      $query = data_query("UPDATE :Participation
                           SET OverallResult = %d,
                           Standing = %d,
                           DidNotFinish = %d,
                           TournamentPoints = %d
                        WHERE id = %d",
                        $entry['OverallResult'],
                        $entry['Standing'],
                        $entry['DidNotFinish'],
                        $entry['TournamentPoints'],
                        $entry['id']
                        );

      mysql_query($query);
      echo mysql_error();
  }

  function data_CreateSortOrder($desiredOrder, $fields)
  {
   if (trim($desiredOrder) == "") return '1';
   $bits = explode(',', $desiredOrder);
   $out = array();

   foreach ($bits as $index => $bit) {
      $ascending = true;
      if ($bit != '' && $bit[0] == '-') {
         $ascending = false;
         $bit = substr($bit, 1);
      }

      $field = null;
      $field = @$fields[$bit];

      if (!$field) {

        if (data_string_in_array($bit, $fields)) $field = $bit;
        else {
            echo $bit;

            return Error::notImplemented();
        }
      }

      if ($field === true) {
         $field = $bit;
      }
      if (is_array($field)) {
        if (!$ascending) foreach ($field as $k => $v) $field[$k] = "-" . $v;
         $bits[$index] = implode(',' , $field);
         $newbits = implode(',', $bits);

         return data_CreateSortOrder($newbits, $fields);
      }

      if ($field[0] == '-') {
         $ascending = !$ascending;
      }

      if (strpos($field, "(") !== false) {
        $out[] = $field . ' ' . ($ascending ? '' : ' DESC') ;
      } else {
        $out[] = '`' . mysql_real_escape_string($field) . '`' . ($ascending ? '' : ' DESC') ;
      }

   }

   return implode(', ', $out);

  }

  function CreateFileRecord($filename, $displayname, $type)
  {
    $query = data_query("INSERT INTO :File (Filename, DisplayName, Type) VALUES
                     ('%s', '%s', '%s')",
                     mysql_real_escape_string($filename),
                     mysql_real_escape_string($displayname),
                     mysql_real_escape_string($type)
                    );

    $res = mysql_query($query);
    if (!$res) return Error::Query($query);
    return mysql_insert_id();
  }

  function GetFile($id)
  {
    require_once 'core/files.php';
    $query = data_query("SELECT id, Filename, Type, DisplayName FROM :File WHERE id = %d", $id);

    $result = mysql_query($query);
    if (!$result) return Error::Query($query);
    $row = mysql_fetch_Assoc($result);
    mysql_free_result($result);
    if ($row) {
        return new File($row);
    }

  }

  function GetFilesOfType($type)
  {
    require_once 'core/files.php';
    $query = data_query("SELECT id, Filename, Type, DisplayName FROM :File WHERE Type = '%s' ORDER BY DisplayName", mysql_real_escape_string($type));
    $result = mysql_query($query);
    if (!$result) return Error::Query($query);
    $retValue = array();
    while (($row = mysql_fetch_Assoc($result)) !== false) {
        $retValue[] = new File($row);
    }
    mysql_free_result($result);

    return $retValue;
  }

  function SaveAd($ad)
  {
    $query = data_query("UPDATE :AdBanner SET URL = %s, ImageURL = %s, LongData = %s, ImageReference = %s, Type = %s WHERE id = %d",
                     esc_or_null($ad->url),
                     esc_or_null($ad->imageURL),
                     esc_or_null($ad->longData),
                     esc_or_null($ad->imageReference),
                     esc_or_null($ad->type),
                     $ad->id
                     );
    $res = mysql_query($query);
    if (!$res) return Error::Query($query);
  }

  function AnyGroupsDefined($roundid)
  {
    $query = data_query("SELECT 1
                     FROM :StartingOrder
                     INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                     INNER JOIN `:Round` ON `:Round`.id = :Section.`Round`
                     WHERE `:Round`.id = %d LIMIT 1", $roundid);
    $res = mysql_query($query);

    if (!$res) return Error::Query($query);
    return mysql_num_rows($res) != 0;

  }

  function GetRoundGroups($roundid)
  {
    $query = data_query("SELECT PoolNumber, StartingTime, StartingHole, :Classification.Name ClassificationName,
                        :Player.lastname LastName, :Player.firstname FirstName, :User.id UserId
                     FROM :StartingOrder
                     INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                     INNER JOIN `:Round` ON `:Round`.id = :Section.`Round`
                     INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                     INNER JOIN :User ON :User.Player = :Player.player_id
                     INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                     INNER JOIN :Classification ON :Participation.Classification = :Classification.id

                     WHERE `:Round`.id = %d
                     ORDER BY PoolNumber, :StartingOrder.id

                     ", $roundid);
    $res = mysql_query($query);
    if (!$res) return Error::Query($query);

    $out = array();

    while (($row = mysql_fetch_array($res)) !== false) $out[] =$row;

    mysql_free_result($res);

    return $out;

  }

  function GetSingleGroup($roundid, $playerid)
  {
    $query = data_query("SELECT :StartingOrder.PoolNumber, UNIX_TIMESTAMP(:StartingOrder.StartingTime) StartingTime, :StartingOrder.StartingHole,
                        :Classification.Name ClassificationName,
                        :Player.lastname LastName, :Player.firstname FirstName, :User.id UserId
                     FROM :StartingOrder
                     INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                     INNER JOIN `:Round` ON `:Round`.id = :Section.`Round`
                     INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                     INNER JOIN :User ON :User.Player = :Player.player_id
                     INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                     INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                     INNER JOIN :StartingOrder BaseGroup ON (:StartingOrder.Section = BaseGroup.Section
                                                          AND :StartingOrder.PoolNumber = BaseGroup.PoolNumber)
                     WHERE `:Round`.id = %d AND BaseGroup.Player = %d
                     ORDER BY PoolNumber, :StartingOrder.id

                     ", $roundid, $playerid);
    $res = mysql_query($query);
    echo mysql_error();
    if (!$res) return Error::Query($query);

    $out = array();

    while (($row = mysql_fetch_array($res)) !== false) $out[] =$row;
    mysql_free_result($res);

    return $out;

  }

  function GetSingleGroupByPN($roundid, $poolNumber)
  {
    $query = data_query("SELECT :StartingOrder.PoolNumber, :StartingOrder.StartingTime, :StartingOrder.StartingHole,
                        :Classification.Name ClassificationName,
                        :Player.lastname LastName, :Player.firstname FirstName, :User.id UserId
                     FROM :StartingOrder
                     INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                     INNER JOIN `:Round` ON `:Round`.id = :Section.`Round`
                     INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                     INNER JOIN :User ON :User.Player = :Player.player_id
                     INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                     INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                     WHERE `:Round`.id = %d AND PoolNumber = %d
                     ORDER BY PoolNumber, :StartingOrder.id

                     ", $roundid, $poolNumber);
    $res = mysql_query($query);
    echo mysql_error();
    if (!$res) return Error::Query($query);

    $out = array();

    while (($row = mysql_fetch_array($res)) !== false) $out[] =$row;
    mysql_free_result($res);

    return $out;

  }

  function GetUserGroupSummary($eventid, $playerid)
  {
    $query = data_query("SELECT :StartingOrder.PoolNumber, UNIX_TIMESTAMP(:StartingOrder.StartingTime) StartingTime, :StartingOrder.StartingHole,
                        :Classification.Name ClassificationName, :Round.GroupsFinished,
                        :Player.lastname LastName, :Player.firstname FirstName, :User.id UserId
                     FROM :StartingOrder
                     INNER JOIN :Section ON :Section.id = :StartingOrder.Section
                     INNER JOIN `:Round` ON `:Round`.id = :Section.`Round`
                     INNER JOIN :Player ON :StartingOrder.Player = :Player.player_id
                     INNER JOIN :User ON :User.Player = :Player.player_id
                     INNER JOIN :Participation ON (:Participation.Player = :Player.player_id AND :Participation.Event = :Round.Event)
                     INNER JOIN :Classification ON :Participation.Classification = :Classification.id
                     WHERE `:Round`.Event = %d AND :StartingOrder.Player = %d
                     ORDER BY `:Round`.StartTime

                     ", $eventid, $playerid);
    $res = mysql_query($query);
    echo mysql_error();
    if (!$res) return Error::Query($query);

    $out = array();

    while (($row = mysql_fetch_array($res)) !== false) $out[] =$row;

    mysql_free_result($res);

    if (!count($out)) return null;
    return $out;

  }

  function GetRoundCourse($roundid)
  {
    $query = data_query("SELECT :Course.id, Name, Description, Link, Map
                     FROM :Course
                     INNER JOIN `:Round` ON `:Round`.Course = :Course.id
                     WHERE `:Round`.id = %d", $roundid);
    $result = mysql_query($query);

    if (!$result) return Error::Query($query);
    return mysql_fetch_assoc($result);
  }

  function SetParticipantClass($eventid, $playerid, $newClass)
  {
   $query = data_query("UPDATE :Participation SET Classification = %d WHERE Player = %d AND Event = %d",
                    $newClass, $playerid, $eventid);
   $res = mysql_query($query);
   if (!$res) return Error::Query($query);
   return mysql_affected_rows() == 1;
  }

  function GetCourses()
  {
   $query = data_query("SELECT id, Name, Event FROM :Course ORDER BY Name");
   $res = mysql_query($query);
   if (!$res) return Error::Query($query);

   $out = array();
   while (($row = mysql_fetch_assoc($res)) !== false) {
      $out[] = $row;
   }
   mysql_free_result($res);

   return $out;
  }

  function GetCourseDetails($id)
  {
   $db = InitializeDatabaseConnection();
   if (is_a($db, 'Error')) return $db;

   $query = data_query("SELECT id, Name, Description, Link, Map, Event FROM :Course WHERE id = %d", $id);
   $res = mysql_query($query);
   if (!$res) return Error::Query($query);

   $out = null;
   while (($row = mysql_fetch_assoc($res)) !== false) {
      $out = $row;
   }

   return $out;
  }

  function data_query($query /*, $arg1, ..., $argn */)
  {
   static $prefix = false;
   if ($prefix === false) {
      global $settings;
      $prefix = $settings['DB_PREFIX'];
   }
   $query = str_replace(':', $prefix, $query);
   $args = func_get_args();
   $args[0]=  $query;

   return call_user_func_array('sprintf', $args);
  }

  function data_GetOne($a, $b)
  {
   if ($b) return $b;
   return $a;
  }

  function SaveCourse($course)
  {
   $db = InitializeDatabaseConnection();
   if (is_a($db, 'Error')) return $db;

   if ($course['id']) {

      $query = data_query("UPDATE :Course
                          SET Name = '%s',
                          Description = '%s',
                          Link = '%s',
                          Map = '%s'
                          WHERE id = %d",
                          mysql_real_escape_string($course['Name']),
                          mysql_real_escape_string($course['Description']),
                          mysql_real_escape_string($course['Link']),
                          mysql_real_escape_string($course['Map']),
                          $course['id']

                                                   );
      $res = mysql_query($query);
      if (!$res) return Error::Query($query);
   } else {
      $eventid = @$course['Event'];
      if (!$eventid) $eventid = null;

      $query = data_query("INSERT INTO :Course (Name, Description, Link, Map, Event)
                          VALUES ('%s', '%s', '%s', '%s', %s)",
                          mysql_real_escape_string($course['Name']),
                          mysql_real_escape_string($course['Description']),
                          mysql_real_escape_string($course['Link']),
                          mysql_real_escape_string($course['Map']),
                          esc_or_null($eventid, 'int'));
      $res = mysql_query($query);
      if (!$res) return Error::Query($query);
      return mysql_insert_id();
   }
  }

  function StorePayments($payments)
  {
    foreach ($payments as $userid => $payments) {
        $user = GetUserDetails($userid);
        $playerid = $user->player;

        if (isset($payments['license'])) {
            foreach ($payments['license'] as $year => $paid) {

                $query = data_query("DELETE FROM :LicensePayment WHERE Player = %d AND Year = %d", $playerid, $year);
                mysql_query($query);
                if ($paid) {
                    $query = data_query("INSERT INTO :LicensePayment (Player, Year) VALUES (%d, %d)", $playerid, $year);
                    mysql_query($query);
                }
            }
        }

        if (isset($payments['membership'])) {
            foreach ($payments['membership'] as $year => $paid) {

                $query = data_query("DELETE FROM :MembershipPayment WHERE Player = %d AND Year = %d", $playerid, $year);
                mysql_query($query);
                if ($paid) {
                    $query = data_query("INSERT INTO :MembershipPayment (Player, Year) VALUES (%d, %d)", $playerid, $year);
                    mysql_query($query);
                }
            }
        }
    }
  }

  function Ban($userid, $activate)
  {
    $user = GetUserDetails($userid);
    if (strpos($user->role, 'ban') === false) {
        if ($activate) {
            $newrole = "ban_".$user->role;
            $query = data_query("UPDATE :User SET Role = '%s' WHERE id = %d", mysql_real_escape_string($newrole), $userid);
            mysql_query($query);
        }
    } else {
        if (!$activate) {
            $newrole = substr($user->role, 4);
            $query = data_query("UPDATE :User SET Role = '%s' WHERE id = %d", mysql_real_escape_string($newrole), $userid);
            mysql_query($query);
        }
    }
  }

  function EventRequiresFees($eventid)
  {
    $query = data_query("SELECT FeesRequired FROM :Event WHERE id = %d", $eventid);
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    mysql_free_result($result);
    if ($row === false) return null;
    return $row['FeesRequired'];
  }

  function GetTournamentData($tid)
  {
    $query = data_query("SELECT player_id, :TournamentStanding.OverallScore, :TournamentStanding.Standing,
                            :Participation.TournamentPoints, :Participation.Classification,
                            :TournamentStanding.id TSID, :Player.player_id PID, :Tournament.id TID,
                            :Event.ResultsLocked, TieBreaker, :Participation.Standing EventStanding
                            FROM :Tournament
                            LEFT JOIN :Event ON :Event.Tournament = :Tournament.id
                            LEFT JOIN :Participation ON :Event.id = :Participation.Event
                            LEFT JOIN :Player ON :Participation.Player = :Player.player_id

                            LEFT JOIN :TournamentStanding ON (:TournamentStanding.Tournament = :Tournament.id
                                AND :TournamentStanding.Player = :Player.player_id)
                            WHERE :Tournament.id = %d
                            ORDER BY :Player.player_id

                        ", $tid);
    $results = mysql_query($query);

    if (!$results) return Error::Query($results);

    $lastrow = null;
    $out = array();
    while (($row = mysql_fetch_assoc($results)) !== false) {
        if (!$lastrow || $row['player_id'] != $lastrow['player_id']) {
            if ($lastrow) {
                $out[$lastrow['player_id']] = $lastrow;
            }
            $lastrow = $row;
            $lastrow['Events'] = array();

        }
        $lastrow['Events'][] = $row;
    }

    if ($lastrow) {
        $out[$lastrow['player_id']] = $lastrow;
    }

    mysql_free_result($results);

    return $out;
  }

  function SaveTournamentStanding($item)
  {
    if ((int) $item['PID'] == 0) return;
    if (!$item['TSID']) {
        $query = data_query("INSERT INTO :TournamentStanding (Player, Tournament, OverallScore, Standing)
                            VALUES (%d, %d, 0, NULL)", $item['PID'], $item['TID']);
        mysql_query($query);

        echo mysql_error();
    }

    $query = data_query("UPDATE :TournamentStanding
                        SET OverallScore = %d, Standing = %d
                        WHERE Player = %d AND Tournament = %d",
                        $item['OverallScore'],
                        $item['Standing'],
                        $item['PID'],
                        $item['TID']
                        );

    mysql_query($query);
    echo mysql_error();
  }

  function UserParticipating($eventid, $userid)
  {
    $query = data_query("SELECT :Participation.id FROM :Participation
                        INNER JOIN :Player ON :Participation.Player = :Player.player_id
                        INNER JOIN :User ON :User.Player = :Player.player_id
                        WHERE :User.id = %d AND :Participation.Event = %d",
                        $userid, $eventid);
    $res = mysql_query($query);
    return (mysql_num_rows($res) != 0);
  }

  function UserQueueing($eventid, $userid)
  {
    $query = data_query("SELECT :EventQueue.id FROM :EventQueue
                        INNER JOIN :Player ON :EventQueue.Player = :Player.player_id
                        INNER JOIN :User ON :User.Player = :Player.player_id
                        WHERE :User.id = %d AND :EventQueue.Event = %d",
                        $userid, $eventid);
    $res = mysql_query($query);
    return (mysql_num_rows($res) != 0);
  }

  function GetAllToRemind($eventid)
  {
    $query = data_query(
        "SELECT :User.id FROM :User
        INNER JOIN :Player ON :User.Player = :Player.player_id
        INNER JOIN :Participation ON :Player.player_id = :Participation.Player
        WHERE :Participation.Event = %d AND :Participation.EventFeePaid IS NULL", $eventid);

    $res = mysql_query($query);
    $out = array();
    while (($row = mysql_fetch_assoc($res)) !== false) {
        $out[] = $row['id'];
    }
    mysql_free_result($res);

    return $out;
  }


  function data_FinalizeResultSort($roundid, $data)
  {
    $needMoreInfoOn = array();

    foreach ($data as $results) {
        $lastRes = -1;
        $lastPlayer = -1;
        $added = false;
        foreach ($results as $player) {
            if ($player['CumulativeTotal'] == $lastRes) {
                if (!$added) $needMoreInfoOn[] = $lastPlayer;
                $added = true;
                $needMoreInfoOn[] = $player['PlayerId'];
            } else {
                $lastRes = $player['CumulativeTotal'];
                $lastPlayer = $player['PlayerId'];
                $added = false;
            }
        }
    }

    global $data_extraSortInfo;
    $data_extraSortInfo = data_GetExtraSortInfo($roundid, $needMoreInfoOn);

    $out = array();
    foreach ($data as $cn => $results) {
        usort($results, 'data_Result_Sort');
        $out[$cn] = $results;
    }

    return $out;
  }

  function data_GetExtraSortInfo($roundid, $playerList)
  {
    if (!count($playerList)) return array();
    $ids = array_filter($playerList, 'is_numeric');
    $ids = implode(',', $ids);

    $query = data_query(
        "SELECT `:Round`.id RoundId, :StartingOrder.id StartId, :RoundResult.Result, :StartingOrder.Player
            FROM `:Round` LinkRound INNER JOIN `:Round` ON `:Round`.Event = LinkRound.Event
            INNER JOIN :Section ON :Section.`Round` = `:Round`.id
            INNER JOIN :StartingOrder ON :StartingOrder.Section = :Section.id
            INNER JOIN :RoundResult ON (:RoundResult.`Round` = `:Round`.id AND :RoundResult.Player = :StartingOrder.Player)
            WHERE :StartingOrder.Player IN (%s) AND `:Round`.id <= %d AND LinkRound.id = %d
            ORDER BY :Round.StartTime, :StartingOrder.Player", $ids, $roundid, $roundid

    );

    $res = mysql_query($query);
    echo mysql_error();
    $out = array();
    while (($row = mysql_fetch_assoc($res)) !== false) {
        if (!isset($out[$row['RoundId']])) $out[$row['RoundId']] = array();
        $out[$row['RoundId']]  [$row['Player']] = $row;
    }
    mysql_free_result($res);

    return array_reverse($out);

  }

  function data_Result_Sort($a, $b)
  {
    $dnfa = (bool) $a['DidNotFinish'];
    $dnfb = (bool) $b['DidNotFinish'];
    if ($dnfa != $dnfb) {
        if ($dnfa) return 1;
        return -1;
    }

    $compa = $a['Completed'];
    $compb = $b['Completed'];

    if ($compa != $compb && ($compa == 0 || $compb == 0)) {
        if ($compa == 0) return 1;
        return -1;
    }

    $cpma = $a['CumulativePlusminus'];
    $cpmb = $b['CumulativePlusminus'];

    if ($cpma != $cpmb) {
        if ($cpma > $cpmb) return 1;
        return -1;
    }

    $sda = $a['SuddenDeath'];
    $sdb = $b['SuddenDeath'];

    if ($sda != $sdb) {
        if ($sda < $sdb) return -1;
        return 1;
    }

    global $data_extraSortInfo;

    foreach ($data_extraSortInfo as $round) {
        $ad = null; $db = null;

        $ad = @$round[$a['PlayerId']];
        $bd = @$round[$b['PlayerId']];

        //echo sprintf("%s; %s<br />", $a['PlayerId'], $b['PlayerId']);

        if ($ad == null && $bd == null) continue;
        if ($ad == null || $bd == null) {
            if ($ad == null) return 1;
            return -1;
        }

        if ($ad['Result'] != $bd['Result']) {
            if ($ad['Result'] < $bd['Result']) return -1;
            return 1;
        }
    }

    foreach ($data_extraSortInfo as $round) {
        $ad = null; $db = null;

        $ad = @$round[$a['PlayerId']];
        $bd = @$round[$b['PlayerId']];

        if ($ad == null && $bd == null) continue;

        if ($ad['StartId'] < $bd['StartId']) return -1;
        return 1;

    }

  }

  function SetRoundGroupsDone($roundid, $done)
  {
    $time = null;
    if ($done) $time = time();
    $query = data_query("UPDATE `:Round` SET GroupsFinished = FROM_UNIXTIME(%s) WHERE id = %d", esc_or_null($time, 'int' ), $roundid);
    mysql_query($query);
  }

  function data_string_in_array($string, $array)
  {
    foreach ($array as $value) if ($string === $value) return true;

    return false;
  }

  /**
   *Determines if license and membership fees have been paid for a given year
   * Suggested usage:
   * list($license, $membership) = GetUserFees($playerid, $year);
  */
  function GetUserFees($playerid, $year)
  {
    $lquery = data_query("SELECT 1 FROM :LicensePayment WHERE Player = %d AND Year = %d",
                         $playerid, $year);
    $result1 = mysql_query($lquery);
    $license = mysql_num_rows($result1);
    mysql_free_result($result1);

    $mquery = data_query("SELECT 1 FROM :MembershipPayment WHERE Player = %d AND Year = %d",
                         $playerid, $year);
    $result2 = mysql_query($mquery);
    $membership = mysql_num_rows($result2);
    mysql_free_result($result2);

    return array($license, $membership);
  }

  function GetRegisteringEvents()
  {
    $now = time();

    return data_GetEvents("SignupStart < FROM_UNIXTIME($now) AND SignupEnd > FROM_UNIXTIME($now)", "SignupEnd");
  }

  function GetRegisteringSoonEvents()
  {
    $now = time();
    $twoweeks = time() + 21*24*60*60;

    return data_GetEvents("SignupStart > FROM_UNIXTIME($now) AND SignupStart < FROM_UNIXTIME($twoweeks)", "SignupStart");
  }

  function GetUpcomingEvents($onlySome)
  {
    $data = data_GetEvents("Date > FROM_UNIXTIME(" . time() . ')');
    if ($onlySome) {
      echo mysql_error();
        $data = array_slice($data, 0, 10);
    }

    return $data;
  }

  function GetPastEvents($onlySome, $onlyYear = null)
  {
    $thisYear = "";
    if ($onlyYear != null)
       $thisYear = "AND YEAR(Date) = $onlyYear";

    $data = data_GetEvents("Date < FROM_UNIXTIME(" . time() . ") $thisYear AND ResultsLocked IS NOT NULL");
    $data = array_reverse($data);

    if ($onlySome) {
        $data = array_slice($data, 0, 5);
    }

    return $data;
  }

  function DeleteTextContent($id)
  {
    $query = data_query("DELETE FROM :TextContent WHERE id = %d", $id);
    mysql_query($query);
  }

  function DeleteCourse($id)
  {
    $query = data_query("DELETE FROM :Hole WHERE Course = %d", $id);
    mysql_query($query);

    $query = data_query("DELETE FROM :Course WHERE id = %d", $id);
    mysql_query($query);
  }

  function SetTournamentTieBreaker($tournament, $player, $value)
  {
    $dbError = InitializeDatabaseConnection();
      if ($dbError) {
         return $dbError;
      }

    $query = data_query("UPDATE :TournamentStanding SET TieBreaker = %d WHERE Player = %d AND Tournament = %d",
                        $value, $player, $tournament);
    mysql_query($query);
    echo mysql_error();
  }

  function data_sort_leaderboard($a, $b)
  {
    $ac = $a['Classification'];
    $bc = $b['Classification'];

    if ($ac != $bc) {
        // we don't really need to sort by class, just making sure only items
        // of the same class are compared
        if ($ac < $bc) return -1;
        return 1;
    }

    $astand = $a['Standing'];
    $bstand = $b['Standing'];
    if ($astand != $bstand) {
        if ($astand < $bstand) return -1;
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
      $ae = $ar[$key]['Total'];
      $be = $br[$key]['Total'];
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

function RemovePlayersDefinedforAnySection($a)
{
   list($round, $section) = $GLOBALS['RemovePlayersDefinedforAnySectionRound'];
   static $data;
   if (!is_array($data)) $data = array();
   $key = sprintf("%d_%d", $round, $section);
   if (!isset($data[$key])) {
      $query = data_query("SELECT Player FROM :StartingOrder
                          INNER JOIN :Section ON :StartingOrder.Section = :Section.id
                          WHERE :Section.Round = %d", $round);
      $result = mysql_query($query);

      $mydata = array();
      while (($row = mysql_fetch_assoc($result)) !== false) {
         $mydata[$row['Player']] = true;
      }
      $data[$key] = $mydata;
      mysql_free_result($result);
   }

   return !@$data[$key][$a['PlayerId']];
}

function DeleteEventPermanently($event)
{
   $id = $event->id;

   $queries = array();
   $queries[] = data_query("DELETE FROM :AdBanner WHERE Event = %d", $id);
   $queries[] = data_query("DELETE FROM :EventQueue WHERE Event = %d", $id);
   $queries[] = data_query("DELETE FROM :ClassInEvent WHERE Event = %d", $id);
   $queries[] = data_query("DELETE FROM :EventManagement WHERE Event = %d", $id);

   $rounds = $event->GetRounds();
   foreach ($rounds as $round) {
      $rid = $round->id;
      $sections = GetSections($rid);
      foreach ($sections as $section) {
         $sid = $section->id;

         $queries[] = data_query("DELETE FROM :SectionMembership WHERE Section = %d", $sid);
         $queries[] = data_query("DELETE FROM :StartingOrder WHERE Section = %d", $sid);
      }
      $queries[] = data_query("DELETE FROM :Section WHERE Round = %d", $rid);

      $rrq = data_query("SELECT id FROM :RoundResult WHERE Round = %d", $rid);
      $rrres = mysql_query($rrq);

      while (($row = mysql_fetch_assoc($rrres)) !== false) {
         $queries[] = data_query("DELETE FROM :HoleResult WHERE RoundResult = %d", $row['id']);
      }

      mysql_free_result($rrres);

      $queries[] = data_query("DELETE FROM :RoundResult WHERE Round = %d", $rid);

   }

   $queries[] = data_query("DELETE FROM :Round WHERE Event = %d", $id);
   $queries[] = data_query("DELETE FROM :TextContent WHERE Event = %d", $id);
   $queries[] = data_query("DELETE FROM :Participation WHERE Event = %d", $id);
   $queries[] = data_query("DELETE FROM :Event WHERE id = %d", $id);

   foreach ($queries as $query) {
      mysql_query($query);
      //echo $query, "<br>";
      echo mysql_error();
   }
}

function data_fixNameCase($name)
{
    // from: http://fi.php.net/manual/en/function.ucwords.php
    // by: jmarois at ca dot ibm dot com
    $string =ucwords(strtolower($name));

    foreach (array('-', '\'') as $delimiter) {
      if (strpos($string, $delimiter)!==false) {
        $string =implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
      }
    }

    return $string;
}
