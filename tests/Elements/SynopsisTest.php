<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\Synopsis;
use PHPUnit\Framework\TestCase;

class SynopsisTest extends TestCase
{

    public function testMatch(): void
    {
        $synopsis = new Synopsis();
        $this->assertTrue($synopsis->match('= Synopsis'));
        $this->assertTrue($synopsis->match(' = Synopsis'));
        $this->assertTrue($synopsis->match(' = Synopsis '));
        $this->assertTrue($synopsis->match(' = Synopsis ='));
    }

    public function testSanitize(): void
    {
        $synopsis = new Synopsis();
        $this->assertEquals('Synopsis', $synopsis->sanitize('= Synopsis'));
        $this->assertEquals('Synopsis', $synopsis->sanitize(' = Synopsis'));
        $this->assertEquals('Synopsis', $synopsis->sanitize(' = Synopsis '));
        $this->assertEquals('Synopsis =', $synopsis->sanitize(' = Synopsis ='));
    }
}
