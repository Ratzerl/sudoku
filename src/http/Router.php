<?php
declare(strict_types=1);


namespace sudoku;


use function json_decode;

class Router
{
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function route(string $url, string $body) : Response
    {
        if ($url === '/solve') {
            return $this->factory->solverRoute()->route($body);
        } else if ($url === '/') {
            return $this->showStartPage();
        }
        return new Response(
            404, 'Unknwon'
        );
    }

    private function showStartPage() : Response
    {
        return $this->factory->homePageRoute()->route();

    }
}