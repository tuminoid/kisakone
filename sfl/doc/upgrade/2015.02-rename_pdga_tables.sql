
-- These are created by upgrade script and are empty
DROP TABLE IF EXISTS kisakone_PDGAPlayers;
DROP TABLE IF EXISTS kisakone_PDGAStats;

-- Move our existing tables into kisakone namespace
RENAME TABLE pdga_players TO kisakone_PDGAPlayers, pdga_stats TO kisakone_PDGAStats;
