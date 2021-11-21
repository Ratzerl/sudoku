<?php
declare(strict_types=1);


namespace sudoko;


use InvalidArgumentException;
use function array_values;
use function count;
use function strlen;
use function substr;

class BoardData
{
    private array $fields;

    public function __construct(array $fields)
    {
        if (count($fields) !== 81) {
            //@codeCoverageIgnoreStart
            throw new InvalidArgumentException('Can only create 9x9 sudoku');
            //@codeCoverageIgnoreEnd
        }
        $this->fields = $fields;
    }

    public static function fromString(string $string) : BoardData
    {
        $ret = [];
        for($i = 0; $i <strlen($string); $i++) {
            $val = substr($string, $i, 1);
            if ($val === '0') {
                $ret[] = null;
            } else if ($val === '1') {
                $ret[] = 1;
            } else {
                switch ($val) {
                    case '2':
                    case '3':
                    case '4':
                    case '5':
                    case '6':
                    case '7':
                    case '8':
                    case '9':
                        $ret[] = (int)$val;
                }
            }
        }

        return new self($ret);
    }


    public function asString() : string
    {
        $ret = '';
        foreach ($this->fields as $key => $field) {
            if ($key % 9 === 0 && $key !== 0) {
                $ret .= "\n";
            }
            if ($key % 3 === 0) {
                $ret .= '|';
            }
            $ret .= $field;
            if ($field === null) {
                $ret .= ' ';
            }
        }
        return $ret;
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

}