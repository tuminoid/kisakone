
-- SQL migration from version 2016.03.03
-- Use the upgrade script upgrade.php!

# You may relieve some levels from having license forced for sfl competitions
ALTER TABLE :Event ADD COLUMN QueueStrategy ENUM('signup', 'rating', 'random') NOT NULL DEFAULT 'signup' AFTER PlayerLimit;
