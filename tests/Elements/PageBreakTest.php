<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\PageBreak;
use PHPUnit\Framework\TestCase;

class PageBreakTest extends TestCase
{

    private PageBreak $pageBreak;

    public function setUp(): void
    {
        $this->pageBreak = new PageBreak();
    }

    public function testMatch()
    {
        $this->assertTrue($this->pageBreak->match('==='));
        $this->assertFalse($this->pageBreak->match('|||'));

    }

    public function testSanitize()
    {
        $this->assertTrue(true);
    }
}
