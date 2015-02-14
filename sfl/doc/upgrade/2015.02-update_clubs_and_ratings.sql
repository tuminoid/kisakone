update kisakone_Participation P
    INNER JOIN (
        SELECT Club,Player FROM kisakone_User
    ) U ON P.Player = U.Player
    INNER JOIN (
        SELECT rating,player_id FROM pdga_players
        INNER JOIN kisakone_Player ON kisakone_Player.pdga = pdga_players.pdga_number
    ) R on R.player_id = P.Player
    SET P.Rating = R.Rating, P.Club = U.Club
    WHERE Event = XXX;
