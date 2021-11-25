<?php
declare(strict_types=1);


namespace sudoku;


use function array_key_exists;

class FieldAnalyser
{

    private BoardData $board;
    /**
     * @var int[]
     */
    private array $possible;

    public function __construct(BoardData $board)
    {
        $this->board = $board;
    }

    public function getPossibleValuesForIndex(int $int) : ?array
    {
        if($this->board->getValue($int) !== null) {
            return null;
        }
        $this->possible = [
            1,2,3,4,5,6,7,8,9
        ];
        $this->removeAllSetFromPossible($this->board->getRowForIndex($int));
        $this->removeAllSetFromPossible($this->board->getColumnForIndex($int));
        $this->removeAllSetFromPossible($this->board->getFieldForIndex($int));
        return $this->possible;

    }

    private function removeAllSetFromPossible(array $row): void
    {
        foreach ($row as $value) {
            if ($value === null) {
                continue;
            }
            if (array_key_exists($value - 1, $this->possible)) {
                unset($this->possible[$value - 1]);
            }
        }
    }
}