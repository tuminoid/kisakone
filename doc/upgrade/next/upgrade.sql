
-- SQL migration from version 2016.05.02
-- Use the upgrade script upgrade.php!

-- Holeresult can be recoded only once per player per hole per round
ALTER TABLE :HoleResult ADD CONSTRAINT UNIQUE KEY (Hole,Roundresult,Player);
ALTER TABLE :Config ADD PdgaProsPlayingAm ENUM('disabled', 'optional', 'enabled') NOT NULL DEFAULT 'disabled' AFTER PdgaPassword;
ALTER TABLE :Event ADD ProsPlayingAm INT NOT NULL DEFAULT 0 AFTER QueueStrategy;
ALTER TABLE :Classification ADD ProsPlayingAmLimit INT DEFAULT NULL AFTER RatingLimit;

UPDATE :Classification SET ProsPlayingAmLimit = 970 WHERE Short = 'MA1';
UPDATE :Classification SET ProsPlayingAmLimit = 935 WHERE Short = 'MA2';
UPDATE :Classification SET ProsPlayingAmLimit = 900 WHERE Short = 'MA3';
UPDATE :Classification SET ProsPlayingAmLimit = 850 WHERE Short = 'MA4';

UPDATE :Classification SET ProsPlayingAmLimit = 935 WHERE Short = 'MM1';
UPDATE :Classification SET ProsPlayingAmLimit = 900 WHERE Short = 'MG1';
UPDATE :Classification SET ProsPlayingAmLimit = 850 WHERE Short = 'MS1';
UPDATE :Classification SET ProsPlayingAmLimit = 800 WHERE Short = 'ML1';

UPDATE :Classification SET ProsPlayingAmLimit = 925 WHERE Short = 'FA1';
UPDATE :Classification SET ProsPlayingAmLimit = 825 WHERE Short = 'FA2';
UPDATE :Classification SET ProsPlayingAmLimit = 775 WHERE Short = 'FA3';
UPDATE :Classification SET ProsPlayingAmLimit = 725 WHERE Short = 'FA4';

UPDATE :Classification SET ProsPlayingAmLimit = 875 WHERE Short = 'FM1';
UPDATE :Classification SET ProsPlayingAmLimit = 825 WHERE Short = 'FG1';
UPDATE :Classification SET ProsPlayingAmLimit = 775 WHERE Short = 'FS1';
UPDATE :Classification SET ProsPlayingAmLimit = 725 WHERE Short = 'FL1';
