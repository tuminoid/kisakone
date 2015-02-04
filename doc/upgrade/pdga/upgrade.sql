
-- SQL migration from versions 2014.10.xx and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :Event ADD PdgaEventId INT AFTER AdBanner;
