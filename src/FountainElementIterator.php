<?php

namespace Fountain;

use Fountain\Elements\NewLine;
use Hoa\Iterator\Recursive\Iterator;
use Psr\EventDispatcher\EventDispatcherInterface;

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
class FountainElementIterator implements \Countable, \Iterator
{
    /**
     * @var int
     */
    protected int $current = 0;
    /**
     * @var array<ElementInterface>
     */
    protected array $elements;
    /**
     * @var array<string>
     */
    protected array $types;

    /**
     * Add and index the element
     * @param  ElementInterface  $element
     */
    public function addElement(ElementInterface $element): void
    {
        // add to the element array
        $this->elements[] = $element;

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
            $toReturn .= (string) $this->current() . PHP_EOL;
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
        return $this->last()->is(NewLine::class);
    }
}
