
-- SQL migration from versions 2015.02.07 and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :Participation ADD Rating INT AFTER Club;
