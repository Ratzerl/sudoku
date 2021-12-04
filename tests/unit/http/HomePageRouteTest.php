<?php

namespace sudoku;


use PHPUnit\Framework\TestCase;

/**
 * @covers \sudoku\HomePageRoute
 * @uses \sudoku\Renderer
 * @uses \sudoku\Response
 */
class HomePageRouteTest extends TestCase
{

    private HomePageRoute $route;

    public function setUp() : void
    {
        $this->renderer = $this->createMock(Renderer::class);
        $this->route =  new HomePageRoute($this->renderer);;
    }

    public function testCallsRenderer()
    {
        $this->renderer->expects($this->once())->method('renderHomePage');

        $response = $this->route->route();

        $this->assertInstanceOf(Response::class, $response);
    }
}
