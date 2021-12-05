<?php
declare(strict_types=1);


namespace sudoku;

/**
 * @codeCoverageIgnore
 */
class Factory
{
    public function boardBuilder() : BoardBuilder
    {
        return new BoardBuilder();
    }

    public function solver() : Solver
    {
        return new Solver();
    }

    public function renderer() : Renderer
    {
        return new TempanRendererAdapter();
    }

    public function solverRoute() : SolverRoute
    {
        return new SolverRoute($this->boardBuilder(), $this->solver());
    }

    public function homePageRoute() : HomePageRoute
    {
        return new HomePageRoute(
            $this->renderer()
        );
    }

    public function router() : Router
    {
        return new Router($this);
    }
}