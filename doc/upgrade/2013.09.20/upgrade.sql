-- SQL migration from versions 2013.09 and earlier
-- Use the upgrade script upgrade.php!

-- Use InnoDB to have transactions and foreign key constraints
ALTER TABLE :Venue ENGINE=InnoDB;
ALTER TABLE :User ENGINE=InnoDB;
ALTER TABLE :TournamentStanding ENGINE=InnoDB;
ALTER TABLE :Tournament ENGINE=InnoDB;
ALTER TABLE :TextContent ENGINE=InnoDB;
ALTER TABLE :StartingOrder ENGINE=InnoDB;
ALTER TABLE :SectionMembership ENGINE=InnoDB;
ALTER TABLE :Section ENGINE=InnoDB;
ALTER TABLE :RoundResult ENGINE=InnoDB;
ALTER TABLE :Round ENGINE=InnoDB;
ALTER TABLE :Player ENGINE=InnoDB;
ALTER TABLE :Participation ENGINE=InnoDB;
ALTER TABLE :MembershipPayment ENGINE=InnoDB;
ALTER TABLE :LicensePayment ENGINE=InnoDB;
ALTER TABLE :Level ENGINE=InnoDB;
ALTER TABLE :HoleResult ENGINE=InnoDB;
ALTER TABLE :Hole ENGINE=InnoDB;
ALTER TABLE :File ENGINE=InnoDB;
ALTER TABLE :EventManagement ENGINE=InnoDB;
ALTER TABLE :Event ENGINE=InnoDB;
ALTER TABLE :Course ENGINE=InnoDB;
ALTER TABLE :ClassInEvent ENGINE=InnoDB;
ALTER TABLE :Classification ENGINE=InnoDB;
ALTER TABLE :AdBanner ENGINE=InnoDB;

-- Delete data that is not in use, ie. inconsistent with foreign key
DELETE FROM :EventManagement WHERE Event NOT IN (SELECT DISTINCT id FROM :Event);
DELETE FROM :Section WHERE round NOT IN (SELECT DISTINCT id FROM :Round);
DELETE FROM :RoundResult WHERE Round NOT IN (SELECT DISTINCT id FROM :Round);
DELETE FROM :HoleResult WHERE RoundResult NOT IN (SELECT DISTINCT id FROM :RoundResult);
DELETE FROM :StartingOrder WHERE Section NOT IN (SELECT DISTINCT id FROM :Section);
DELETE FROM :SectionMembership WHERE Participation NOT IN (SELECT DISTINCT id FROM :Participation);
DELETE FROM :SectionMembership WHERE Section NOT IN (SELECT DISTINCT id FROM :Section);
DELETE FROM :TournamentStanding WHERE Tournament NOT IN (SELECT DISTINCT id FROM :Tournament);
DELETE FROM :ClassInEvent WHERE Event NOT IN (SELECT DISTINCT id FROM :Event);

-- Add foreign key statements
ALTER TABLE :User ADD CONSTRAINT FOREIGN KEY (Player) REFERENCES :Player(player_id);
ALTER TABLE :Tournament ADD CONSTRAINT FOREIGN KEY (Level) REFERENCES :Level(id);
ALTER TABLE :AdBanner ADD CONSTRAINT FOREIGN KEY (ImageReference) REFERENCES :File(id);
ALTER TABLE :Event ADD CONSTRAINT FOREIGN KEY (Venue) REFERENCES :Venue(id);
ALTER TABLE :Event ADD CONSTRAINT FOREIGN KEY (Level) REFERENCES :Level(id);
ALTER TABLE :EventManagement ADD CONSTRAINT FOREIGN KEY (User) REFERENCES :User(id);
ALTER TABLE :EventManagement ADD CONSTRAINT FOREIGN KEY (Event) REFERENCES :Event(id);
ALTER TABLE :TextContent ADD CONSTRAINT FOREIGN KEY (Event) REFERENCES :Event(id);
ALTER TABLE :Course ADD CONSTRAINT FOREIGN KEY (Venue) REFERENCES :Venue(id);
ALTER TABLE :Course ADD CONSTRAINT FOREIGN KEY (Event) REFERENCES :Event(id);
ALTER TABLE :Round ADD CONSTRAINT FOREIGN KEY (Course) REFERENCES :Course(id);
ALTER TABLE :Round ADD CONSTRAINT FOREIGN KEY (Event) REFERENCES :Event(id);
ALTER TABLE :Section ADD CONSTRAINT FOREIGN KEY (Classification) REFERENCES :Classification(id);
ALTER TABLE :Section ADD CONSTRAINT FOREIGN KEY (Round) REFERENCES :Round(id);
ALTER TABLE :Hole ADD CONSTRAINT FOREIGN KEY (Course) REFERENCES :Course(id);
ALTER TABLE :Participation ADD CONSTRAINT FOREIGN KEY (Player) REFERENCES :Player(player_id);
ALTER TABLE :Participation ADD CONSTRAINT FOREIGN KEY (Event) REFERENCES :Event(id);
ALTER TABLE :Participation ADD CONSTRAINT FOREIGN KEY (Classification) REFERENCES :Classification(id);
ALTER TABLE :RoundResult ADD CONSTRAINT FOREIGN KEY (Player) REFERENCES :Player(player_id);
ALTER TABLE :RoundResult ADD CONSTRAINT FOREIGN KEY (Round) REFERENCES :Round(id);
ALTER TABLE :HoleResult ADD CONSTRAINT FOREIGN KEY (Hole) REFERENCES :Hole(id);
ALTER TABLE :HoleResult ADD CONSTRAINT FOREIGN KEY (RoundResult) REFERENCES :RoundResult(id);
ALTER TABLE :HoleResult ADD CONSTRAINT FOREIGN KEY (Player) REFERENCES :Player(player_id);
ALTER TABLE :StartingOrder ADD CONSTRAINT FOREIGN KEY (Player) REFERENCES :Player(player_id);
ALTER TABLE :StartingOrder ADD CONSTRAINT FOREIGN KEY (Section) REFERENCES :Section(id);
ALTER TABLE :SectionMembership ADD CONSTRAINT FOREIGN KEY (Participation) REFERENCES :Participation(id);
ALTER TABLE :SectionMembership ADD CONSTRAINT FOREIGN KEY (Section) REFERENCES :Section(id);
ALTER TABLE :TournamentStanding ADD CONSTRAINT FOREIGN KEY (Player) REFERENCES :Player(player_id);
ALTER TABLE :TournamentStanding ADD CONSTRAINT FOREIGN KEY (Tournament) REFERENCES :Tournament(id);
ALTER TABLE :ClassInEvent ADD CONSTRAINT FOREIGN KEY (Classification) REFERENCES :Classification(id);
ALTER TABLE :ClassInEvent ADD CONSTRAINT FOREIGN KEY (Event) REFERENCES :Event(id);
ALTER TABLE :LicensePayment ADD CONSTRAINT FOREIGN KEY (Player) REFERENCES :Player(player_id);
ALTER TABLE :MembershipPayment ADD CONSTRAINT FOREIGN KEY (Player) REFERENCES :Player(player_id);
