#!/bin/sh

export DEBIAN_FRONTEND=noninteractive

# mysql
apt-get -y install debconf-utils
echo 'mysql-server-5.5 mysql-server/root_password_again password pass' | debconf-set-selections
echo 'mysql-server-5.5 mysql-server/root_password password pass' | debconf-set-selections
apt-get -y install mysql-server mysql-client

sed -ri \
    -e 's,key_buffer(\s+)= 16M,key_buffer_size         = 16M,' \
    -e 's,query_cache_size(\s+)= 16M,query_cache_size        = 256M,' \
    -e '/query_cache_size/a query_cache_type        = 1' \
    /etc/mysql/my.cnf
service mysql restart
