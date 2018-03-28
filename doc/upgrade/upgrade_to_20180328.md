Upgrading to version 2017.01.25:
================================

`:Config` gained `AddThisEventEnabled` setting field for enabling/disabling AddThisEvent.com support,
which turned into paid subscription service in 2016.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
