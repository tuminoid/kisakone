
-- SQL migration from version 2016.01.01
-- Use the upgrade script upgrade.php!

CREATE TABLE :PayoutTables
(
    id INT NOT NULL AUTO_INCREMENT,
    Curve ENUM('custom', 'pro', 'am') NOT NULL DEFAULT 'pro',
    Percentage INT,
    PRIMARY KEY(id),
    UNIQUE KEY(Curve, Percentage)
) ENGINE=InnoDB;
INSERT INTO :PayoutTables VALUES(NULL, 'custom', NULL);
INSERT INTO :PayoutTables VALUES(NULL, 'pro', 15);
INSERT INTO :PayoutTables VALUES(NULL, 'pro', 20);
INSERT INTO :PayoutTables VALUES(NULL, 'pro', 25);
INSERT INTO :PayoutTables VALUES(NULL, 'pro', 33);
INSERT INTO :PayoutTables VALUES(NULL, 'pro', 40);
INSERT INTO :PayoutTables VALUES(NULL, 'am', 15);
INSERT INTO :PayoutTables VALUES(NULL, 'am', 20);
INSERT INTO :PayoutTables VALUES(NULL, 'am', 25);
INSERT INTO :PayoutTables VALUES(NULL, 'am', 33);
INSERT INTO :PayoutTables VALUES(NULL, 'am', 40);


CREATE TABLE :EventPayout
(
    id INT NOT NULL AUTO_INCREMENT,
    Event INT NOT NULL,
    Classification INT NOT NULL,
    PayoutTable INT NOT NULL,
    CustomPlacesPaid INT,
    PRIMARY KEY(id),
    FOREIGN KEY(Event) REFERENCES :Event(id),
    FOREIGN KEY(Classification) REFERENCES :Classification(id),
    FOREIGN KEY(PayoutTable) REFERENCES :PayoutTables(id),
    UNIQUE KEY(Event, Classification)
) ENGINE=InnoDB;

