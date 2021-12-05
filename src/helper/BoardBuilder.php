<?php
declare(strict_types=1);


namespace sudoku;


use function is_array;
use function json_decode;
use function strlen;
use function substr;

class BoardBuilder
{
    public function fromString($string) : Board
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

        return new Board($ret);
    }

    public function fromJson(string $string) : Board
    {
        $data = json_decode($string, true);
        return new Board($data['fields']);
    }
}