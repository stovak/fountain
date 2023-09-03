<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\TextCenter;
use PHPUnit\Framework\TestCase;

class TextCenterTest extends TestCase
{

    public function testSanitize(): void
    {
        $s = new TextCenter();
        $this->assertEquals('CENTERED TEXT', $s->sanitize('>CENTERED TEXT<'));
        $this->assertEquals('CENTERED TEXT', $s->sanitize(' >CENTERED TEXT<'));

    }

    public function testMatch(): void
    {
        $s = new TextCenter();
        $this->assertTrue($s->match('>CENTERED TEXT<'));
        $this->assertTrue($s->match(' >CENTERED TEXT<'));
    }
}
