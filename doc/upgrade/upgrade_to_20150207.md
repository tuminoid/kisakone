Upgrading to version xxxxx:
================================

First, check changes in `config_site.php.example`. SFL integration section has changed.

We need to create a new `:Club` table and also add `SflId` and `Club` to `:User` table.
We also add 'PdgaEventId' to Event to store PDGA event number.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
