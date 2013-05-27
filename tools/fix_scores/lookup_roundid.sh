#!/bin/sh

EVENT="$@"

[ $# -eq 0 ] && echo "usage: event" && exit 1

cat <<EOF >/tmp/find_round.sql
SELECT id,name FROM kisakone_Event WHERE name LIKE "%$EVENT%";
SELECT * FROM kisakone_Round WHERE event = (SELECT id FROM kisakone_Event WHERE name LIKE "%$EVENT%") ORDER BY StartTime;
EOF

mysql -v -u root --password=pass fliitto_yleinen </tmp/find_round.sql
rm /tmp/find_round.sql
