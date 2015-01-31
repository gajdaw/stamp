#!/bin/bash

if [ `whoami` != "vagrant" ] && [ `whoami` != "travis" ];
then
    echo The command should be executed within the guest OS!
    exit 1
fi

if [ -f "stamp.phar" ]; then
    rm stamp.phar
fi

composer update --no-dev
box build
mv /tmp/stamp.phar .
