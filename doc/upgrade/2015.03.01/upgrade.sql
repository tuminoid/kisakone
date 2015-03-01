
-- SQL migration from versions 2014.02.19 and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :PDGAStats CHANGE firstname first_name VARCHAR(255) NOT NULL;
ALTER TABLE :PDGAStats CHANGE lastname last_name VARCHAR(255) NOT NULL;
ALTER TABLE :PDGAStats CHANGE pdganum pdga_number INT NOT NULL;
ALTER TABLE :PDGAStats CHANGE stateprov state_prov VARCHAR(30);
ALTER TABLE :PDGAStats CHANGE tourncnt tournaments INT NOT NULL DEFAULT 0;
ALTER TABLE :PDGAStats CHANGE ratingroundsused rating_rounds_used INT NOT NULL DEFAULT 0;
