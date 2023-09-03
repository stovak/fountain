<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\DualDialogue;
use PHPUnit\Framework\TestCase;

class DualDialogueTest extends TestCase
{
    public function testMatch()
    {
        $dualDialogue = new DualDialogue();
        $this->assertTrue($dualDialogue->match('^'));
        $this->assertFalse($dualDialogue->match('|||'));
    }


    public function testSanitize()
    {
        $dualDialogue = new DualDialogue();
        $this->assertEquals('Hello', $dualDialogue->sanitize('^Hello'));
        $this->assertEquals('Hello', $dualDialogue->sanitize('Hel^lo'));
        $this->assertEquals('Hello', $dualDialogue->sanitize('Hello^'));

    }
}
