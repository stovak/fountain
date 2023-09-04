<?php

namespace Fountain\Tests;

use Fountain\ElementInterface;
use Fountain\FountainParser;
use PHPUnit\Framework\TestCase;

class FountainParserTest extends TestCase
{
    public function testParse()
    {
        $contents = file_get_contents('tests/fixtures/the_synchronized_worlds.fountain');
        $parser = new FountainParser();
        $result = $parser->parse($contents);
        $ref = file_get_contents('tests/fixtures/the_synchronized_worlds.html');
        $this->assertEquals($ref, $result);
    }

    public function testEventDispatcher(): void
    {

        $contents = file_get_contents('tests/fixtures/the_synchronized_worlds.fountain');
        $parser = new FountainParser();
        $parser->on('fountain.render', [$this, 'eventResponder']);
        $parsed = $parser->parse($contents);
        $this->assertNotEmpty($parsed);
        $rendered = (string) $parsed;
    }

    public function eventResponder($element): void
    {
        print_r($element);
    }

}
