Upgrading to version xxx
================================

We need to alter one table. 
Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php -f upgrade.php`

It should print no output on success. If you find errors, you likely have some conflicting changes on your system
or have migrated this patch before.
