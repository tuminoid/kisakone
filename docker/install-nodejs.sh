#!/bin/sh

export DEBIAN_FRONTEND=noninteractive

# install nodejs separately so npm installs are cached by vagrant-cachier
apt-get -y install python-software-properties python g++ make
add-apt-repository -y ppa:chris-lea/node.js
apt-get -y update
apt-get -y install nodejs
