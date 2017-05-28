#!/bin/sh

export DEBIAN_FRONTEND=noninteractive

# postfix
# do not install postfix by default on a development box to avoid mailing people by mistake
echo "postfix postfix/main_mailer_type select Internet Site" | debconf-set-selections
echo "postfix postfix/mailname string trusty64" | debconf-set-selections
apt-get -y install postfix
