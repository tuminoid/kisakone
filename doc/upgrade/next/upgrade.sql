
-- SQL migration from versions 2014.03.01 and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :Event ADD CONSTRAINT FOREIGN KEY (Tournament) REFERENCES :Tournament(id);
