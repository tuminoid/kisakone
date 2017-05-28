#!/bin/sh

export DEBIAN_FRONTEND=noninteractive
PREFERRED_MIRROR="fi.archive.ubuntu.com"

# use finnish mirrors
sed -i \
    -e "s,us.archive.ubuntu.com,$PREFERRED_MIRROR,g" \
    -e "s,http://archive.ubuntu.com,http://$PREFERRED_MIRROR,g" \
    -e "s,http://mirror.rackspace.com,http://$PREFERRED_MIRROR,g" \
    /etc/apt/sources.list

# update repos
apt-get -y update

# basics
apt-get -y install git nano less curl wget nmap command-not-found man software-properties-common ntp

# make ntp more aggressive
sed -i -e 's,server 0.ubuntu.pool.ntp.org,server 0.ubuntu.pool.ntp.org iburst,' /etc/ntp.conf
service ntp restart

# install memcached
apt-get -y install memcached
