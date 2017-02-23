Changelog
=========

Kisakone versions are simply release date tags:

next:
=====
  * Apply visual cues about suitable classes to all event views.
  * Hide non-valid classes as ("+X others"), viewable by clicking, to lessen clutter.

2017.01.25:
===========
  * Make AddThisEvent.com calendar integration optional. AddThisEvent is paid service these days. GH #300.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20170125.md)
for additional actions needed.

2016.12.29:
===========
  * In mobile devices, index-partners css shrinks images a little to fit phone screen better.
  * Remove half-baked live/ dir, to be developed independently.
  * Color code events index to show full events, events that suit you etc.
  * Implement Pros-Playing-Am support. GH #299.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20161229.md)
for additional actions needed.

2016.05.31:
===========
  * Removed PDGA API implementation (moved to private repo).
  * Add submenu with events by levels.
  * Remove log spamming notices: GH #293.
  * Fix lowpoint class detection in tour points.
  * Fix global page creation.
  * Display global index page on all event index pages too.
  * Display holetext instead of holenumber in event index, event schedule pages. GH #291.

2016.05.02:
===========
  * Option to lift players from queue in multiple ways: signup time, rating, random: GH #139, GH #265, GH #270.
  * If payments are disabled, ignore payment status for scores. Thanks Mikko Poikolainen.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20160502.md)
for additional actions needed.

2016.04.04:
===========
  * Fix license help text in addcompetitor. GH #264.
  * Fix same-day event sorting. GH #268.
  * In club use, allow player creation for TDs. GH #274.
  * Player creation from "new competitor" TD menu works again, and creates fake user again. GH #221.
  * Restricted race condition when signing up causing one player to be signed up multiple times.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20160404.md)
for additional actions needed.

2016.03.03:
===========
  * Fix Course Map and Link functionality, along with their allowed max sizes.
  * Sanitize user entered urls so they have proper schema.
  * Encode email per email rfc to avoid spam classification.
  * Admin can verify user's email from UI.
  * Support licenseless competitions by adding a LicenseRequired field to Levels. Allows
      FDGA to enter L-tier leagues and WGE special competitions in Kisakone.
  * Fix a huge load of error log spamming minor cases.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20160303.md)
for additional actions needed.

2016.01.01:
===========
  * Use secure, httponly cookies.
  * Get rid of XHTML declaration, HTML5 is the standard. GH #220.
  * Don't allow course removal (or trying it) if it is in use. GH #217.
  * Classes now include sorting priority, rating limits, pro/am statuses etc.
  * New class information is used to limit registration options based on rating, status etc.
  * All other configs except database settings are now in Admin UI. GH #180.
  * SFL: In December, next year's license is already valid.
  * Add global setting for not checking payments (for club use). GH #177.
  * Email verification upon registration and for old users too. GH #206.
  * All database calls are simplified and centralied to db.php.
  * Drop deprecated "mysql" calls, use "mysqli". GH #246.
  * Admin: New find_duplicates script for detecting duplicate users.
  * New (simple) taxes interface for TDs. It will be improved iteratively over the year.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20160101.md)
for additional actions needed.

2015.08.22:
===========
  * DNF does not give tournament points. GH #137.
  * New scorecalculation: ignore2worst (required for SFL MA1-tour 2015 rules).

2015.08.11:
===========
  * Fix handling of all numeric usernames.
  * Fix handling of TD-created userless player's license checks.
  * Introduce Kisakone Live screen, suitable for presentation and mobile (not linked via menus yet).
  * Fix country flags wrapping to another line when screen is scrammed full.
  * Display player's club in the schedule page.

2015.05.31:
===========
  * Serve TinyMCE buttons as static files by adding exceptions to htaccess.
  * Display registration rules all the time in the registration screen.
  * Fix SFL API call in newcompetitor.php. GH #229.
  * Fix license checks for people with space in their name.
  * Fix holeText usage while editing groups.
  * Display number of events next to group title.
  * Fixed section reordering in sequential starts, not ignoring priority.
  * Sort players by overall score for grouping within sections.
  * You can add players by pdga# even if pdga data tells they're finnish.
  * PDGA data now includes `last_modified` field, signalling when data was last modified in PDGA database.

2015.03.11:
===========
  * Fix case where deleting player already assigned to pools fails. GH #218.
  * In case HoleText is missing, just display the group's startinghole. GH #219.
  * Only display licenses that are appropriate per installation (sfl/non-sfl). GH #201.
  * Link player's pdga number into pdga.com profile. GH #216.
  * If you sign-up multiple times from multiple browser windows, place in competition resetted.
  * SFL: use direct database access for data, not API.

2015.03.01:
===========
  * Regression: Fix a typo in EditTournament, causing scorecalculationmethod become invalid.
  * PDGA Stats API changed and `:PDGAStats` table followed suit.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20150301.md)
for additional actions needed.

2015.02.25:
===========
  * Fix `combine.sh` in case where user is in `EventManagement` table.
  * Fix few translations.
  * Display RegistrationRules in the sign up page regardless of signup phase.

2015.02.19:
===========
  * PDGA API has one column name changed, so we'll change our db as well to avoid
      translation logic in code.
  * Give a big red warning in user's profile page if data from registry cannot be fetched
      due invalid information in Kisakone.
  * Fix ads.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20150219.md)
for additional actions needed.

2015.02.18:
===========
  * User password is marked changed upon new user creation, so it isn't prompted again right away.
  * Calender title is now set to event name. GH #199.
  * Club long name displayed as tooltip for all club short names. GH #200.

2015.02.16:
===========
  * Critical: Create only a single memcached connection.

2015.02.15:
===========
  * Registration rules (rules for requiring CO, Rating, Country, ...) for joining up. GH #7.
  * In Leaderboard_CSV, set 999 correctly for DNS/DNF entries. GH #4.
  * Implement initial memcached support. GH #192.
  * All players have country flags next to their names. GH #193.
  * Regression: Players who have space in their name didn't get their license correctly.
  * javascript/base is now served with public cache control for preventing extra load.
  * All kinds of small performance tunings were made to improve performance.
  * Track.js support. GH #195.
  * Delete event works for events that have Course defined. GH #196.
  * Support AddThisEvent Calendar Widget. GH #197.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20150215.md)
for additional actions needed.

2015.02.10:
===========
  * Club didn't save for players when one other user already had that club.
  * Don't link to userinfo page of users that are TD added "virtual" users.
  * Use local jQuery again. Upgrade to jQuery UI 1.11.2.
  * Display SFL license info at the signup page along with the PDGA info.
  * Display Rating in results, competitor lists and queues.
  * Regression: Promotion from queue was broken.
  * License requirement field is now a simple dropdown. GH# 71.
  * Kisakone version (if installed via git) visible in a meta tag. GH #157.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20150210.md)
for additional actions needed.

2015.02.07:
===========
  * PDGA integration during sign up/add competitor.
  * PDGA event id number and auto-generated links to PDGA.com for event info. GH #33.
  * First version of a proper upgrade guide. GH #112.
  * Regression: `:` got translated into db_prefix.
  * Adding players now prefills data from PDGA or SFL databases.
  * Foreign players can now sign-up by themselves if they have valid PDGA license.
  * Clubs are now visible in the results and player's info pages etc. GH #27.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20150207.md)
for additional actions needed.

2015.02.04:
===========
  * Humongous data_access.php is split into 15 data/* files.
  * Various optimizations around database handling.
  * Regression: Entering scores fixed.

2015.01.30:
===========
  * Fix `combine.sh` (reported by Niko Palokangas, thx!). GH #165 and GH #166.
  * Reformat `data_access.php` entirely to make it readable and as a first step,
      introduce `login.php` in `core/data` to handle login related functions.
  * Database security on hashed password was greatly enhanced by switching from unsalted MD5 to salted crypt.
  * Fix missing hole number if custom hole text was empty. GH #178.
  * Use jQuery core/UI from CDN for speed. GH #179.
  * Queue is sortable by the headers. GH #133.
  * Upgrade scripts at 2013.09.20 we're updated to update the foreign keys to level of
      clean install. It also automates conversion to InnoDB based tables.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20150130.md)
for additional actions needed.

2014.10.20:
===========
  * Fix TD report TSV. Version 9 of the report has fixed the issue of requiring two tabs. GH #164.

2014.10.05:
===========
  * Display results for players without payments (workaround for messing players). Players are not
      able to get into results page without paying as group creation is prevented without payment. GH #152.
  * Fix finding players without PDGA numbers in enter results page. GH #146.
  * Exporting to TD report works now directly. GH #156.
  * Trying to view non-existent tournament does not error 500. GH #153.
  * All-numeric user id's info now displayed properly. GH #131.
  * Enable "naming" of holes. Ie, holes can be displayed as "A", "16B", "X". This allows custom competition
      layout holes to be added to a regular course, without need of renaming all the holes. GH #151.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20141005.md)
for additional actions needed.

2014.09.22:
===========
  * Tool which can merge users (from commandline). GH #115.
  * Order of players in a group is now sorted by OverallScore. GH #132.
  * Total score is displayed when creating groups for each player. GH #125.
  * Fix URL of quotas (Kiintiöt) to look like any other URL. GH #147.

2014.08.06:
===========
  * Fix erroneous warnings about players missing a license when they actually haec B-licenses. GH #138.

2014.07.17:
===========
  * Remove all internal caching mechanisms. We can handle that little extra load. Internal
    caching just creates all kinds of little inconsistencies.
  * Add PDGA API. GH #82.
  * Tournament levels, divisions and leagues are available only when enabled in admin side.
    This allows retiring unused levels without breaking history. GH #77.
  * Players without PDGA number are now easy to add. GH #34.
  * Player's license status is shown to TD when adding a competitor, so its much harder to add
    someone without proper licenses. GH #25.
  * Fix tournament point scoring. GH #136.

2014.05.25:
===========
  * Update tournament point distribution per 2014 tour rules. GH #3.
  * Upgrade Smarty to 2.6.28 (last 2.6 series). GH #114.
  * Fix to tournament points and standings table. Unfortunately there is hidden bug about
    player's class being wrong in some dataset causing this to manifest itself still. GH #2.

2014.04.27:
===========
  * Make simultaneous start type default. GH #110.
  * Players with identical signup time are correctly ordered. GH #109.
  * Write lots of help for quotas and queues. GH #104.
  * Show maxquota correctly if all classes have sensible limits.

2014.04.16:
===========
  * Fix a bug in quota checking, allowing players over quota for their class.

2014.04.15:
===========
  * Add some missing URL translations. GH #88.
  * Added option for using custom analytics. Put your analytics.js to js/. GH #90.
  * Password recovery process corner cases fixed. Also redirect is now proper. GH #55.
  * TD overriding player participation could create double entry for competitor. Fixed.
  * Limit width of frontpage classes td to make it look better.
  * Organized files. Javascript to js/, images to images/, css to css/.
  * Upgrade TinyMCE to latest 3.5. GH #101.
  * Drop support for non-JS sortheading, avoiding massive js-disabled bot spam. GH #81.
  * Global flag for enabling or disabling sending email. GH #70.
  * Add apple-touch-icon.png for Apple device bookmarks etc.
  * Fix javascript/base loading error without mod_rewrite.
  * Registration will not fail with E_STRICT. GH #102.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20140415.md)
for additional actions needed.

2014.03.10:
===========
  * Send email to players promoted from queue. GH #85.
  * Playerlimit is now mandatory, 0 is not allowed value. A TD must know how many player's
    his event can take. If unlimited player's is wanted, use 999 or such. GH #86.

Read [Upgrade notes](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20140310.md)
for additional actions needed.

2014.03.07:
===========
  * Add more data to quota page for TD and clarify Finnish terms. Fixes GH #61 plus more.
  * Link pointing to PDGA updated. GH #78.
  * Expose Quotas to the competitors. GH #80.
  * Participant CSV: New view for sending preregistration list to PDGA.com. GH #79.

2014.03.05:
===========
  * Run whole codebase against php-cs-fixer to fix the most obvious coding style issues.
  * Regression: Adding a competition throws foreign key error, due missing parameter. GH #72.
  * Removed too eager foreign key constraints from Event table. GH #75.
  * Regression: TD was unable to modify event as it complained about TD. GH #73.

2014.03.03:
===========
  * Regression: Fix some broken autocomplete fields. GH #65.
  * TD may add competitor via queue as well, subject to queue rules. GH #69.
  * Player's are autopromoted when event's playerlimit is changed. GH #62.
  * Player's are autopromoted when event's quotas are changed. GH #62.
  * If player is set as both TD and Official, interface blew up. GH #68.

2014.02.21
==========
  * Quotas and Limits. GH #6.
  * `tools/development` was removed to be standalone as `kisakone-dev`. It received updates of it's own.
  * Fix install.php to actually create the database if it is missing.
  * Upgrade jQuery to 1.11.0 and jQuery-UI to 1.10.4. GH #38.
  * Use Datetimepicker for setting event start and end dates. GH #35.
  * Preliminary groups are hidden until TD publishes them. GH #11.
  * Registering and Registering Soon events are listed in the front page. GH #31.

[Database migration](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20140221.md)
is required for this upgrade.

2014.02.13
==========
  * Document A/B-license values for maintainability.
  * Drop "next year" license info from user profile and explain in licenses that A-license covers also B-license, that "not paid" looks unfriendly.
  * Display available classes in event listings. GH #57.
  * More configuration options.
  * Added favicon.ico.
  * Change default logo to new Frisbeegolfliitto.com logo. New name is `sitelogo.png`.

[Upgrade docs](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20140213.md)
are available for this upgrade.

2013.11.01
==========

  * Write help for the Leaderboard CVS for TDs that have no prior experience where it applies. GH #39.
  * "Järjestä Kilpailu" link was removed (to be replaced later with other function). GH #30.
  * Competitions with registered and paid are now shown with green thumbs up icon to distinguish them from competitions where you have not registered into. GH #24.
  * More obvious config switch for excluding SFL integration (for club use). GH #22.
  * Reordered lastname, firstname in all forms to firstname, lastname as it makes way more sense and people continue to mix them. GH #44.
  * Created this changelog.


2013.09.23
==========

  * Scoring issues fixed by adding LOCK TABLE statements in critical sections and
    in case an invalid score is detected nevertheless, deleting the scores and notifying
    the score keeper that he has to re-enter that players score. GH #1.


2013.09.20
==========

  * In preparation of the scoring fix, all database tables were converted into InnoDB. GH #17.
  * Hole-in-Ones and Eagles and better are now separated in the scores table by Gold and Dark Red. GH #9.

[Upgrade docs](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/upgrade_to_20130920.md)
are available for this upgrade.

2013.09.17
==========

  * A running counter was added to registered players list. GH #15.
  * All Windows line endings in all files were converted into Unix line endings. GH #14.

  * Payments page was improved
    * Now Registration date is persistent
    * Payment date is separately visible
    * Selecting all players is possible with single click
    * Formatting of page improved to better use screen estate

  * Leaderboard CVS page was recoded. Now the page is
    * Directly compatible with PDGA Tournament Manager upload field, thus making posting scores and getting ratings for players a blitz.
    * CVS is also directly applicable to International TD Report Excel sheet.

