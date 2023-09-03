<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\Lyrics;
use PHPUnit\Framework\TestCase;

class LyricsTest extends TestCase
{
    public function testMatch()
    {
        $lyrics = new Lyrics();
        $this->assertTrue($lyrics->match('~ Sing a song of sixpence'));
        $this->assertTrue($lyrics->match('~ A pocket full of rye ~'));
        $this->assertFalse($lyrics->match('Four and twenty blackbirds'));
    }

    public function testSanitize()
    {
        $lyrics = new Lyrics();
        $this->assertEquals('Sing a song of sixpence', $lyrics->sanitize('~ Sing a song of sixpence'));
        $this->assertEquals('A pocket full of rye ~', $lyrics->sanitize('~ A pocket full of rye ~'));
        $this->assertEquals('', $lyrics->sanitize('Four and twenty blackbirds'));
    }

}
