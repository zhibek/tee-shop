#!/bin/bash

composer install --prefer-dist --ignore-platform-reqs
./vendor/bin/install.sh install
