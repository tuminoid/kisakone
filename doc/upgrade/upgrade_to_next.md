Upgrading to version 2017.xx.xx:
================================

`:Config` gained `LiveScoringEnabled` setting field for enabling/disabling live scoring for event.
Live scoring allows players themselves enter scores during the round.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
