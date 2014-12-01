UPDATE :User SET Role = 'player' WHERE Role NOT IN ('player', 'admin');
ALTER TABLE :User MODIFY COLUMN Role ENUM ('admin', 'player') NOT NULL DEFAULT 'player';
