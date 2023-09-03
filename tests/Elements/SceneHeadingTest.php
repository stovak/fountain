<?php

namespace Fountain\Tests\Elements;

use Fountain\Elements\SceneHeading;
use PHPUnit\Framework\TestCase;

class SceneHeadingTest extends TestCase
{
    public function testMatch(): void
    {
        $sceneHeading = new SceneHeading();
        $this->assertTrue($sceneHeading->match('INT. HOUSE - DAY'));
        $this->assertTrue($sceneHeading->match('EXT. HOUSE - DAY', $sceneHeading));
        $this->assertTrue($sceneHeading->match('INT./EXT. HOUSE - DAY', $sceneHeading));
        $this->assertFalse($sceneHeading->match('INT/EXT HOUSE - DAY', $sceneHeading));
        $this->assertTrue($sceneHeading->match('.INT HOUSE - DAY', $sceneHeading));
        $this->assertTrue($sceneHeading->match('.BLAH HOUSE - DAY', $sceneHeading));
        $this->assertTrue($sceneHeading->match('EST. HOUSE - DAY', $sceneHeading));
        $this->assertTrue($sceneHeading->match('EST HOUSE - DAY', $sceneHeading));
        $this->assertFalse($sceneHeading->match(' INT. HOUSE - DAY', $sceneHeading));
        $this->assertFalse($sceneHeading->match(' ext. house - day', $sceneHeading));
    }

    public function testSanitize(): void
    {
        $sceneHeading = new SceneHeading();
        $this->assertEquals('INT. HOUSE - DAY', $sceneHeading->sanitize('INT. HOUSE - DAY'));
        $this->assertEquals('INT. HOUSE - DAY', $sceneHeading->sanitize('INT. HOUSE - DAY', $sceneHeading));
        $this->assertEquals('INT./EXT. HOUSE - DAY', $sceneHeading->sanitize('INT./EXT. HOUSE - DAY', $sceneHeading));
        $this->assertEquals('INT/EXT HOUSE - DAY', $sceneHeading->sanitize('INT/EXT HOUSE - DAY', $sceneHeading));
        $this->assertEquals('INT HOUSE - DAY', $sceneHeading->sanitize('.INT HOUSE - DAY', $sceneHeading));
        $this->assertEquals('BLAH HOUSE - DAY', $sceneHeading->sanitize('.BLAH HOUSE - DAY', $sceneHeading));
        $this->assertEquals('EST. HOUSE - DAY', $sceneHeading->sanitize('EST. HOUSE - DAY', $sceneHeading));
        $this->assertEquals('EST HOUSE - DAY', $sceneHeading->sanitize('EST HOUSE - DAY', $sceneHeading));
        $this->assertEquals('INT. HOUSE - DAY', $sceneHeading->sanitize(' INT. HOUSE - DAY', $sceneHeading));
        $this->assertEquals('ext. house - day', $sceneHeading->sanitize(' ext. house - day', $sceneHeading));
    }
}
