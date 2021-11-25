<?php
declare(strict_types=1);


namespace sudoku;


use function array_keys;
use function array_values;
use function count;
use function is_null;

class Solver
{

    private BoardData $board;
    private bool $anotherSolutionWasFound;

    public function solveBoard(BoardData $board) : BoardData
    {
        $this->board = $board;
        $fieldAnalyser = new FieldAnalyser($this->board);
        $this->anotherSolutionWasFound = true;

        while($this->anotherSolutionWasFound) {

            $this->anotherSolutionWasFound = false;

            $possibles=[];
            for ($i = 0; $i < 81; $i++) {
                $possibles[$i] = $fieldAnalyser->getPossibleValuesForIndex($i);
            }
            for ($i=0; $i<81;$i++) {

                $numbersToCheck = $this->board->getRowForIndex($i);
                $solutionOrNull = $this->solveOneMissingField($numbersToCheck);
                $this->setSolution($solutionOrNull);

                $numbersToCheck = ($this->board->getColumnForIndex($i));
                $solutionOrNull = $this->solveOneMissingField($numbersToCheck);
                $this->setSolution($solutionOrNull);

                $numbersToCheck = $this->board->getFieldForIndex($i);
                $solutionOrNull = $this->solveOneMissingField($numbersToCheck);
                $this->setSolution($solutionOrNull);

                $solutionOrNull = $this->checkPossiblesWithOnlyOneValue($possibles);
                $this->setSolution($solutionOrNull);

                $solutionOrNull = $this->solvePossibleSets($possibles, $this->board->getRowForIndex($i));
                $this->setSolution($solutionOrNull);

                $solutionOrNull = $this->solvePossibleSets($possibles, $this->board->getColumnForIndex($i));
                $this->setSolution($solutionOrNull);

                $solutionOrNull = $this->solvePossibleSets($possibles, $this->board->getFieldForIndex($i));
                $this->setSolution($solutionOrNull);
            }
        }
        return $this->board;
    }

    public function solvePossibleSets(array $orderedPossibleList, array $orderedLogicalValues) : ?array
    {
        $possible = $this->getMissingPossibleValuesFor($orderedLogicalValues);

        $possiblesToCheck = [];
        foreach(array_keys($orderedLogicalValues) as $indexOfRow) {
            if ($orderedPossibleList[$indexOfRow] !== null) {
                $possiblesToCheck[$indexOfRow] = $orderedPossibleList[$indexOfRow];
            }
        }

        if (!$this->possibleValuesAreDefinedForAllMissingValues($possiblesToCheck, $possible)) {
            return null;
        }

        return $this->getValuesWithOnlyOneSolutionOrNull($possiblesToCheck);
    }

    public function solveOneMissingField(array $row) : ?array
    {
        $possible = [
            1,2,3,4,5,6,7,8,9
        ];
        $found = null;
        foreach ($row as $key => $value) {
            if (is_null($value)) {
                if ($found === null) {
                    $found = $key;
                } else {
                    return null;
                }
            } else {
                unset($possible[$value-1]);
            }
        }
        if ($found === null) {
            return null;
        }
        $row[$found] = array_values($possible)[0];
        return $row;
    }

    private function setSolution(?array $solutionOrNull): void
    {
        if ($solutionOrNull !== null) {
            $this->board->setValues($solutionOrNull);
            $this->anotherSolutionWasFound = true;
        }
    }

    private function checkPossiblesWithOnlyOneValue(array $possibles) : ?array
    {
        $possiblesWithOnlyOneValue = [];
        foreach ($possibles as $index => $possibleValues) {
            if ($possibleValues !== null && count($possibleValues) == 1) {
                $possiblesWithOnlyOneValue[$index] = array_values($possibleValues)[0];
            }
        }
        if (count($possiblesWithOnlyOneValue) > 0) {
            return $possiblesWithOnlyOneValue;
        }
        return null;
    }

    private function possibleValuesAreDefinedForAllMissingValues(array $possiblesToCheck, array $possible): bool
    {
        return count($possiblesToCheck) === count($possible);
    }

    private function getValuesWithOnlyOneSolutionOrNull(array $possiblesToCheck): ?array
    {
        $numbersAndListOfIndex = $this->sortPossiblesWithNumberAsKeyAndArrayWithIndexes($possiblesToCheck);

        return $this->setArrayWithOnlyOneIndexAsIndexIfOnlyOneIsSetOrReturnNull($numbersAndListOfIndex);
    }

    private function getMissingPossibleValuesFor(array $row): array
    {
        $possible = [
            1, 2, 3, 4, 5, 6, 7, 8, 9
        ];

        foreach ($row as $value) {
            if (!is_null($value)) {
                unset($possible[$value - 1]);
            }
        }
        return $possible;
    }

    /**
     * Returns in Key the Numbers and the indexes of those values as array, eg.
     * 1 => (4,5)
     * 2 => null,
     * 3 => (6,7,8)
     */
    private function sortPossiblesWithNumberAsKeyAndArrayWithIndexes(array $possiblesToCheck): array
    {
        $possibleCounter = [];
        foreach ($possiblesToCheck as $index => $value) {
            foreach ($value as $numbers) {
                $possibleCounter[$numbers][] = $index;
            }
        }
        return $possibleCounter;
    }

    private function setArrayWithOnlyOneIndexAsIndexIfOnlyOneIsSetOrReturnNull(array $numbersAndListOfIndex): ?array
    {
        $found = [];
        foreach ($numbersAndListOfIndex as $number => $indexes) {
            if (count($indexes) === 1) {
                $found[$indexes[0]] = $number;
            }
        }
        if (count($found) > 0) {
            return $found;
        }
        return null;
    }
}