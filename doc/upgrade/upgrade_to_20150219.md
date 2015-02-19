Upgrading to version 2015.02.19:
================================

PDGA API has changed a single field name, so we alter our column name as well to avoid
translation code.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
