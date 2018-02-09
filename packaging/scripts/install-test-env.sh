#!/bin/bash

set -e

export DEBIAN_FRONTEND=noninteractive

SELENIUM="selenium-server-standalone-2.45.0.jar"
SELENIUM_URL="http://selenium-release.storage.googleapis.com/2.45/$SELENIUM"
CHROMEDRIVER="chromedriver_linux64.zip"
CHROMEDRIVER_URL="http://chromedriver.storage.googleapis.com/2.15"
CACHE="/tmp"

# quit down the whine
mkdir -p /kisakone_local

# prime cache
apt-get -y update


# install generic site testing tools
apt-get -y install linkchecker siege apache2-utils rsync unzip


# nightwatch.js
apt-get -y install git
cd $CACHE
if [[ ! -e "nightwatch.git" ]]; then
  git clone --mirror https://github.com/beatfactor/nightwatch.git
else
  (cd nightwatch.git && git fetch --all -p)
fi
cd /tmp
git clone $CACHE/nightwatch.git
cd nightwatch
npm install


# install java
apt-get -y install openjdk-7-jre-headless


# selenium, with little caching
mkdir -p /usr/lib/selenium
(cd $CACHE && wget -q -nc $SELENIUM_URL)
cp $CACHE/$SELENIUM /usr/lib/selenium/
cat <<EOF >/etc/init.d/selenium
#!/bin/bash

### BEGIN INIT INFO
# Provides:          selenium
# Required-Start:    \$syslog
# Required-Stop:     \$syslog
# Default-Start:     2 3 4 5
# Default-Stop:      0 1 6
# Short-Description: Start Selenium at boot time
# Description:       Enable service provided by Selenium.
### END INIT INFO

if [ -z "\$1" ]; then
  echo "\`basename \$0\` {start|stop}"
  exit
fi

case "\$1" in
start)
  export DISPLAY=:10
  # java -jar /usr/lib/selenium/$SELENIUM -forcedBrowserModeRestOfLine "*firefox /usr/bin/firefox" 2>&1 >/var/log/selenium.log &
  java -jar /usr/lib/selenium/$SELENIUM 2>&1 >/var/log/selenium.log &
;;
stop)
  killall java
;;
esac
EOF
chmod 755 /etc/init.d/selenium
update-rc.d selenium defaults


# chrome and chrome chromedriver
wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | sudo apt-key add -
sudo sh -c 'echo "deb http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list'
apt-get -y update
apt-get -y install google-chrome-stable
(cd $CACHE && wget -q -nc $CHROMEDRIVER_URL/$CHROMEDRIVER)
mkdir -p /usr/local/bin
(cd /usr/local/bin && unzip $CACHE/$CHROMEDRIVER)



# headless display
apt-get -y install dbus-x11 xvfb x11-xkb-utils xfonts-100dpi xfonts-75dpi \
  xfonts-scalable xfonts-cyrillic xserver-xorg-core
echo "export DISPLAY=:10" >> ~/.profile
cat <<EOF >/etc/init.d/xvfb
#!/bin/bash

### BEGIN INIT INFO
# Provides:          xvfb
# Required-Start:    \$syslog
# Required-Stop:     \$syslog
# Default-Start:     2 3 4 5
# Default-Stop:      0 1 6
# Short-Description: Start XVFB at boot time
# Description:       Enable service provided by XVFB.
### END INIT INFO

if [ -z "\$1" ]; then
  echo "\`basename \$0\` {start|stop}"
  exit
fi

case "\$1" in
start)
  /usr/bin/Xvfb :10 -ac -screen 0 1024x768x8 2>&1 >/var/log/xvfb.log &
;;
stop)
  killall Xvfb
;;
esac
EOF
chmod 755 /etc/init.d/xvfb
update-rc.d xvfb defaults


# start the services
service xvfb start
service selenium start


if [[ -d /etc/apache2/sites-enabled ]]; then
  # configure xdebug
  apt-get -y install php5-xdebug
  cat <<EOF >>/etc/php5/apache2/php.ini
xdebug.profiler_enable_trigger = 1
EOF

  # php-unit
  apt-get -y install phpunit

  # apache config
  cat <<EOF >/etc/apache2/sites-available/local.conf
<VirtualHost *:8081>
        ServerAdmin webmaster@localhost

        DocumentRoot /kisakone_local

        <Directory /kisakone_local/>
                Options Indexes FollowSymLinks MultiViews ExecCGI
                AllowOverride All
                Require all granted
        </Directory>

        ErrorLog \${APACHE_LOG_DIR}/error_local.log

        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn

        CustomLog \${APACHE_LOG_DIR}/access_local.log combined
</VirtualHost>
EOF

  cat <<EOF >>/etc/apache2/ports.conf
Listen 8081
EOF

  a2ensite local
  service apache2 restart
fi

if [[ -d /etc/nginx/sites-enabled ]]; then
  cat <<EOF >/etc/nginx/sites-available/local
server {
  listen 8081;
  root /kisakone_local;

  # Make site accessible from http://localhost/
  server_name localhost;

  error_log /var/log/nginx/error_local.log;
  access_log /var/log/nginx/access_local.log;

  include hhvm.conf;

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
  (cd /etc/nginx/sites-enabled; ln -s ../sites-available/local)
  nginx -t
  service nginx reload
fi

echo "Test environment setup at 'http://127.0.0.1:8081/!"
echo "  Run Kisakone Unit Test suite with './run_tests.sh unit'!"
echo "  Run Kisakone UI test suite with './run_tests.sh [category]'!"
