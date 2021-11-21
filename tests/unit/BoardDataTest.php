<?php
declare(strict_types=1);


namespace sudoko;


use PHPUnit\Framework\TestCase;
use function array_keys;
use function is_string;

/**
 * @covers \sudoko\BoardData
 */
class BoardDataTest extends TestCase
{

    private $boardData;

    public function setUp() : void
    {
        $this->boardData = BoardData::fromString('
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
    }

    public function testCanCreateFromArray()
    {
        $board = new BoardData(
            [
                1,2,3, 4,5,6, 7,8,null,
                2,null,null, null,null,null, null,null,8,
                null,null,null, null,null,null, null,null,7,

                null,null,null, null,null,null, null,null,6,
                null,null,null, null,null,null, null,null,5,
                null,null,null, null,null,null, null,null,4,

                null,null,null, null,null,null, null,null,3,
                null,null,null, null,null,null, null,null,2,
                null,null,null, null,null,null, null,null,1,
            ]
        );

        $this->assertTrue(is_string($board->asString()));
        $this->assertStringContainsString('1', $board->asString());
        $this->assertStringContainsString('2', $board->asString());

        $this->assertEquals("|123|456|78 
|2  |   |  8
|   |   |  7
|   |   |  6
|   |   |  5
|   |   |  4
|   |   |  3
|   |   |  2
|   |   |  1", $board->asString());

    }

    public function testCanGetRow()
    {
        $this->assertEquals(
            [
                0 => 1,
                1 => 2,
                2 => 3,
                3 => 4,
                4 => 5,
                5 => 6,
                6 => 7,
                7 => 8,
                8 => null
            ],
            $this->boardData->getRowForIndex(0)
        );

    }

    public function testCanGetValue()
    {
        $this->assertEquals(4, $this->boardData->getValue(9));
    }

    public function testCanSetValue()
    {
        $this->boardData->setValues([ 9  => 4]);
        $this->assertEquals(4, $this->boardData->getValue(9));
        $this->boardData->setValues([ 9  => 5]);
        $this->assertEquals(5, $this->boardData->getValue(9));
    }

    public function testCanGetColumn0()
    {
        $this->assertEquals(
            [
                0 => 1,
                9 => 4,
                18  => null,
                27 => null,
                36 => null,
                45 => null,
                54 => null,
                63 => null,
                72 => null
            ],
            $this->boardData->getColumnForIndex(0)
        );

    }

    public function testCanGetField0()
    {
        $field0 = [
            0 => 1, 1 => 2, 2 => 3,
            9 => 4, 10 => null, 11 => null,
            18 => null, 19 => null, 20 => null
        ];
        foreach (array_keys($field0) as $index) {
            $this->assertEquals(
                $field0,
                $this->boardData->getFieldForIndex($index)
            );
        }

        $field8 = [
            60 => null, 61 => null, 62 => 2,
            69 => null, 70 => null, 71 => 3,
            78 => null, 79 => null, 80 => 1
        ];
        foreach (array_keys($field8) as $index) {
            $this->assertEquals(
                $field8,
                $this->boardData->getFieldForIndex($index)
            );
        }

    }

    public function testCanGetFieldForIndex80()
    {
        $this->assertEquals(
            [
                60 => null,61 => null,62 => 2,
                69 => null,70 => null,71 => 3,
                78 => null,79 => null,80 => 1
            ],
            $this->boardData->getFieldForIndex(80)
        );
    }

    public function testCanGetFieldForIndex()
    {
        $board = new BoardData([
            1,2,3, 4,5,6, 7,8,null,
            2,null,null, null,null,null, null,null,8,
            null,null,null, null,null,null, null,null,7,

            null,null,null, null,null,null, null,null,6,
            null,null,null, null,null,null, null,null,5,
            null,null,null, null,null,null, null,null,4,

            NULL,8,NULL,  NULL,2,3,  NULL,NULL,NULL,
            NULL,NULL,NULL,  4,NULL,NULL,  1,7,NULL,
            NULL,5,NULL,  7,NULL,NULL,  3,NULL, NULL,
        ]);
        $this->assertEquals(
            [
                54 => NULL, 55 => 8, 56 => NULL,
                63 => NULL, 64 => NULL, 65 => NULL,
                72 => NULL, 73 => 5, 74 => NULL,
            ],
            $board->getFieldForIndex(72)
        );
    }

}