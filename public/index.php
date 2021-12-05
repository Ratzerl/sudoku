<?php

use sudoku\Factory;

require_once __DIR__ . '/../vendor/autoload.php';

$factory = new Factory();
$router = $factory->router();
$response = $router->route(
    $_SERVER['REQUEST_URI'],
    file_get_contents('php://input')
);
http_response_code($response->code());
echo $response->body();