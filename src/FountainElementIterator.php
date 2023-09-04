<?php

namespace Fountain;

use Fountain\Elements\NewLine;
use Fountain\Events\AddElementEvent;
use Fountain\Events\AddEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerTrait;
use Psr\Log\NullLogger;

/**
 * FountainElement
 * Based off the FastFountainParser.m
 *
 * https://github.com/alexking/Fountain-PHP
 *
 * @author Tom Stovall (php 8.2 port)
 * @author Alex King (PHP port)
 * @author Nima Yousefi & John August (original Objective-C version)
 */
class FountainElementIterator implements \Countable, \Iterator, \Psr\Log\LoggerAwareInterface
{
    use LoggerAwareTrait;
    use LoggerTrait;

    protected EventDispatcherInterface $eventDispatcher;

    /**
     * @var int
     */
    protected int $current = 0;
    /**
     * @var array<ElementInterface>
     */
    protected array $elements = [];
    /**
     * @var array<string>
     */
    protected array $types = [];

    public function __construct(?EventDispatcherInterface $eventDispatcher = null)
    {
        $this->logger = new NullLogger();
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Add and index the element
     * @param  ElementInterface  $element
     */
    public function addElement(?ElementInterface $element = null): void
    {
        if (!$element instanceof ElementInterface) {
            return;
        }
        if ($element->is(NewLine::class) && $this->lastElementIsNewline()) {
            return;
        }
        $this->elements = array_merge(array_filter($this->elements), [$element]);
        $this->eventDispatcher->dispatch(new AddElementEvent($this->last()));
        // add to the types array for quick searching
        $this->types[] = $element->getType();
    }

    /**
     * Find the most recent element by type
     * @param  string  $type  type of element
     * @return ?ElementInterface
     */
    public function &findLastElementOfType(string $type): ?ElementInterface
    {
        $response = null;
        // reverse the index
        $types = array_reverse((array) $this->types, true);

        // find the last one
        $index = array_search($type, $types, true);

        // return if successful
        if ($index) {
            $response = &$this->elements[$index];
        }
        return $response;
    }

    /**
     * Return the number of elements
     * @return int
     */
    public function count(): int
    {
        return ($this->elements) ? count($this->elements) : 0;
    }

    /**
     * Convert to string
     */
    public function __toString(): string
    {
        $toReturn = "";

        for ($this->rewind(); $this->valid(); $this->next()) {
            if ($this->current() instanceof ElementInterface) {
                $toReturn .= (string) $this->current();
            }
        }

        return "<screenplay>" . $toReturn . "</screenplay>";
    }

    /**
     * @return ElementInterface
     */
    public function current(): ElementInterface
    {
        return $this->elements[$this->current];
    }

    /**
     * @return void
     */
    public function next(): void
    {
        $this->current++;
    }

    /**
     * @return int|null
     */
    public function key(): ?int
    {
        if ($this->valid()) {
            return $this->current;
        }
        return null;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->elements[$this->current]);
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->current = 0;
    }

    /**
     * @return ElementInterface|null
     */
    public function &first(): ?ElementInterface
    {
        return $this->elements[0];
    }

    /**
     * @return ElementInterface|null
     */
    public function &last(): ?ElementInterface
    {
        return $this->elements[count($this->elements) - 1];
    }

    /**
     * @return bool
     */
    public function lastElementIsNewline(): bool
    {
        return $this->last()?->is(NewLine::class) ?? false;
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        // TODO: Implement log() method.
    }
}
