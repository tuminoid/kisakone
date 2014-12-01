
-- SQL migration from versions 2014.10.xx and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :Participation ADD Rating INT DEFAULT 0 NOT NULL AFTER TournamentPoints;
ALTER TABLE :Participation ADD Official INT DEFAULT 0 NOT NULL AFTER Rating;
ALTER TABLE :Participation ADD Club VARCHAR(60) DEFAULT "" NOT NULL AFTER Official;

ALTER TABLE :EventQueue ADD Rating INT DEFAULT 0 NOT NULL AFTER SignupTimestamp;
ALTER TABLE :EventQueue ADD Official INT DEFAULT 0 NOT NULL AFTER Rating;
ALTER TABLE :EventQueue ADD Club VARCHAR(60) DEFAULT "" NOT NULL AFTER Official;
