<?php

namespace Fountain\Tests;

use Fountain\Elements\Action;
use Fountain\Elements\Character;
use Fountain\Elements\Dialogue;
use Fountain\Elements\NewLine;
use Fountain\Elements\Parenthetical;
use Fountain\Elements\SectionHeading;
use Fountain\Elements\Transition;
use Fountain\FountainElementIterator;
use Fountain\Tests\utils\TestBuilder;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

class FountainElementIteratorTest extends TestCase
{
    public function testFindLastElementOfType(): void
    {
        $it = TestBuilder::buildMeAnIterator(null);
        $headResult = $it->findLastElementOfType(SectionHeading::class);
        $this->assertNotNull($headResult, "Result should not be null");
        $this->assertEquals(SectionHeading::class, $headResult->getType());
        $this->assertEquals("EXT. STABLE - DAY", $headResult->getText());
        $expected = str_replace(PHP_EOL, "", file_get_contents("tests/fixtures/rendered_test-1.html"));
        $actual = str_replace(PHP_EOL, "", (string) $it);
        $this->assertEquals($expected, $actual);
    }


}
