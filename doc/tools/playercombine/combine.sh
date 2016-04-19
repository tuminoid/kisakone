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
# Please use only if you know what you're doing. Take backups.
# May cause irreversible mess into your user db if wrong id's are used!
#

set -e

if [ $# -lt 2 ]; then
  echo "error: usage: $0 new_id old_id1,[old_id2, ...]"
  exit 1
fi

NEW=$1
shift
OLD=$@

if [ ! -e "config.php" ]; then
  echo "error: execute in a directory where config.php is present"
  exit 1
fi

DB=$(php -r "require_once './config.php'; global \$settings; print_r( \$settings[\$argv[1]]);" -- DB_DB)
USER=$(php -r "require_once './config.php'; global \$settings; print_r( \$settings[\$argv[1]]);" -- DB_USERNAME)
PASS=$(php -r "require_once './config.php'; global \$settings; print_r( \$settings[\$argv[1]]);" -- DB_PASSWORD)
PREFIX=$(php -r "require_once './config.php'; global \$settings; print_r( \$settings[\$argv[1]]);" -- DB_PREFIX)
DBHOST=$(php -r "require_once './config.php'; global \$settings; print_r( \$settings[\$argv[1]]);" -- DB_ADDRESS)

MYSQL_CMD="mysql -u$USER -p$PASS -h$DBHOST $DB"
UPDATE_TABLES="EventQueue TournamentStanding StartingOrder HoleResult RoundResult Participation EventTaxes"

echo "Testing connection ..."
echo "describe ${PREFIX}Player;" | $MYSQL_CMD >/dev/null

for TABLE in $UPDATE_TABLES; do
  echo "Fixing table $TABLE ..."
  echo "UPDATE ${PREFIX}$TABLE SET Player = $NEW WHERE Player IN ($OLD);" | $MYSQL_CMD
done

echo "Fixing user-level connections ..."
echo "UPDATE ${PREFIX}EventManagement SET User = (SELECT id FROM ${PREFIX}User WHERE Player = $NEW) WHERE User IN ((SELECT id FROM ${PREFIX}User WHERE Player IN ($OLD)));" | $MYSQL_CMD

echo "Deleting old entries ..."
echo "DELETE FROM ${PREFIX}User WHERE Player IN ($OLD);" | $MYSQL_CMD
echo "DELETE FROM ${PREFIX}Player WHERE player_id IN ($OLD);" | $MYSQL_CMD

echo "All done!"

