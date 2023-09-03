<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\Notes;
use PHPUnit\Framework\TestCase;

class NotesTest extends TestCase
{
    private Notes $notes;

    public function setUp(): void
    {
        $this->notes = new Notes();
    }

    public function testMatch()
    {
        $this->assertTrue($this->notes->match('[[blah]]'));
        $this->assertTrue($this->notes->match('[[blah blah]]'));
        $this->assertFalse($this->notes->match('[blah]'));
        $this->assertFalse($this->notes->match('blah'));
    }

    public function testSanitize()
    {
        $this->assertEquals('blah', $this->notes->sanitize('[[blah]]'));
        $this->assertEquals('blah blah', $this->notes->sanitize('[[blah blah]]'));
    }
}
