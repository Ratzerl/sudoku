<?php
declare(strict_types=1);


namespace sudoku;


use PHPUnit\Framework\TestCase;

/**
 * @covers \sudoku\Router
 * @uses \sudoku\Solver
 * @uses \sudoku\Board
 * @uses \sudoku\FieldAnalyser
 * @uses \sudoku\Response
 */
class RouterTest extends TestCase
{

    private Router $router;
    /**
     * @var mixed|\PHPUnit\Framework\MockObject\MockObject|Solver
     */
    private mixed $solver;
    /**
     * @var mixed|\PHPUnit\Framework\MockObject\MockObject|BoardBuilder
     */
    private mixed $builder;

    public function setUp() : void
    {
        $this->solver = $this->createMock(Solver::class);
        $this->builder = $this->createMock(BoardBuilder::class);

        $this->router = new Router(
            $this->solver,
            $this->builder
        );
    }

    public function testCanRouteOverview()
    {
        $response = $this->router->route('/', '');

        $this->assertEquals(200, $response->code());
    }

    public function testReturns404IfUnknownRoute()
    {
        $response = $this->router->route('/some', '');

        $this->assertEquals(404, $response->code());
    }

    public function testCallsSolverWithBoardFromBuilder()
    {
        $board = $this->createMock(Board::class);
        $this->builder->method('fromJson')->willReturn($board);

        $this->solver->expects($this->once())->method('solveBoard')
            ->with($board)->willReturn($board);

        $response = $this->router->route(
            '/solve',
            'body'
        );

        $this->assertEquals(200, $response->code());
        $this->assertEquals(
            $board->asJson(),
            $response->body()
        );
    }
}