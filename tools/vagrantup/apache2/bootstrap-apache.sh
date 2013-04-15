#!/bin/sh

# update repos
apt-get update

# mysql
apt-get -y install debconf-utils
echo 'mysql-server-5.5 mysql-server/root_password_again password pass' | debconf-set-selections
echo 'mysql-server-5.5 mysql-server/root_password password pass' | debconf-set-selections
apt-get -y install mysql-server mysql-client

# apache
apt-get -y install apache2 libapache2-mod-php5 libapache2-mod-auth-mysql php5-mysql git
echo "ServerName localhost" > /etc/apache2/conf.d/fqdn
a2enmod php5
a2enmod rewrite
a2dissite default
cp /vagrant/kisakone /etc/apache2/sites-available/kisakone
a2ensite kisakone
service apache2 restart
