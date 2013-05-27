#!/bin/sh

NAME="$1"

[ $# -eq 0 ] && echo "usage: name" && exit 1

cat <<EOF >/tmp/find_player.sql
SELECT player_id,firstname,lastname FROM kisakone_Player WHERE lastname LIKE '%$NAME%' OR firstname LIKE '%$NAME%';
EOF

mysql -u root --password=pass fliitto_yleinen </tmp/find_player.sql
rm /tmp/find_player.sql
