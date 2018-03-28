
-- SQL migration from version 2017.01.25
-- Use the upgrade script upgrade.php!

-- Suomisport related fields
ALTER TABLE :Config ADD SuomisportEnabled BOOL NOT NULL DEFAULT 0 AFTER TaxesEnabled;
ALTER TABLE :Config ADD SuomisportUsername VARCHAR(30) DEFAULT '' AFTER SuomisportEnabled;
ALTER TABLE :Config ADD SuomisportPassword VARCHAR(100) DEFAULT '' AFTER SuomisportUsername;
ALTER TABLE :Config ADD SuomisportAPI VARCHAR(100) DEFAULT '' AFTER SuomisportPassword;
ALTER TABLE :User ADD Sportid INT DEFAULT NULL AFTER Club;

CREATE TABLE :SuomisportLicenses
(
    player_sportid INT(12) NOT NULL,
    player_birthyear INT(4) NOT NULL,
    player_pdga INT NOT NULL,
    player_firstname VARCHAR(255) NOT NULL,
    player_lastname VARCHAR(255) NOT NULL,
    player_fullname VARCHAR(255) NOT NULL,
    player_nationality VARCHAR(2),
    player_gender ENUM('MALE', 'FEMALE') NOT NULL,
    licence_valid BOOL NOT NULL,
    licence_valid_until DATE NOT NULL,
    club_sportid INT(12) NOT NULL,
    club_name VARCHAR(255) NOT NULL,
    club_shortname VARCHAR(20) NOT NULL,
    last_updated DATETIME,
    PRIMARY KEY(player_sportid),
    UNIQUE(player_sportid, player_pdga, player_birthyear),
    INDEX(player_sportid, player_pdga, player_birthyear)
) ENGINE=InnoDB;
SHOW WARNINGS;
