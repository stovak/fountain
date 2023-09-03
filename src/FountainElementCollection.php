<?php

namespace Fountain;

/**
 * FountainElement
 * Based off the FastFountainParser.m
 *
 * https://github.com/alexking/Fountain-PHP
 *
 * @author Alex King (PHP port)
 * @author Nima Yousefi & John August (original Objective-C version)
 */
class FountainElementCollection
{
    public array $elements;
    public array $types;

    /**
     * Add and index the element
     * @param  AbstractElement  $element
     */
    public function addElement(ElementInterface $element): void
    {
        // add to the element array
        $this->elements[] = $element;

        // add to the types array for quick searching
        $this->types[] = $element->getType();
    }

    /**
     * Convenience function for creating and adding a FountainElement
     * @param $element AbstractElement Character, Dialogue, etc
     */
    public function createAndAddElement($element): void
    {
        // add to the collection
        $this->add_element($element);
    }

    /**
     * Find the most recent element by type
     * @param  string  $type  type of element
     * @return mixed    FountainElement or FALSE
     */
    public function &findLastElementOfType(string $type): ?ElementInterface
    {
        $response = false;

        // reverse the index
        $types = array_reverse((array) $this->types, true);

        // find the last one
        $index = array_search($type, $types, true);

        // return if successful
        if ($index) {
            $response = $this->elements[$index];
        }

        return $response;
    }

    /**
     * Find the last element
     * @return ElementInterface
     */
    public function &lastElement(): ?ElementInterface
    {
        $response = false;

        if ($this->elements && $count = count($this->elements)) {
            $response = $this->elements[$count - 1];
        }

        return $response;
    }

    /**
     * Return the number of elements
     * @return int
     */
    public function count()
    {
        return ($this->elements) ? count($this->elements) : 0;
    }

    /**
     * Convert to string
     */
    public function __toString()
    {
        $string = "";

        foreach ((array) $this->elements as $element) {
            $string .= (string) $element."\n";
        }

        return "<screenplay>" . $string . "</screenplay>";
    }

}
