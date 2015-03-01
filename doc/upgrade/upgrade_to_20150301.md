Upgrading to version 2015.03.01:
================================

PDGA Stats API has changed a couple field names, so we alter our column name as well to avoid
translation code.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
