#!/bin/sh

# update repos
sudo apt-get update

# mysql
sudo apt-get -y install debconf-utils
echo 'mysql-server-5.5 mysql-server/root_password_again password pass' | sudo debconf-set-selections
echo 'mysql-server-5.5 mysql-server/root_password password pass' | sudo debconf-set-selections
sudo apt-get -y install mysql-server mysql-client

# apache
sudo apt-get -y install apache2 libapache2-mod-php5 libapache2-mod-auth-mysql php5-mysql git
echo "ServerName localhost" | sudo tee /etc/apache2/conf.d/fqdn
sudo a2enmod php5
sudo a2enmod rewrite
sudo a2dissite default
sudo cp /vagrant/kisakone /etc/apache2/sites-available/kisakone
sudo a2ensite kisakone
sudo service apache2 restart
