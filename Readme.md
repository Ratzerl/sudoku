# Soduku Php Solver
## Scope
Write test driven sudoku 9x9 solving algorithm. Wrote backtracking solving algorithms
already in JAVA and PROLOG and I wanted to get a feeling in developing an algorithm test driven.

## Requirements
### All
* php 8 (see composer.json)
### Additional on none Linux machines
* composer

### Dev dependencies
#### All
* xdebug for coverage

## Install

### Install on linux
Downloads and installs via composer
```scripts/composer_install.sh```
#### Run tests optional
```scripts/test.sh```

### Install on none linux with composer
Gets dependencies
```composer intall```
#### Run tests optional
```phpunit```

## Run
### Start php webserver locally
``php -S localhost:9001 -t public``

