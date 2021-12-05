<?php
declare(strict_types=1);


namespace sudoku;


class SolverRoute
{

    private BoardBuilder $boardBuilder;
    private Solver $solver;

    public function __construct(BoardBuilder $builder, Solver $solver)
    {
        $this->boardBuilder = $builder;
        $this->solver = $solver;
    }

    public function route(string $body) : Response
    {
        $board = $this->boardBuilder->fromJson($body);
        $this->solver->solveBoard($board);
        return new Response(200, $board->asJson());
    }


}