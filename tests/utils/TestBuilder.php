<?php

namespace Fountain\Tests\utils;

use Fountain\Elements\Action;
use Fountain\Elements\Character;
use Fountain\Elements\Dialogue;
use Fountain\Elements\NewLine;
use Fountain\Elements\Parenthetical;
use Fountain\Elements\SectionHeading;
use Fountain\Elements\Transition;
use Fountain\FountainElementIterator;
use Psr\EventDispatcher\EventDispatcherInterface;

class TestBuilder
{
    public static function buildMeAnIterator(?EventDispatcherInterface $dispatcher = null): FountainElementIterator
    {
        $it = new FountainElementIterator();
        $it->addElement(new NewLine($dispatcher));
        $it->addElement(new Transition($dispatcher));
        $it->last()->setText("FADE IN:");
        $it->addElement(new SectionHeading($dispatcher));
        $it->last()->setText("EXT. STABLE - DAY");
        $it->addElement(new Action($dispatcher));
        $it->last()->setText("John goes to see a man about a horse.");
        $it->addElement(new Character($dispatcher));
        $it->last()->setText("JOHN");
        $it->addElement(new Parenthetical($dispatcher));
        $it->last()->setText("(to himself)");
        $it->addElement(new Dialogue($dispatcher));
        $it->last()->setText("I wonder if he has any horses for sale.");
        $it->addElement(new Action($dispatcher));
        $it->last()->setText("John Buys the Horse.");
        $it->addElement(new Character($dispatcher));
        $it->last()->setText("MARY");
        $it->addElement(new Dialogue($dispatcher));
        $it->last()->setText("I can't believe you bought a horse.");
        $it->addElement(new Action($dispatcher));
        $it->last()->setText("John rides off into the sunset.");
        $it->addElement(new Transition($dispatcher));
        $it->last()->setText("FADE OUT:");
        $it->addElement(new NewLine($dispatcher));
        return $it;
    }

}
