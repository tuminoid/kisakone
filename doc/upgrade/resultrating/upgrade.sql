
-- SQL migration from versions 2015.02.07 and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :Participation ADD Rating INT AFTER Club;
ALTER TABLE :EventQueue ADD Club INT AFTER Classification;
ALTER TABLE :EventQueue ADD CONSTRAINT FOREIGN KEY (Club) REFERENCES :Club(id);
ALTER TABLE :EventQueue ADD Rating INT AFTER Club;
