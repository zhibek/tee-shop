#!/bin/bash

composer install --prefer-dist --ignore-platform-reqs

chmod -R 0777 ./magento/var
chmod -R 0777 ./magento/media

./bin/install.sh install
