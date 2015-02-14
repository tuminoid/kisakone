
-- SQL migration from versions 2015.02.10 and earlier
-- Use the upgrade script upgrade.php!

CREATE TABLE :RegistrationRules
(
    id INT NOT NULL AUTO_INCREMENT,
    Event INT NOT NULL,
    Classification INT,
    Type ENUM('rating', 'country', 'player', 'status', 'co'),
    Op ENUM('>', '>=', '<', '<=', '!=', '=='),
    Value VARCHAR(20) NOT NULL,
    Action ENUM('accept', 'queue', 'reject'),
    ValidUntil DATETIME NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Event) REFERENCES :Event(id),
    FOREIGN KEY(Classification) REFERENCES :Classification(id)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :PDGAPlayers
(
  pdga_number INT NOT NULL,
  last_updated DATETIME,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  full_name VARCHAR(255) NOT NULL,
  birth_year INT(4) NOT NULL,
  gender ENUM('M', 'F') NOT NULL,
  membership_status ENUM('expired', 'current') NOT NULL,
  membership_expiration_date DATE,
  classification ENUM('P', 'A') NOT NULL,
  city VARCHAR(255) NOT NULL,
  state VARCHAR(255) NOT NULL,
  country VARCHAR(255) NOT NULL,
  rating INT NOT NULL DEFAULT 0,
  rating_effective_date DATE,
  official_status ENUM('yes', 'no') NOT NULL,
  official_expiration_date DATE,
  PRIMARY KEY(pdga_number)
) ENGINE=InnoDB;
SHOW WARNINGS;


CREATE TABLE :PDGAStats
(
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    pdganum INT NOT NULL,
    rating INT NOT NULL DEFAULT 0,
    year INT NOT NULL,
    class ENUM('P', 'A') NOT NULL,
    gender ENUM('M', 'F') NOT NULL,
    bracket VARCHAR(30) NOT NULL,
    country VARCHAR(2) NOT NULL,
    stateprov VARCHAR(30),
    tourncnt INT NOT NULL DEFAULT 0,
    ratingroundsused INT NOT NULL DEFAULT 0,
    points INT NOT NULL DEFAULT 0,
    prize FLOAT(12,2) DEFAULT 0.00,
    last_updated DATETIME,
    UNIQUE KEY(pdganum, year, class)
) ENGINE=InnoDB;
SHOW WARNINGS;
