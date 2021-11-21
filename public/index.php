<?php

require_once __DIR__ . '/../vendor/autoload.php';

$router = new sudoku\Router();
echo $router->route($_GET, $_POST, $_REQUEST);