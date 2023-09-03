<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\SectionHeading;
use PHPUnit\Framework\TestCase;

class SectionHeadingTest extends TestCase
{

    public function testMatch(): void
    {
        $sectionHeading = new SectionHeading();
        $this->assertTrue($sectionHeading->match('# Section Heading'));
        $this->assertTrue($sectionHeading->match(' # Section Heading'));
        $this->assertTrue($sectionHeading->match(' # Section Heading '));
        $this->assertTrue($sectionHeading->match(' # Section Heading #'));
    }

    public function testSanitize(): void
    {
        $sectionHeading = new SectionHeading();
        $this->assertEquals('Section Heading', $sectionHeading->sanitize('# Section Heading'));
        $this->assertEquals('Section Heading', $sectionHeading->sanitize(' # Section Heading'));
        $this->assertEquals('Section Heading', $sectionHeading->sanitize(' # Section Heading '));
        $this->assertEquals('Section Heading #', $sectionHeading->sanitize(' # Section Heading #'));
    }
}
