<?php
declare(strict_types=1);


namespace sudoku;

use function file_get_contents;

/**
 * Rendering will not be covered
 * @codeCoverageIgnore
 */
class TempanRendererAdapter implements Renderer
{

    public function renderHomePage(): string
    {
        $viewObject = [];
        for ($i = 0; $i < 81; $i++) {
            $viewObject[] = [
                'input' => [
                    'name' => $i,
                    '_' => '',
                    #'value' => $board->getValue($i)
                ]
            ];
        };
        $template = __DIR__ . '/../../../templates/board.html';
        $viewObject= ['board' =>
                [
                    'field' => $viewObject
                ]
            ];
        $tempan = new \watoki\tempan\Renderer(file_get_contents($template));
        return $tempan->render($viewObject);
    }
}