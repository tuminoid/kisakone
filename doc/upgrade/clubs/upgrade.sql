
-- SQL migration from versions xxxxx and earlier
-- Use the upgrade script upgrade.php!

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
