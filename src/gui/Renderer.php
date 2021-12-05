<?php
declare(strict_types=1);


namespace sudoku;


interface Renderer
{
    public function renderHomePage() : string;
}