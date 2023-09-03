<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\Character;
use Fountain\Elements\Dialogue;
use PHPUnit\Framework\TestCase;

class DialogueTest extends TestCase
{
    private $dialogue;

    public function setUp(): void
    {
        $this->dialogue = new Dialogue();
    }

    public function testMatch()
    {
        $char = new Character();
        // test no preceding character
        $this->assertFalse($this->dialogue->match('Hello'));
        // test parenthetical
        $this->assertFalse($this->dialogue->match('(breathy)', $char));
        // test dialogue
        $this->assertTrue($this->dialogue->match('Hello', $char));
    }
}
