<?php
declare(strict_types=1);


namespace sudoku;


class HomePageRoute
{

    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function route() : Response
    {
        $body = $this->renderer->renderHomePage();
        return new Response(200, $body);
    }
}