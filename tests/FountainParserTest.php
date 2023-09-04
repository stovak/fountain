<?php

namespace Fountain\Tests;

use Fountain\FountainParser;
use PHPUnit\Framework\TestCase;

class FountainParserTest extends TestCase
{
    public function testParse()
    {
        $contents = file_get_contents('fixtures/the_synchronized_worlds.fountain');
        $parser = new FountainParser();
        $result = $parser->parse($contents);
        $ref = file_get_contents('fixtures/the_synchronized_worlds.html');
        $this->assertEquals($ref, $result);
    }
}
