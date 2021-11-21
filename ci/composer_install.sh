#!/usr/bin/env bash
set -o errexit
set -o nounset
set -o pipefail

php -r "file_put_contents('installer.sig', trim(file_get_contents('https://composer.github.io/installer.sig')));"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === file_get_contents('installer.sig')) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php'); unlink('installer.sig');"
php composer.phar install
