
-- SQL migration from versions 2014.03.01 and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :Event ADD CONSTRAINT FOREIGN KEY (Tournament) REFERENCES :Tournament(id);

ALTER TABLE :PDGAPlayers DROP COLUMN full_name;

CREATE TABLE :PDGAEvents
(
    tournament_id INT NOT NULL,
    tournament_name VARCHAR(255) NOT NULL,
    city VARCHAR(255),
    state_prov VARCHAR(30),
    country VARCHAR(2) NOT NULL,
    start_date DATETIME,
    end_date DATETIME,
    class VARCHAR(20),
    tier VARCHAR(20),
    format VARCHAR(20),
    last_updated DATETIME,
    PRIMARY KEY (tournament_id),
    INDEX(country)
) ENGINE=InnoDB;
SHOW WARNINGS;
