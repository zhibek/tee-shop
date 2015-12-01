#!/bin/bash

composer install --prefer-dist --ignore-platform-reqs

chmod -R 0777 ./magento/var
chmod -R 0777 ./magento/media

./bin/install.sh install

php magento/app/code/local/TeeShop/Import/shell/ProductsImport.php

rm -r ./magento/var/cache/*
php ./magento/shell/indexer.php --reindexall