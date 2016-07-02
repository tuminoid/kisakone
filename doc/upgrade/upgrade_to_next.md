Upgrading to version next:
================================

`:HoleResult` gained unique key on hole/round/player combo. Only one hole score can be per player per round.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
