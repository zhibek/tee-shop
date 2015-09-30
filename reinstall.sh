#!/bin/bash

rm /vagrant/magento/app/etc/local.xml || true
mysql -uroot -p0000 -e 'DROP DATABASE IF EXISTS `tee-shop`; CREATE DATABASE `tee-shop`;'
rm -fr /vagrant/magento/var/cache/*
/vagrant/bin/install.sh install
