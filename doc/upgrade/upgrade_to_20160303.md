Upgrading to version 2016.03.03:
================================

Fix `:Course` Link, Map, Name field lengths that were too short.
Add `LicenseRequired` flag for `:Level`.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
