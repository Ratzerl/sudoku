<?php
declare(strict_types=1);


namespace sudoku;


use PHPUnit\Framework\TestCase;

/**
 * @covers \sudoku\Router
 * @uses \sudoku\Factory
 * @uses \sudoku\HomePageRoute
 * @uses \sudoku\SolverRoute
 * @uses \sudoku\Response
 */
class RouterTest extends TestCase
{

    private Router $router;
    /**
     * @var mixed|\PHPUnit\Framework\MockObject\MockObject|Factory
     */
    private mixed $factory;

    public function setUp() : void
    {
        $this->factory = $this->createMock(Factory::class);

        $this->router = new Router(
            $this->factory
        );
    }

    public function testRoutesToHomePageRoute()
    {
        $route = $this->createMock(HomePageRoute::class);
        $route->expects($this->once())->method('route');

        $this->factory->expects($this->once())->method('homePageRoute')->willReturn(
            $route
        );

        $this->router->route('/', '');

    }

    public function testRoutesToSolverRoute()
    {
        $route = $this->createMock(SolverRoute::class);
        $route->expects($this->once())->method('route');

        $this->factory->expects($this->once())->method('solverRoute')->willReturn(
            $route
        );

        $this->router->route('/solve', '');

    }

    public function testReturns404IfUnknownRoute()
    {
        $response = $this->router->route('/some', '');

        $this->assertEquals(404, $response->code());
    }

}