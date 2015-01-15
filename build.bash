#!/bin/bash

rm stamp.phar
composer update --no-dev
box build
mv /tmp/stamp.phar .