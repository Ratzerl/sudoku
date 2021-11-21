<?php
declare(strict_types=1);


namespace sudoku;


class Router
{

    public function __construct()
    {
    }

    public function route(array $get, array $post, array $request) : string
    {
        return 'running';
    }
}