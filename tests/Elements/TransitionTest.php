<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\Transition;
use PHPUnit\Framework\TestCase;

class TransitionTest extends TestCase
{
    public function testMatch(): void
    {
        $t = new Transition();
        $this->assertTrue($t->match('>CUT TO:'));
        $this->assertTrue($t->match('>FADE OUT.'));
        $this->assertTrue($t->match('>SMASH CUT TO:'));
        $this->assertTrue($t->match('>CUT TO BLACK.'));
        $this->assertTrue($t->match(' >CUT TO:'));
        $this->assertTrue($t->match(' >FADE OUT.'));
    }

    public function testSanitize(): void
    {
        $t = new Transition();
        $this->assertEquals('CUT TO:', $t->sanitize('>CUT TO:'));
        $this->assertEquals('FADE OUT.', $t->sanitize('>FADE OUT.'));
        $this->assertEquals('SMASH CUT TO:', $t->sanitize('>SMASH CUT TO:'));
        $this->assertEquals('CUT TO BLACK.', $t->sanitize('>CUT TO BLACK.'));
        $this->assertEquals('CUT TO:', $t->sanitize(' >CUT TO:'));
        $this->assertEquals('FADE OUT.', $t->sanitize(' >FADE OUT.'));
    }
}
