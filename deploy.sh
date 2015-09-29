#!/bin/bash

composer install --prefer-dist --ignore-platform-reqs
./bin/install.sh install
