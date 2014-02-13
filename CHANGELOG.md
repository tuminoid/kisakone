Changelog
=========

Kisakone versions are simply release date tags:

next
====
  * Document license values for maintainability.
  * Drop "next year" license info from user profile and explain in licenses that A-license covers also B-license, that "not paid" looks unfriendly.
  * Display available classes in event listings. GH-57.
  * More configuration options.
  * Add favicon.ico.
  * Change default logo to new Frisbeegolfliitto.com logo. New name is `sitelogo.png`.

2013.11.01
==========

  * Write help for the Leaderboard CVS for TDs that have no prior experience where it applies. GH-39.
  * "Järjestä Kilpailu" link was removed (to be replaced later with other function). GH-30.
  * Competitions with registered and paid are now shown with green thumbs up icon to distinguish them from competitions where you have not registered into. GH-24.
  * More obvious config switch for excluding SFL integration (for club use). GH-22.
  * Reordered lastname, firstname in all forms to firstname, lastname as it makes way more sense and people continue to mix them. GH-44.
  * Created this changelog.


2013.09.23
==========

  * Scoring issues fixed by adding LOCK TABLE statements in critical sections and
    in case an invalid score is detected nevertheless, deleting the scores and notifying
    the score keeper that he has to re-enter that players score. GH-1.


2013.09.20
==========

  * In preparation of the scoring fix, all database tables were converted into InnoDB. GH-17.
  * Hole-in-Ones and Eagles and better are now separated in the scores table by Gold and Dark Red. GH-9.


2013.09.17
==========

  * A running counter was added to registered players list. GH-15.
  * All Windows line endings in all files were converted into Unix line endings. GH-14.

  * Payments page was improved
    * Now Registration date is persistent
    * Payment date is separately visible
    * Selecting all players is possible with single click
    * Formatting of page improved to better use screen estate

  * Leaderboard CVS page was recoded. Now the page is
    * Directly compatible with PDGA Tournament Manager upload field, thus making posting scores and getting ratings for players a blitz.
    * CVS is also directly applicable to International TD Report Excel sheet.

