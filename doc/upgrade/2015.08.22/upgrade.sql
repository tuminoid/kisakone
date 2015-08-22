
-- SQL migration from versions 2014.05.31 and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :TournamentStanding ADD Classification INT AFTER TieBreaker;
SHOW WARNINGS;

