<?php

namespace sudoku;


use PHPUnit\Framework\TestCase;

/**
 * @covers \sudoku\SolverRoute
 * @uses \sudoku\BoardBuilder
 * @uses \sudoku\Board
 * @uses \sudoku\Solver
 * @uses \sudoku\Response
 */
class SolverRouteTest extends TestCase
{

    public function setUp() : void
    {
        $this->builder = $this->createMock(BoardBuilder::class);
        $this->solver = $this->createMock(Solver::class);

        $this->solverRoute =  new SolverRoute($this->builder, $this->solver);;
    }

    public function testCallsSolverWithBoardFromBuilder()
    {
        $board = $this->createMock(Board::class);
        $this->builder->method('fromJson')->willReturn($board);

        $this->solver->expects($this->once())->method('solveBoard')
            ->with($board)->willReturn($board);

        $response = $this->solverRoute->route(
            ''
        );
        $this->assertInstanceOf(Response::class, $response);
    }
}
