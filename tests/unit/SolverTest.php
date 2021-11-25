<?php
declare(strict_types=1);


namespace sudoku;


use PHPUnit\Framework\TestCase;

/**
 * @covers \sudoku\Solver
 * @uses \sudoku\BoardData
 * @uses \sudoku\FieldAnalyser
 */
class SolverTest extends TestCase
{

    private Solver $solver;

    public function setUp() : void
    {
        $this->solver = new Solver();
    }

    public function solvedSodukus() : array
    {
        return [
            [
                '
             906 741 802
             450 908 063
             872 063 940
             
             014 280 609
             205 307 410
             089 016 025
             
             120 630 097
             540 109 206
             097 802 134
            ',
                '|936|741|852
|451|928|763
|872|563|941
|314|285|679
|265|397|418
|789|416|325
|128|634|597
|543|179|286
|697|852|134'
            ],
            [
                '
             030 006 001
             200 500 000
             004 000 029
             
             060 940 500
             100 000 090
             002 000 006
             
             080 023 000
             000 400 170
             050 700 300',
                '|837|296|451
|296|514|783
|514|837|629
|368|942|517
|175|368|294
|942|175|836
|781|623|945
|623|459|178
|459|781|362'
            ],
            [
                '
             000 800 045
             460 000 001
             000 900 008
             
             070 030 500
             009 050 706
             000 020 300
             
             050 002 060 
             040 006 820 
             630 004 000
             ',
                '|793|861|245
|468|275|931
|215|943|678
|174|639|582
|329|458|716
|586|127|394
|851|392|467
|947|516|823
|632|784|159'
            ],
        ];
    }

    /**
     * @dataProvider solvedSodukus
     */
    public function testCanSolveSimple(string $problem, string $boardResultString)
    {
        $board = BoardData::fromString(
            $problem
        );

        $this->solver->solveBoard($board);
        $this->assertEquals(
            BoardData::fromString($boardResultString),
            $board
        );
    }


    public function testSolvesOnlyTillPossible()
    {
        $board = BoardData::fromString(
            '
             000 800 045
             460 000 001
             000 900 008
             
             000 000 000
             009 050 706
             000 020 300
             
             050 002 060 
             040 006 820 
             630 004 000
             '
        );

        $this->solver->solveBoard($board);
        $this->assertEquals(
            BoardData::fromString(
                '
             090 860 245
             468 205 901
             000 940 608
             
             000 000 002
             009 450 706
             000 020 300
             
             850 092 060 
             940 506 820 
             632 084 000
             '
            ),
            $board
        );
    }

    public function getPossiblesToSolve() : array
    {
        return [
            [
                [
                    0 =>
                        [
                            4 => 5,
                            6 => 7,
                            7 => 8,
                            8 => 9,
                        ],
                    1 => NULL,
                    2 =>
                        [
                            4 => 5,
                            6 => 7,
                            7 => 8,
                            8 => 9,
                        ],
                    3 =>
                        [
                            1 => 2,
                            7 => 8,
                        ],
                    4 =>
                        [
                            6 => 7,
                            7 => 8,
                            8 => 9,
                        ],
                    5 => NULL,
                    6 =>
                        [
                            3 => 4,
                            6 => 7,
                            7 => 8,
                        ],
                    7 => [
                            3 => 4,
                            4 => 5,
                            7 => 8,
                        ],
                    8 => NULL,
                ],
                [
                    0 => NULL,
                    1 => 3,
                    2 => NULL,
                    3 => NULL,
                    4 => NULL,
                    5 => 6,
                    6 => NULL,
                    7 => NULL,
                    8 => 1,
                ],
                [
                    3 => 2
                ]
            ],
            [
                [
                    54 => [4,6,7,9],
                    55 => null,
                    56 => [1,6,7,9],
                    63 => [3,6,9],
                    64 => [2,3,9],
                    65 => [3,6,9],
                    72 => [4,6,9],
                    73 => null,
                    74 => [1,6,9],
                ],
                [
                    54 => NULL,
                    55 => 8,
                    56 => NULL,
                    63 => NULL,
                    64 => null,
                    65 => NULL,
                    72 => NULL,
                    73 => 5,
                    74 => NULL,
                ],
                [
                    64 => 2,
                ]
            ]
        ];
    }

    /**
     * @dataProvider getPossiblesToSolve
     */
    public function testSolvesPossibles($possibles, $currentFields, $expectedSolution)
    {
        $this->assertEquals(
            $expectedSolution,
            $this->solver->solvePossibleSets(
                $possibles,
                $currentFields
            )
        );
    }

    public function getMissingFields() : array
    {
        return [
            [
                [
                    1,2,3,4,5,6,7,8,null
                ],
                [
                    1,2,3,4,5,6,7,8,9
                ]
            ],
            [
                [
                    1,2,3,4,5,6,7,null,null
                ],
                null,
            ],
            [
                [
                    null,2,3,4,5,6,7,8,9
                ],
                [
                    1,2,3,4,5,6,7,8,9
                ]
            ],
            [
                [
                    1,2,3,4,5,6,7,8,9
                ],
                null
            ],
            [
                [
                    9,8,7,null,5,4,3,2,1
                ],
                [
                    9,8,7,6,5,4,3,2,1
                ],
            ],
            [
                [
                    1 => 9,
                    2 => 8,
                    3 => 7,
                    6 => null,
                    7 => 5,
                    8 => 4,
                    11 => 3,
                    12 => 2,
                    13 => 1
                ],
                [
                    1 => 9,
                    2 => 8,
                    3 => 7,
                    6 => 6,
                    7 => 5,
                    8 => 4,
                    11 => 3,
                    12 => 2,
                    13 => 1
                ]
            ]
        ];

    }

    /**
     * @dataProvider getMissingFields
     */
    public function testSolvesMissingFields(array $missingFields, ?array $solution)
    {

        $this->assertEquals(
            $solution,
            $this->solver->solveOneMissingField(
                $missingFields
            )
        );

    }
}