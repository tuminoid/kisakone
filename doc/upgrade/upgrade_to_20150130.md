Upgrading to version 2015.01.30:
================================

For security purposes, we need to change the user database to contain hashtype, salt and
other login related fields. We also change user type to an enum.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
