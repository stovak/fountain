<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\BlankLine;
use PHPUnit\Framework\TestCase;

class BlankLineTest extends TestCase
{
    /**
     * @var BlankLine
     */
    private $blankLine;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->blankLine = new BlankLine();
    }

    /**
     * @return void
     */
    public function testMatch(): void
    {
        $this->assertTrue($this->blankLine->match('  '));
        $this->assertFalse($this->blankLine->match(''));
        $this->assertFalse($this->blankLine->match('  a'));
    }

    /**
     * @return void
     */
    public function testSanitize(): void
    {
        $this->assertEquals(PHP_EOL, $this->blankLine->sanitize('  '));
        $this->assertEquals(PHP_EOL, $this->blankLine->sanitize(''));
        $this->assertEquals(PHP_EOL, $this->blankLine->sanitize('  a'));
    }

    /**
     * @return void
     */
    public function testToString(): void
    {
        $this->assertEquals('', $this->blankLine->__toString());
    }
}
