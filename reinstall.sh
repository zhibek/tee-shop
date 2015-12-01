#!/bin/bash

rm /vagrant/magento/app/etc/local.xml || true
mysql -uroot -p0000 -e 'DROP DATABASE IF EXISTS `tee-shop`; CREATE DATABASE `tee-shop`;'

#Note: we cleared cache here to make the process faster
rm -rf /vagrant/magento/var/cache/*

/vagrant/bin/install.sh install

#importing products
php magento/app/code/local/TeeShop/Import/shell/ProductsImport.php

#Note: removing cache and reindexing to fix search issue
rm -r /vagrant/magento/var/cache/*
php magento/shell/indexer.php --reindexall
