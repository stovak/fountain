<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\Parenthetical;
use PHPUnit\Framework\TestCase;

class ParentheticalTest extends TestCase
{

    public function testMatch(): void
    {
        $parenthetical = new Parenthetical();
        $this->assertTrue($parenthetical->match('(Hello)'));
        $this->assertFalse($parenthetical->match('|||'));
    }

    public function testSanitize(): void
    {
        $parenthetical = new Parenthetical();
        $this->assertEquals('Hello', $parenthetical->sanitize('(Hello)'));
        $this->assertEquals('Hello', $parenthetical->sanitize('Hello'));
        $this->assertEquals('Hello', $parenthetical->sanitize('(Hello'));
        $this->assertEquals('Hello', $parenthetical->sanitize('Hello)'));
    }
}
