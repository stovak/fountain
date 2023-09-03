<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\Character;
use PHPUnit\Framework\TestCase;

class CharacterTest extends TestCase
{
    public function testMatch(): void
    {
        $character = new Character();

        $this->assertTrue($character->match("CHARACTERS"));
        $this->assertTrue($character->match("@CHARACTER"));
        $this->assertTrue($character->match(" @CHARACTER"));
        $this->assertTrue($character->match("  @CHARACTER"));
        $this->assertFalse($character->match("   CHARacter"));
    }

    public function testSanitize(): void
    {
        $character = new Character();

        $this->assertEquals("CHARACTER", $character->sanitize("CHARACTER"));
        $this->assertEquals("CHARACTER", $character->sanitize("@CHARACTER"));
        $this->assertEquals("CHARACTER", $character->sanitize(" @CHARACTER"));
        $this->assertEquals("CHARACTER", $character->sanitize("  @CHARACTER"));
        $this->assertEquals("CHARACTER", $character->sanitize("   @CHARACTER"));
    }
}
