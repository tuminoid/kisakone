
-- SQL migration from versions 2014.10.xx and earlier
-- Use the upgrade script upgrade.php!

-- Make Role a enum instead of varchar
UPDATE :User SET Role = 'player' WHERE Role NOT IN ('player', 'admin');
ALTER TABLE :User MODIFY COLUMN Role ENUM ('admin', 'player') NOT NULL DEFAULT 'player';

-- Make user password more secure
-- FIXME: Null players in db, wth? Cannot be "NOT NULL"
ALTER TABLE :User MODIFY COLUMN Username VARCHAR(40);
ALTER TABLE :User MODIFY COLUMN UserEmail VARCHAR(100);
ALTER TABLE :User MODIFY COLUMN Password VARCHAR(60);
ALTER TABLE :User ADD Salt VARCHAR(40) DEFAULT NULL AFTER Password;
ALTER TABLE :User ADD Hash VARCHAR(40) DEFAULT NULL AFTER Salt;
