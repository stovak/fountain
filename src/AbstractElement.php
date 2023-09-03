<?php

namespace Fountain;

use Fountain\Illuminate\Str;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 *
 */
abstract class AbstractElement implements ElementInterface
{
    /**
     * @var bool
     */
    public bool $parseEmphasis = false;

    /**
     * @var string text value
     */
    protected string $text = "";

    /**
     * @var string name of Child class
     */
    protected string $type;




    /**
     * Store the name of the Child class
     *
     * AbstractElement constructor.
     */
    public function __construct(EventDispatcherInterface $eventDispatcher = null)
    {
        $this->type = get_class($this);
        $this->eventDispatcher = $eventDispatcher ?? new EventDispatcher();
    }

    /**
     * Get the name of the Child class with namespace
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the short name of the Child class
     * @return string classname
     */
    public function getClass(): string
    {
        return substr((string)(strrchr($this->getType(), '\\')), 1);
    }

    /**
     * Determine if the Element Types match
     *
     * @param string $type
     * @return bool
     */
    public function is(string $type): bool
    {
        return $this instanceof $type;
    }

    /**
     * Get the text value of the element
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Append to the text value of the element
     *
     * @param string $text
     */
    public function appendText($text): void
    {
        $this->text .= $text;
    }

    /**
     * Set the text value of the element
     *
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * Create the FountainElement
     */
    public function create(string $text): ElementInterface
    {
        $this->text = $this->sanitize($text);
        return $this;
    }

    /**
     * Match an element with regex
     */
    abstract public function match(string $line, ?ElementInterface &$previousElement = null): bool;

    /**
     * Sanitize and clean text
     */
    abstract public function sanitize(string $line): string;

    /**
     * Render the element
     */
    public function __toString(): string
    {
        if ($this->text === '') {
            return '';
        }

        $className = Str::kebab($this->getClass());
        $this->eventDispatcher->dispatch(new Events\RenderEvent($this));
        return "<$className>{$this->text}</$className>";
    }
}
