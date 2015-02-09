#!/usr/bin/env bash

if [ `facter virtual` != "virtualbox" ] && [ `whoami` != "travis" ];
then
    echo The command should be executed within the guest OS!
    exit 1
fi

sudo su vagrant -c "git config --global user.name vagrant"
sudo su vagrant -c "git config --global user.email vagrant@example.net"

