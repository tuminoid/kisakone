Upgrading to version 2015.08.22:
================================

Add a Classification to `:TournamentStanding` table.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
