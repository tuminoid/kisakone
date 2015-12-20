
-- SQL migration from version 2015.05.31
-- Use the upgrade script upgrade.php!

ALTER TABLE :PDGAEvents MODIFY COLUMN country VARCHAR(100) NOT NULL;
ALTER TABLE :Venue MODIFY COLUMN Name VARCHAR(100) NOT NULL;

ALTER TABLE :User ADD COLUMN EmailVerified DATETIME AFTER PasswordChanged;
INSERT INTO :TextContent (Event, Title, Content, `Date`, Type, `Order`) VALUES(NULL, "Kisakone: Sähköpostiosoitteen vahvistus", "
Moi,

Vahvista sähköpostiosoitteesi Kisakoneessa syöttämällä koodi

{token}

vahvistuskoodisivulle, tai vaihtoehtoisesti klikkaa

{link}

Terveisin,
  Kisakone
",
NOW(), "email_verify", 0);


ALTER TABLE :Classification ADD COLUMN Short VARCHAR(6) AFTER Name;
ALTER TABLE :Classification ADD COLUMN Status ENUM('P', 'A') NOT NULL AFTER Available;
ALTER TABLE :Classification ADD COLUMN Priority INT DEFAULT 1000 AFTER Status;
ALTER TABLE :Classification ADD COLUMN RatingLimit INT AFTER Priority;

ALTER TABLE :Event CHANGE COLUMN FeesRequired LicensesRequired TINYINT NOT NULL;
ALTER TABLE :Event ADD COLUMN Club INT AFTER id;
ALTER TABLE :Event ADD CONSTRAINT FOREIGN KEY (Club) REFERENCES :Club(id);

UPDATE :Classification SET Short = SUBSTR(Name, 1, 3) WHERE Name RLIKE '^[A-Z0-9]{3} (.+)$';
UPDATE :Classification SET Name = SUBSTR(REPLACE(Name, ')', ''), 6) WHERE Name RLIKE '^[A-Z0-9]{3} (.+)$';

-- Below is updates to SFL formatted classifications
-- They are as non-invasive as possible, and won't update anything unless lines above
-- have been triggered to insert Short name, which happens only when original classname is in XXX (YYY) format

INSERT INTO :Classification (Name, Short, MaximumAge, Available) VALUES('Juniorit-8', 'MJ5', 8, 1);
INSERT INTO :Classification (Name, Short, MaximumAge, Available) VALUES('Juniorit-6', 'MJ6', 6, 1);
INSERT INTO :Classification (Name, Short, MaximumAge, Available, GenderRequirement) VALUES('Tytöt-8', 'FJ5', 8, 1, 'F');
INSERT INTO :Classification (Name, Short, MaximumAge, Available, GenderRequirement) VALUES('Tytöt-6', 'FJ6', 6, 1, 'F');

UPDATE :Classification SET Status = 'A' WHERE Short IS NOT NULL;
UPDATE :Classification SET Status = 'P' WHERE SUBSTR(Short, 2, 1) = 'P';
UPDATE :Classification SET Priority = 1 WHERE Short = 'MPO';
UPDATE :Classification SET Priority = 2 WHERE Short = 'FPO';
UPDATE :Classification SET Priority = 10 WHERE Short = 'MPM';
UPDATE :Classification SET Priority = 11 WHERE Short = 'MPS';
UPDATE :Classification SET Priority = 12 WHERE Short = 'MPG';
UPDATE :Classification SET Priority = 13 WHERE Short = 'MPL';
UPDATE :Classification SET Priority = 14 WHERE Short = 'MPE';
UPDATE :Classification SET Priority = 15 WHERE Short = 'MPR';
UPDATE :Classification SET Priority = 20 WHERE Short = 'FPM';
UPDATE :Classification SET Priority = 21 WHERE Short = 'FPG';
UPDATE :Classification SET Priority = 22 WHERE Short = 'FPS';
UPDATE :Classification SET Priority = 23 WHERE Short = 'FPL';
UPDATE :Classification SET Priority = 30 WHERE Short = 'MA1';
UPDATE :Classification SET Priority = 31, RatingLimit = 935 WHERE Short = 'MA2';
UPDATE :Classification SET Priority = 32, RatingLimit = 900 WHERE Short = 'MA3';
UPDATE :Classification SET Priority = 33, RatingLimit = 850 WHERE Short = 'MA4';
UPDATE :Classification SET Priority = 40 WHERE Short = 'MM1';
UPDATE :Classification SET Priority = 41 WHERE Short = 'MG1';
UPDATE :Classification SET Priority = 42 WHERE Short = 'MS1';
UPDATE :Classification SET Priority = 43 WHERE Short = 'ML1';
UPDATE :Classification SET Priority = 50 WHERE Short = 'FA1';
UPDATE :Classification SET Priority = 51, RatingLimit = 825 WHERE Short = 'FA2';
UPDATE :Classification SET Priority = 52, RatingLimit = 775 WHERE Short = 'FA3';
UPDATE :Classification SET Priority = 53, RatingLimit = 725 WHERE Short = 'FA4';
UPDATE :Classification SET Priority = 60 WHERE Short = 'FM1';
UPDATE :Classification SET Priority = 61 WHERE Short = 'FG1';
UPDATE :Classification SET Priority = 62 WHERE Short = 'FS1';
UPDATE :Classification SET Priority = 70, MaximumAge = 18, Name = 'Juniorit-18' WHERE Short = 'MJ1';
UPDATE :Classification SET Priority = 71, MaximumAge = 15, Name = 'Juniorit-15' WHERE Short = 'MJ2';
UPDATE :Classification SET Priority = 72, MaximumAge = 12, Name = 'Juniorit-12' WHERE Short = 'MJ3';
UPDATE :Classification SET Priority = 73, MaximumAge = 10, Name = 'Juniorit-10' WHERE Short = 'MJ4';
UPDATE :Classification SET Priority = 74 WHERE Short = 'MJ5';
UPDATE :Classification SET Priority = 75 WHERE Short = 'MJ6';
UPDATE :Classification SET Priority = 80, MaximumAge = 18, Name = 'Tytöt-18' WHERE Short = 'FJ1';
UPDATE :Classification SET Priority = 81, MaximumAge = 15, Name = 'Tytöt-15' WHERE Short = 'FJ2';
UPDATE :Classification SET Priority = 82, MaximumAge = 12, Name = 'Tytöt-12' WHERE Short = 'FJ3';
UPDATE :Classification SET Priority = 83, MaximumAge = 10, Name = 'Tytöt-10' WHERE Short = 'FJ4';
UPDATE :Classification SET Priority = 84 WHERE Short = 'FJ5';
UPDATE :Classification SET Priority = 85 WHERE Short = 'FJ6';
UPDATE :Classification SET Priority = 900, Short = 'SEKA' WHERE Short = 'SEK';
UPDATE :Classification SET Priority = 999 WHERE Priority = 0;


-- All settings are moved to database from config_site.php
CREATE TABLE :Config
(
    AdminEmail VARCHAR(200) DEFAULT '',

    EmailEnabled BOOL NOT NULL DEFAULT 0,
    EmailAddress VARCHAR(200) DEFAULT '',
    EmailSender VARCHAR(200) DEFAULT 'Kisakone',
    EmailVerification BOOL NOT NULL DEFAULT 0,

    LicenseEnabled ENUM('no', 'sfl') NOT NULL DEFAULT 'no',
    PaymentEnabled BOOL NOT NULL DEFAULT 1,

    PdgaEnabled BOOL NOT NULL DEFAULT 0,
    PdgaUsername VARCHAR(30) DEFAULT '',
    PdgaPassword VARCHAR(100) DEFAULT '',

    CacheEnabled BOOL NOT NULL DEFAULT 0,
    CacheType VARCHAR(100) DEFAULT 'memcached',
    CacheName VARCHAR(100) DEFAULT 'kisakone',
    CacheHost VARCHAR(100) DEFAULT '127.0.0.1',
    CachePort INT(10) DEFAULT '11211',

    TrackjsEnabled BOOL NOT NULL DEFAULT 0,
    TrackjsToken VARCHAR(100) DEFAULT ''
) ENGINE=InnoDB;

-- Insert defaults into db, they'll be updated during upgrade.php run
INSERT INTO :Config VALUES();

-- We have removed support for internal license payment tables
DROP TABLE :LicensePayment;
DROP TABLE :MembershipPayment;


CREATE TABLE :PayoutTables
(
    id INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(256) NOT NULL,
    Curve ENUM('custom', 'pro', 'am') NOT NULL DEFAULT 'pro',
    Percentage ENUM('custom', 'p25', 'p33', 'p40', 'p50'),
    PlacesPaid INT,
    PRIMARY KEY(id)
) ENGINE=InnoDB;


CREATE TABLE :PayoutPlaces
(
    id INT NOT NULL AUTO_INCREMENT,
    PayoutTable INT NOT NULL,
    Place INT NOT NULL,
    Payout FLOAT(12,9) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(PayoutTable) REFERENCES :PayoutTables(id)
) ENGINE=InnoDB;


CREATE TABLE :EventPayout
(
    id INT NOT NULL AUTO_INCREMENT,
    Event INT NOT NULL,
    Classification INT NOT NULL,
    PayoutTable INT NOT NULL,
    Paid INT,
    PRIMARY KEY(id),
    FOREIGN KEY(Event) REFERENCES :Event(id),
    FOREIGN KEY(Classification) REFERENCES :Classification(id),
    FOREIGN KEY(PayoutTable) REFERENCES :PayoutTables(id),
    UNIQUE KEY(Event, Classification)
) ENGINE=InnoDB;


CREATE TABLE :EventPrizes
(
    id INT NOT NULL AUTO_INCREMENT,
    Event INT NOT NULL,
    Player SMALLINT DEFAULT NULL,
    Classification INT NOT NULL,
    Standing INT NOT NULL,
    CashPrize INT NOT NULL DEFAULT '0',
    OtherPrize INT NOT NULL DEFAULT '0',
    DeclineCash BOOL DEFAULT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(Player) REFERENCES :Player(player_id),
    FOREIGN KEY(Event) REFERENCES :Event(id),
    FOREIGN KEY(Classification) REFERENCES :Classification(id),
    UNIQUE KEY(Event, Player)
) ENGINE=InnoDB;
