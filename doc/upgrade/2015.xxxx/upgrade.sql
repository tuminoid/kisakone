
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
