<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\Action;
use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
{

    public function testMatch()
    {
        $action = new Action();
        $this->assertTrue($action->match("!This is an action"));
        $this->assertFalse($action->match("This is not an action"));
    }

    public function testSanitize()
    {
        $action = new Action();
        $this->assertEquals("This is an action", $action->sanitize("!This is an action"));
        $this->assertEquals("This is not an action", $action->sanitize("This is not an action"));
    }
}
