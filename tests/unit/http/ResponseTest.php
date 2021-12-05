<?php

namespace sudoku;


use PHPUnit\Framework\TestCase;

/**
 * @covers \sudoku\Response
 */
class ResponseTest extends TestCase
{

    public function testCanCreateResponse()
    {
        $response = new Response(200, 'OK');

        $this->assertEquals(200, $response->code());
        $this->assertEquals('OK', $response->body());
    }
}
