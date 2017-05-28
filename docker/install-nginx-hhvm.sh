#!/bin/sh
# expects install-basics.sh to be executed before

export DEBIAN_FRONTEND=noninteractive

# nginx
add-apt-repository -y ppa:nginx/development
apt-get -y update
apt-get -y install nginx

# hhvm
wget -O - http://dl.hhvm.com/conf/hhvm.gpg.key | apt-key add -
echo deb http://dl.hhvm.com/ubuntu trusty main | tee /etc/apt/sources.list.d/hhvm.list
apt-get -y update
apt-get -y install hhvm
update-alternatives --install /usr/bin/php php /usr/bin/hhvm 60
/usr/share/hhvm/install_fastcgi.sh

# setup kisakone
cat <<EOF >/etc/nginx/sites-available/kisakone
server {
  listen 8080 default_server;
  root /kisakone;

  # Make site accessible from http://localhost/
  server_name localhost;

  include hhvm.conf;

  error_log /var/log/nginx/error_kisakone.log;
  access_log /var/log/nginx/access_kisakone.log;

  location = /favicon.ico { log_not_found off; access_log off; }
  location = /robots.txt  { log_not_found off; access_log off; }

  location ~ /\.ht {
    deny all;
  }

  location ~* \.(js|css|svg|png|jpe?g|ico)\$ {
    try_files \$uri =404;
  }

  location / {
    rewrite ^/(.*)\$ /index.php?path=\$1&\$query_string last;
  }
}
EOF
(cd /etc/nginx/sites-enabled; rm -f default; ln -s ../sites-available/kisakone)

# configure and restart stuff
mkdir -p /var/lib/php5 && chown -R www-data:www-data /var/lib/php5
nginx -t
service nginx restart
service hhvm restart

# install apache2-utils for ab
apt-get -y install apache2-utils
