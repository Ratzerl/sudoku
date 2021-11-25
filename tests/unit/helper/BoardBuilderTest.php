<?php

namespace sudoku;


use PHPUnit\Framework\TestCase;

/**
 * @covers \sudoku\BoardBuilder
 * @uses \sudoku\Board
 */
class BoardBuilderTest extends TestCase
{

    private BoardBuilder $boardBuilder;

    public function setUp() : void
    {
        $this->boardBuilder = new BoardBuilder();
    }

    public function testCreateFromString()
    {
        $board = $this->boardBuilder->fromString('
                123  456 780
                400  000 006
                000  000 005

                000  000 007
                000  000 008
                000  000 004

                000  000 002
                000  000 003
                000  000 001
        ');

        $this->assertInstanceOf(Board::class, $board);
    }

    public function testCanCreateFromJson()
    {
        $board = $this->boardBuilder->fromJson('{"fields":[1,2,3,4,5,6,7,8,null,4,null,null,null,null,null,null,null,6,null,null,null,null,null,null,null,null,5,null,null,null,null,null,null,null,null,7,null,null,null,null,null,null,null,null,8,null,null,null,null,null,null,null,null,4,null,null,null,null,null,null,null,null,2,null,null,null,null,null,null,null,null,3,null,null,null,null,null,null,null,null,1]}');
        $this->assertInstanceOf(Board::class, $board);
    }
}
