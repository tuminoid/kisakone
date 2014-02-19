Upgrade to Kisakone 2013.09.20:
===============================

Database is required to be InnoDB after this release.

1. Fix the database name in `convert_to_innodb.sql`
2. Run it with `mysql -u [user] -p [database] < convert_to_innodb.sql > convert.sql`
3. Check the output `convert.sql` if it is OK
4. Run it with `mysql -u [user] -p [database] < convert.sql`

If you use default table prefix `kisakone_`, you can do only
1. Run it with `mysql -u [user] -p [database] < convert_to_innodb_kisakone.sql`
