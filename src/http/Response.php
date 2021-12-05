<?php
declare(strict_types=1);


namespace sudoku;


class Response
{
    private int $code;
    private string $body;

    public function __construct(int $code, string $body)
    {
        $this->code = $code;
        $this->body = $body;
    }

    public function code()
    {
        return $this->code;
    }

    public function body()
    {
        return $this->body;
    }
}