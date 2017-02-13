Upgrading to version next:
================================

`:PDGAPlayers` gained `picture` field for storing an URL which points to
a profile picture from pdga.com
`:PDGAEvents` gained `latitude` and `longitude`, which reflect event location.

--

Upgrade script will read your database settings from `config.php`, no changes required.

1. Check `upgrade.sql` for intended SQL changes.
2. While in this upgrade directory, run `php upgrade.php`

It should print no output on success.
