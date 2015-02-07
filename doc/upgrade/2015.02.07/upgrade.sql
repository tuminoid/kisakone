
-- SQL migration from versions 2015.01.30 and earlier
-- Use the upgrade script upgrade.php!

ALTER TABLE :Event ADD PdgaEventId INT AFTER AdBanner;

CREATE TABLE :Club
(
  id INT NOT NULL AUTO_INCREMENT,
  Name VARCHAR(255) NOT NULL,
  ShortName VARCHAR(20) NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB;

ALTER TABLE :User ADD SflID INT AFTER PasswordChanged;
ALTER TABLE :User ADD Club INT AFTER SflId;
ALTER TABLE :User ADD CONSTRAINT FOREIGN KEY (Club) REFERENCES :Club(id);
ALTER TABLE :Participation ADD Club INT AFTER TournamentPoints;
ALTER TABLE :Participation ADD CONSTRAINT FOREIGN KEY (Club) REFERENCES :Club(id);
