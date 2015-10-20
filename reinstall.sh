#!/bin/bash

rm /vagrant/magento/app/etc/local.xml || true
mysql -uroot -p0000 -e 'DROP DATABASE IF EXISTS `tee-shop`; CREATE DATABASE `tee-shop`;'
/vagrant/bin/install.sh install
rm -r /vagrant/magento/var/cache/*
php magento/shell/indexer.php --reindexall
