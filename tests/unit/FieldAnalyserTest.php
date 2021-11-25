<?php

namespace sudoku;


use PHPUnit\Framework\TestCase;
use function var_export;

/**
 * @covers \sudoku\FieldAnalyser
 * @uses \sudoku\BoardData
 */
class FieldAnalyserTest extends TestCase
{

    private BoardData $boardData;

    public function testReturnsPossibleValues()
    {
        $this->boardData = new BoardData(
            [
                9,null,6,  7,4,1,  8,null,2,
                4,5,null, 9,null,8, null,6,3,
                8,7,2, null,6,3, 9,4,null,

                null,1,4,  2,8,null,  6,null,9,
                2,null,5, 3,null,7,  4,1,null,
                null,8,9,  null,1,6,  null,2,5,

                1,2,null,  6,3,null,  null,9,7,
                5,4,null,  1,null,9,  2,null,6,
                null,9,7,  8,null,2,  1,3, null
            ]
        );

        $fieldAnalyer = new FieldAnalyser($this->boardData);
        $this->assertEquals(
            null,
            $fieldAnalyer->getPossibleValuesForIndex(0)
        );
        $possible = $fieldAnalyer->getPossibleValuesForIndex(1);
        $this->assertContains(
            3,
            $possible,
            var_export($possible, true)
        );

        $this->assertCount(1, $possible);

        $possible = $fieldAnalyer->getPossibleValuesForIndex(11);
        $this->assertContains(
            1,
            $possible
        );
        $this->assertCount(1, $possible);
    }
}
