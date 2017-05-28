#!/bin/bash
# expects install-basics.sh to be executed before

export DEBIAN_FRONTEND=noninteractive

# apache
apt-get -y install apache2 libapache2-mod-php5 libapache2-mod-auth-mysql php5-mysql php5-curl php5-mcrypt php5-memcached php5-xdebug

# fix php mcrypt
(cd /etc/php5/apache2/conf.d && ln -s ../../mods-available/mcrypt.ini 20-mcrypt.ini)
(cd /etc/php5/cli/conf.d && ln -s ../../mods-available/mcrypt.ini 20-mcrypt.ini)

echo "ServerName localhost" > /etc/apache2/conf-available/fqdn.conf
a2enconf fqdn
a2enmod php5
a2enmod rewrite
a2dismod status
a2dismod ssl
a2dissite 000-default

cat <<EOF >/etc/apache2/sites-available/kisakone.conf
<VirtualHost *:8080>
        ServerAdmin webmaster@localhost

        DocumentRoot /kisakone

        <Directory /kisakone/>
                Options Indexes FollowSymLinks MultiViews ExecCGI
                AllowOverride All
                Require all granted
        </Directory>

        ErrorLog \${APACHE_LOG_DIR}/error.log

        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn

        CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF
a2ensite kisakone

cat <<EOF >/etc/apache2/ports.conf
Listen 8080
EOF
service apache2 restart

# install phpmyadmin
apt-get -y install debconf-utils
echo "phpmyadmin  phpmyadmin/dbconfig-install boolean true" | debconf-set-selections
echo "phpmyadmin  phpmyadmin/reconfigure-webserver multiselect apache2" | debconf-set-selections
echo "phpmyadmin  phpmyadmin/mysql/admin-pass password pass" | debconf-set-selections
echo "phpmyadmin  phpmyadmin/mysql/method select unix socket" | debconf-set-selections
echo "phpmyadmin  phpmyadmin/mysql/admin-user string root" | debconf-set-selections
apt-get -y install phpmyadmin
