
-- SQL migration from versions 2015.02.18 and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :PDGAPlayers CHANGE state state_prov VARCHAR(255) NOT NULL;
