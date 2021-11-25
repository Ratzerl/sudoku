<?php
declare(strict_types=1);


namespace sudoku;


use InvalidArgumentException;
use function count;
use function json_encode;

class Board
{
    private array $fields;

    public function __construct(array $fields)
    {
        if (count($fields) !== 81) {
            //@codeCoverageIgnoreStart
            throw new InvalidArgumentException('Can only create 9x9 sudoku');
            //@codeCoverageIgnoreEnd
        }
        $this->fields = [];
        foreach($fields as $field) {
            $this->addField($field);
        }
    }

    private function addField(?int $field)
    {
        $this->fields[] = $field;
    }

    public function getValue(int $int) : ?int
    {
        return $this->fields[$int];
    }

    public function getRowForIndex(int $int) : array
    {
        return $this->getRowsWithIndex((int) ($int / 9));
    }

    private function getRowsWithIndex(int $rowIndex): array
    {
        $row = [];
        for ($i = 0; $i < 9; $i++) {
            $row[$rowIndex * 9 + $i] = $this->fields[$rowIndex * 9 + $i];
        }
        return $row;
    }

    public function getColumnForIndex(int $int) : array
    {
        return $this->getColumnsWithIndex($int % 9);
    }

    private function getColumnsWithIndex(int $columnIndex): array
    {
        $column = [];
        for ($i = 0; $i < 9; $i++) {
            $column[$columnIndex + $i * 9] = $this->fields[$columnIndex + $i * 9];
        }
        return $column;
    }

    public function getFieldForIndex(int $int) : array
    {
        $field = 0;

        if ($int%9>2) {
            $field++;
        }
        if ($int%9>5) {
            $field++;
        }
        if ($int>26) {
            $field+=3;
        }
        if ($int>53) {
            $field+=3;
        }
        return $this->getFieldWithIndex((int)$field);
    }

    private function getFieldWithIndex(int $int): array
    {
        $key = (($int % 3) * 3);

        if ($int > 2) {
            $key += 27;
        }
        if ($int > 5) {
            $key += 27;
        }
        $field = [];
        for ($j = 0; $j < 3; $j++) {
            for ($i = 0; $i < 3; $i++) {
                $index = $key + $i + ($j * 9);
                $field[$index] = $this->fields[$index];
            }
        }
        return $field;
    }

    public function setValues(array $solvedFieldsWithIndex)
    {
        foreach ($solvedFieldsWithIndex as $index => $value) {
            $this->fields[$index] = $value;
        }
    }

    public function asJson() : string
    {
        return json_encode([
            'fields' => $this->fields
        ]);
    }

}