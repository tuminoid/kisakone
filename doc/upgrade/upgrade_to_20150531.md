Upgrading to version 2015.05.31:
================================

Add missing foreign key to `:Event` table.

Drop deprecated `full_name` from `:PDGAPlayers` table.
Add `last_modified` field for all PDGA tables, representing when data has last changed in PDGA database.
(For clarity `last_updated` is datetime when data in our database has been refreshed from PDGA.)

Create new `:PDGAEvents` table for holding event data from PDGA.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
