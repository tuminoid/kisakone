#!/bin/sh

# update repos
apt-get update

# mysql
apt-get -y install debconf-utils
echo 'mysql-server-5.5 mysql-server/root_password_again password pass' | debconf-set-selections
echo 'mysql-server-5.5 mysql-server/root_password password pass' | debconf-set-selections
apt-get -y install mysql-server mysql-client

# nginx
apt-get -y install nginx php5-fpm php5-mysql php5-xcache git
sed -ie 's,listen = 127.0.0.1:9000,listen = /var/run/php5-fpm.sock,' /etc/php5/fpm/pool.d/www.conf && rm -f /etc/php5/fpm/pool.d/www.confe
service php5-fpm restart
cp /vagrant/kisakone /etc/nginx/sites-available/default
service nginx restart
