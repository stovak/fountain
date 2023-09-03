<?php

namespace Fountain\Tests;

use Fountain\Elements\Action;
use Fountain\Elements\Character;
use Fountain\Elements\Dialogue;
use Fountain\Elements\NewLine;
use Fountain\Elements\Parenthetical;
use Fountain\Elements\SectionHeading;
use Fountain\FountainElementIterator;
use PHPUnit\Framework\TestCase;

class FountainElementIteratorTest extends TestCase
{
    public function testFindLastElementOfType(): void
    {
        $headExpected = new SectionHeading();
        $headExpected->setText("EXT. STABLE - DAY");
        $it = new FountainElementIterator();
        $it->addElement(new NewLine());
        $it->addElement($headExpected);
        $it->addElement(new Action());
        $it->last()->setText("John goes to see a man about a horse.");
        $it->addElement(new Character());
        $it->last()->setText("JOHN");
        $it->addElement(new Parenthetical());
        $it->last()->setText("(to himself)");
        $it->addElement(new Dialogue());
        $it->last()->setText("I wonder if he has any horses for sale.");
        $it->addElement(new NewLine());
        $headResult = $it->findLastElementOfType(SectionHeading::class);
        $this->assertNotNull($headResult, "Result should not be null");
        $this->assertSame(
            $headExpected,
            $headResult,
            sprintf(
                "Expected %s, got %s",
                print_r($headExpected, true),
                print_r($headResult, true)
            )
        );
        $contents = file_get_contents("fixtures/rendered_test-1.html");
        $this->assertEquals($contents, (string) $it);
    }

    public function test__toString(): void
    {

    }

    public function testAddElement()
    {

    }
}
