
-- SQL migration from version 2016.03.03
-- Use the upgrade script upgrade.php!

# There may be some double entries in the Participation table, clean them up before
# limiting them with unique keys
DELETE FROM :Participation WHERE id IN (SELECT * FROM (SELECT id FROM :Participation GROUP BY Event,Player HAVING COUNT(*) > 1) AS d);
DELETE FROM :EventQueue WHERE id IN (SELECT * FROM (SELECT id FROM :EventQueue GROUP BY Event,Player HAVING COUNT(*) > 1) AS d);

ALTER TABLE :Participation ADD UNIQUE KEY(Player, Event);
ALTER TABLE :EventQueue ADD UNIQUE KEY(Player, Event);
