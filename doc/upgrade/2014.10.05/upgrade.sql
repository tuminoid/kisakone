
-- Use the upgrade script upgrade.php

ALTER TABLE :Hole ADD HoleText VARCHAR(4) AFTER HoleNumber;
UPDATE :Hole SET HoleText = HoleNumber;
SHOW WARNINGS;

ALTER TABLE :StartingOrder CHANGE PoolNumber GroupNumber SMALLINT NOT NULL;
SHOW WARNINGS;
