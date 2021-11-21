#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
apt-get install -yqq git

# Install phpunit, the tool that we will use for testing
#curl --location --output /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar
#chmod +x /usr/local/bin/phpunit

# The PHP image is minimalistic to add more PHP modules you can use the included
# `docker-php-ext-install` command.
# See "How to install more PHP extensions" at:
# https://hub.docker.com/_/php#how-to-install-more-php-extensions
# For example install mysql driver:
#docker-php-ext-install pdo_mysql
