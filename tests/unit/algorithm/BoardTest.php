<?php
declare(strict_types=1);


namespace sudoku;


use PHPUnit\Framework\TestCase;
use function array_keys;

/**
 * @covers \sudoku\Board
 */
class BoardTest extends TestCase
{

    private $boardData;

    public function setUp() : void
    {
        $this->boardData = new Board(
            array (
                0 => 1,
                1 => 2,
                2 => 3,
                3 => 4,
                4 => 5,
                5 => 6,
                6 => 7,
                7 => 8,

                8 => NULL,
                9 => 4,
                10 => NULL,
                11 => NULL,
                12 => NULL,
                13 => NULL,
                14 => NULL,
                15 => NULL,
                16 => NULL,
                17 => 6,

                18 => NULL,
                19 => NULL,
                20 => NULL,
                21 => NULL,
                22 => NULL,
                23 => NULL,
                24 => NULL,
                25 => NULL,
                26 => 5,

                27 => NULL,
                28 => NULL,
                29 => NULL,
                30 => NULL,
                31 => NULL,
                32 => NULL,
                33 => NULL,
                34 => NULL,
                35 => 7,

                36 => NULL,
                37 => NULL,
                38 => NULL,
                39 => NULL,
                40 => NULL,
                41 => NULL,
                42 => NULL,
                43 => NULL,
                44 => 8,

                45 => NULL,
                46 => NULL,
                47 => NULL,
                48 => NULL,
                49 => NULL,
                50 => NULL,
                51 => NULL,
                52 => NULL,
                53 => 4,

                54 => NULL,
                55 => NULL,
                56 => NULL,
                57 => NULL,
                58 => NULL,
                59 => NULL,
                60 => NULL,
                61 => NULL,
                62 => 2,

                63 => NULL,
                64 => NULL,
                65 => NULL,
                66 => NULL,
                67 => NULL,
                68 => NULL,
                69 => NULL,
                70 => NULL,
                71 => 3,

                72 => NULL,
                73 => NULL,
                74 => NULL,
                75 => NULL,
                76 => NULL,
                77 => NULL,
                78 => NULL,
                79 => NULL,
                80 => 1,
            )
        );
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
        $board = new Board([
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

    public function testCanGetBoardDataAsJson()
    {
        $array = [
            1,2,3, 4,5,6, 7,8,null,
            2,null,null, null,null,null, null,null,8,
            null,null,null, null,null,null, null,null,7,

            null,null,null, null,null,null, null,null,6,
            null,null,null, null,null,null, null,null,5,
            null,null,null, null,null,null, null,null,4,

            NULL,8,NULL,  NULL,2,3,  NULL,NULL,NULL,
            NULL,NULL,NULL,  4,NULL,NULL,  1,7,NULL,
            NULL,5,NULL,  7,NULL,NULL,  3,NULL, NULL,
        ];
        $board = new Board($array);
        $this->assertJsonStringEqualsJsonString(
            '{
              "fields":
              [ 1,2,3, 4,5,6, 7,8,null,
                2,null,null, null,null,null, null,null,8,
                null,null,null, null,null,null, null,null,7,
            
                null,null,null, null,null,null, null,null,6,
                null,null,null, null,null,null, null,null,5,
                null,null,null, null,null,null, null,null,4,
            
                null,8,null,  null,2,3,  null,null,null,
                null,null,null,  4,null,null,  1,7,null,
                null,5,null,  7,null,null,  3,null, null
              ]
            }',
            $board->asJson()
        );
    }
}