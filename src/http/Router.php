<?php
declare(strict_types=1);


namespace sudoku;


use function json_decode;

class Router
{
    private Solver $solver;
    private BoardBuilder $boardBuilder;

    public function __construct(Solver $solver, BoardBuilder $boardBuilder)
    {
        $this->solver = $solver;
        $this->boardBuilder = $boardBuilder;
    }

    public function route(string $url, string $body) : Response
    {
        if ($url === '/solve') {
            return $this->solveSodoku($body);
        } else if ($url === '/') {
            return $this->showStartPage();
        }
        return new Response(
            404, 'Unknwon'
        );
    }

    private function solveSodoku(string $body) : Response
    {
        $board = $this->boardBuilder->fromJson($body);

        $this->solver->solveBoard($board);

        return new Response(200, $board->asJson());
    }

    private function showStartPage() : Response
    {
        return new Response(200, 'OK');
    }
}