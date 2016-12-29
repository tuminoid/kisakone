Upgrading to version 2016.xx.yy:
================================

`:HoleResult` gained unique key on hole/round/player combo. Only one hole score can be per player per round.
`:Event` gained option for `ProsPlayingAm`.
`:Classification` gained `ProsPlayingAmLimit` rating limit.
`:Config` gained `PdgaProsPlayingAm` setting field.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
