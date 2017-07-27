
-- SQL migration from version 2016.12.29
-- Use the upgrade script upgrade.php!

-- AddThisEvent.com have turned into subscription service, need a setting to disable it
ALTER TABLE :Config ADD LiveScoringEnabled BOOL NOT NULL DEFAULT 0 AFTER PdgaProsPlayingAm;
ALTER TABLE :Event ADD LiveScoring ENUM('all', 'group', 'off') NOT NULL DEFAULT 'off' AFTER ProsPlayingAm;
