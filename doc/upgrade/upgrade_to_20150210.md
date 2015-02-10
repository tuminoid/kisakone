Upgrading to version 2015.02.10:
================================

We need to include `Rating` field to `:Participation` table and fix the `:EventQueue` table
to match the `:Participation` table.

We also add missing `FOREIGN KEY` for `:AdBanner`.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
