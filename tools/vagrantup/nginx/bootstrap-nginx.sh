#!/bin/sh

# update repos
sudo apt-get update

# mysql
sudo apt-get -y install debconf-utils
echo 'mysql-server-5.5 mysql-server/root_password_again password pass' | sudo debconf-set-selections
echo 'mysql-server-5.5 mysql-server/root_password password pass' | sudo debconf-set-selections
sudo apt-get -y install mysql-server mysql-client

# nginx
sudo apt-get -y install nginx php5-fpm php5-mysql php5-xcache git
sudo sed -ie 's,listen = 127.0.0.1:9000,listen = /var/run/php5-fpm.sock,' /etc/php5/fpm/pool.d/www.conf
sudo rm -f /etc/php5/fpm/pool.d/www.confe
sudo service php5-fpm restart
sudo cp /vagrant/kisakone /etc/nginx/sites-available/default
sudo service nginx restart
