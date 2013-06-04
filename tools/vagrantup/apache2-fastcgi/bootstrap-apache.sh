#!/bin/sh

# update repos
apt-get update

# mysql
apt-get -y install debconf-utils
echo 'mysql-server-5.5 mysql-server/root_password_again password pass' | debconf-set-selections
echo 'mysql-server-5.5 mysql-server/root_password password pass' | debconf-set-selections
apt-get -y install mysql-server mysql-client

# apache, php, git
apt-get -y install apache2 apache2-suexec libapache2-mod-fastcgi libapache2-mod-auth-mysql php5-mysql php5-cgi php-cli git

# apache config
echo "ServerName localhost" > /etc/apache2/conf.d/fqdn.conf
a2enmod fastcgi
a2enmod rewrite
a2enmod actions

cp /vagrant/kisakone /etc/apache2/sites-available/kisakone
a2ensite kisakone
a2dissite default

# fastcgi
cat <<EOF >/etc/apache2/conf.d/fcgi.conf
    <IfModule mod_fastcgi>
        FastCgiWrapper /usr/lib/apache2/suexec
        FastCgiConfig -idle-timeout 110 -killInterval 120 -pass-header HTTP_AUTHORIZATION -autoUpdate
     
        ScriptAlias /php-fcgi/ /
    </IfModule>
EOF


cat <<EOF >/kisakone/php5-cgi
#!/bin/bash
exec /usr/bin/php5-cgi
EOF

# done, restart
service apache2 restart
