
-- SQL migration from version 2016.01.01
-- Use the upgrade script upgrade.php!

# Original fields were too short for the intended content
ALTER TABLE :Course MODIFY COLUMN Name VARCHAR(80) NOT NULL;
ALTER TABLE :Course MODIFY COLUMN Link VARCHAR(256) NOT NULL;
ALTER TABLE :Course MODIFY COLUMN Map VARCHAR(256) NOT NULL;

# You may relieve some levels from having license forced for sfl competitions
ALTER TABLE :Level ADD COLUMN LicenseRequired TINYINT NOT NULL DEFAULT 0 AFTER Available;
UPDATE :Level SET LicenseRequired = (SELECT LicenseEnabled+0 > 0 FROM :Config);
