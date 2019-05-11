#!/usr/bin/env bash

# fix home directory permissions.
sudo chown -R devceuma:devceuma /home/devceuma

# copy bash config into place.
cp /home/bashrc /home/devceuma/.bashrc

## Set PHP memory limit value.
#sudo sed -i "/memory_limit = .*/c\memory_limit = $PHP_MEMORY_LIMIT" /etc/php7/php.ini
