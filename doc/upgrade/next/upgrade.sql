
-- SQL migration from version 2016.05.02
-- Use the upgrade script upgrade.php!

# Holeresult can be recoded only once per player per hole per round
ALTER TABLE :HoleResult ADD CONSTRAINT UNIQUE KEY (Hole,Roundresult,Player);
