#!/bin/bash
composer dumpautoload
vendor/phpunit/phpunit/phpunit --bootstrap tests/bootstrap.php $1 $2 $3 $4
