
-- SQL migration from version 2015.05.31
-- Use the upgrade script upgrade.php!

ALTER TABLE :Classification ADD COLUMN Short VARCHAR(6) AFTER Name;
ALTER TABLE :Classification ADD COLUMN Status ENUM('P', 'A') NOT NULL AFTER Available;
ALTER TABLE :Classification ADD COLUMN Priority INT DEFAULT 1000 AFTER Status;
ALTER TABLE :Classification ADD COLUMN RatingLimit INT AFTER Priority;

UPDATE :Classification SET Short = SUBSTR(Name, 1, 3) WHERE Name RLIKE '^[A-Z0-9]{3} (.+)$';
UPDATE :Classification SET Name = SUBSTR(REPLACE(Name, ')', ''), 6) WHERE Name RLIKE '^[A-Z0-9]{3} (.+)$';

-- Below is updates to SFL formatted classifications
-- They are as non-invasive as possible, and won't update anything unless lines above
-- have been triggered to insert Short name, which happens only when original classname is XXX (YYY) format

INSERT INTO :Classification (Name, Short, MaximumAge, Available) VALUES('Juniorit-8', 'MJ5', 8, 1);
INSERT INTO :Classification (Name, Short, MaximumAge, Available, GenderRequirement) VALUES('Tytöt-8', 'FJ5', 8, 1, 'F');

UPDATE :Classification SET Status = 'A' WHERE Short IS NOT NULL;
UPDATE :Classification SET Status = 'P' WHERE SUBSTR(Short, 2, 1) = 'P';
UPDATE :Classification SET Priority = 1 WHERE Short = 'MPO';
UPDATE :Classification SET Priority = 2 WHERE Short = 'FPO';
UPDATE :Classification SET Priority = 3 WHERE Short = 'MPM';
UPDATE :Classification SET Priority = 4 WHERE Short = 'MPS';
UPDATE :Classification SET Priority = 5 WHERE Short = 'MPG';
UPDATE :Classification SET Priority = 6 WHERE Short = 'MPL';
UPDATE :Classification SET Priority = 7 WHERE Short = 'MPE';
UPDATE :Classification SET Priority = 8 WHERE Short = 'MPR';
UPDATE :Classification SET Priority = 9 WHERE Short = 'FPM';
UPDATE :Classification SET Priority = 10 WHERE Short = 'FPG';
UPDATE :Classification SET Priority = 11 WHERE Short = 'FPS';
UPDATE :Classification SET Priority = 12 WHERE Short = 'FPL';
UPDATE :Classification SET Priority = 13 WHERE Short = 'MA1';
UPDATE :Classification SET Priority = 14, RatingLimit = 935 WHERE Short = 'MA2';
UPDATE :Classification SET Priority = 15, RatingLimit = 900 WHERE Short = 'MA3';
UPDATE :Classification SET Priority = 16, RatingLimit = 850 WHERE Short = 'MA4';
UPDATE :Classification SET Priority = 17 WHERE Short = 'MM1';
UPDATE :Classification SET Priority = 18 WHERE Short = 'MG1';
UPDATE :Classification SET Priority = 19 WHERE Short = 'MS1';
UPDATE :Classification SET Priority = 20 WHERE Short = 'ML1';
UPDATE :Classification SET Priority = 21 WHERE Short = 'FA1';
UPDATE :Classification SET Priority = 22, RatingLimit = 825 WHERE Short = 'FA2';
UPDATE :Classification SET Priority = 23, RatingLimit = 775 WHERE Short = 'FA3';
UPDATE :Classification SET Priority = 24, RatingLimit = 725 WHERE Short = 'FA4';
UPDATE :Classification SET Priority = 25 WHERE Short = 'FM1';
UPDATE :Classification SET Priority = 26 WHERE Short = 'FG1';
UPDATE :Classification SET Priority = 27 WHERE Short = 'FS1';
UPDATE :Classification SET Priority = 28, MaximumAge = 18, Name = 'Juniorit-18' WHERE Short = 'MJ1';
UPDATE :Classification SET Priority = 29, MaximumAge = 15, Name = 'Juniorit-15' WHERE Short = 'MJ2';
UPDATE :Classification SET Priority = 30, MaximumAge = 12, Name = 'Juniorit-12' WHERE Short = 'MJ3';
UPDATE :Classification SET Priority = 31, MaximumAge = 10, Name = 'Juniorit-10' WHERE Short = 'MJ4';
UPDATE :Classification SET Priority = 32 WHERE Short = 'MJ5';
UPDATE :Classification SET Priority = 33, MaximumAge = 18, Name = 'Tytöt-18' WHERE Short = 'FJ1';
UPDATE :Classification SET Priority = 34, MaximumAge = 15, Name = 'Tytöt-15' WHERE Short = 'FJ2';
UPDATE :Classification SET Priority = 35, MaximumAge = 12, Name = 'Tytöt-12' WHERE Short = 'FJ3';
UPDATE :Classification SET Priority = 36, MaximumAge = 10, Name = 'Tytöt-10' WHERE Short = 'FJ4';
UPDATE :Classification SET Priority = 37 WHERE Short = 'FJ5';
UPDATE :Classification SET Priority = 900, Short = 'SEKA' WHERE Short = 'SEK';
UPDATE :Classification SET Priority = 999 WHERE Priority = 0;
