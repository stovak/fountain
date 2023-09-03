<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\NewLine;
use PHPUnit\Framework\TestCase;

class NewLineTest extends TestCase
{
    public function testMatch()
    {
        $newLine = new NewLine();
        $this->assertTrue($newLine->match(""));
        $this->assertTrue($newLine->match(" "));
    }

    public function testSanitize()
    {
        $newLine = new NewLine();
        $this->assertEquals("" . PHP_EOL, $newLine->sanitize(""));
        $this->assertEquals("" . PHP_EOL, $newLine->sanitize(" "));
    }
}