Upgrading to version 2016.01.01:
================================

Introduce new `:Config` table, replacing `config_site.php` configuration file.
`upgrade.php` will migrate your file into DB automatically.

Add many fields to `:Classification` table.


--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
