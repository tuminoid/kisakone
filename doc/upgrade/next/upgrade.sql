
-- SQL migration from version 2017.01.25
-- Use the upgrade script upgrade.php!

-- AddThisEvent.com have turned into subscription service, need a setting to disable it
ALTER TABLE :PDGAPlayers ADD picture VARCHAR(256) DEFAULT NULL AFTER official_expiration_date;
ALTER TABLE :PDGAEvents ADD latitude VARCHAR(12) AFTER format;
ALTER TABLE :PDGAEvents ADD longitude VARCHAR(12) AFTER latitude;
