
-- SQL migration from versions 2014.02.14 and earlier
-- Use the upgrade script upgrade_20140215.php!

CREATE TABLE IF NOT EXISTS :EventQueue (
  id INT NOT NULL AUTO_INCREMENT,
  Event INT NOT NULL,
  Player SMALLINT NOT NULL,
  Classification INT NOT NULL,
  SignupTimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (Event) REFERENCES :Event(id),
  FOREIGN KEY (Player) REFERENCES :Player(player_id),
  FOREIGN KEY (Classification) REFERENCES :Classification(id),
  INDEX(Event)
) ENGINE=InnoDB;
SHOW WARNINGS;

ALTER TABLE :ClassInEvent ADD MinQuota INT NOT NULL DEFAULT 0 AFTER Event;
ALTER TABLE :ClassInEvent ADD MaxQuota INT NOT NULL DEFAULT 999 AFTER MinQuota;
SHOW WARNINGS;

ALTER TABLE :Event ADD PlayerLimit INT NOT NULL DEFAULT 0 AFTER AdBanner;
SHOW WARNINGS;
