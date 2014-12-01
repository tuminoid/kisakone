Upgrading to version 201xxxxxxxx
================================

We need to alter two tables. 
Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
