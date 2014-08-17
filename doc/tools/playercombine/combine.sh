#!/bin/bash

#
# Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
#
# This tool allows you to combine many player profiles into one
# Primary purpose is to combine TD-created temporary users into
# later created official users.
#
# Usage: ./combine.sh <player id which stays> <player id which is merged and then deleted>,<second id>,<third id>,...
#
# Please use only if you know what you're doing. Take backups. May cause irreversible mess into your user db if wrong
# id's are used!
#

set -e

[ $# -lt 2 ] && echo "usage: $0 new_id old_id1,[old_id2, ...]" && exit 1
NEW=$1
shift
OLD=$@

DB=$(php -r "require_once '/kisakone/config.php'; global \$settings; print_r( \$settings[\$argv[1]]);" -- DB_DB)
USER=$(php -r "require_once '/kisakone/config.php'; global \$settings; print_r( \$settings[\$argv[1]]);" -- DB_USERNAME)
PASS=$(php -r "require_once '/kisakone/config.php'; global \$settings; print_r( \$settings[\$argv[1]]);" -- DB_PASSWORD)
PREFIX=$(php -r "require_once '/kisakone/config.php'; global \$settings; print_r( \$settings[\$argv[1]]);" -- DB_PREFIX)

MYSQL_CMD="mysql -u$USER -p$PASS $DB"
UPDATE_TABLES="EventQueue TournamentStanding StartingOrder RoundResult Participation"

for TABLE in $UPDATE_TABLES; do
  echo "UPDATE ${PREFIX}$TABLE SET Player = $NEW WHERE Player IN ($OLD);" | $MYSQL_CMD
done

echo "DELETE FROM ${PREFIX}Player WHERE player_id IN ($OLD);" | $MYSQL_CMD
echo "DELETE FROM ${PREFIX}User WHERE Player IN ($OLD);" | $MYSQL_CMD
