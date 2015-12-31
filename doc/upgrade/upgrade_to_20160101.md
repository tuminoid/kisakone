Upgrading to version 2016.01.01:
================================

WARNING: This is rather large migration, be absolutely sure you have backed up your database and files!

Introduce new `:Config` table, replacing `config_site.php` configuration file.
`upgrade.php` will migrate your file into DB automatically. At the end of the migration, you need
to delete `config_site.php` as it has been obsoleted. Configuration besides database settings is done
in the admin interface now.

Add many fields to `:Classification` table to allow us automatically tell which divisions player may participate.
Also add new divisions and data into `:Classification` table.

Support for Clubs has been extended, thus `:Event` table gains `Club`, and `:ClubAdmin` table is created (yet not utilized).

Some minor fixes on various data field lengths in `:PDGAEvents` and `:Venue`.

NOTE: Support for internal license and membership handling has ended, thus `:LicensePayment` and `:MembershipPayment` tables will
be dropped.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

NOTE: This upgrade has its very special `upgrade.php` for config file migration!

It should print no output on success.
