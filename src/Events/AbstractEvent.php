<?php

namespace Fountain\Events;

use Fountain\ElementInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class AbstractEvent extends Event
{
    protected ElementInterface $element;

    public function __construct(ElementInterface &$element)
    {
        $this->element = $element;
    }

    public function getType(): string
    {
        return $this->element->getType();
    }

    public function getText(): string
    {
        return $this->element->getText();
    }

    public function getElement(): ElementInterface
    {
        return $this->element;
    }

}
