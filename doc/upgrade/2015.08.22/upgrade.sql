
-- SQL migration from versions 2014.05.31 and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :TournamentStanding ADD Classification INT AFTER TieBreaker;
ALTER TABLE :TournamentStanding ADD CONSTRAINT FOREIGN KEY (Classification) REFERENCES :Classification(id);
ALTER TABLE :TournamentStanding ADD CONSTRAINT UNIQUE KEY (Player, Tournament, Classification);
SHOW WARNINGS;

