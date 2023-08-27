<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;

class SectionHeading extends AbstractElement
{
    public $depth = 1;

    public const REGEX = "/^(#{1,})\s(.*)/";

    public function match($line)
    {
        return preg_match(self::REGEX, trim($line));
    }

    public function depth($line)
    {
        // find the number of # (##, ###, etc.) and the text
        preg_match("/^(#+)\s*(.*)/", $line, $matches);
        list($raw, $depth, $text) = $matches;

        // convert depth to a number and compact into array
        return strlen($depth);
    }

    public function sanitize($line)
    {
        // find the number of # (##, ###, etc.) and the text
        preg_match("/^(#+)\s*(.*)/", $line, $matches);
        list($raw, $depth, $text) = $matches;

        // calculate heading depth
        $this->depth = strlen($depth);

        // return text
        return trim($text);
    }

    /**
     * Section Heading Depth
     * Sections are optional markers for managing the structure of a story.
     * You create a these by starting with a line with a hash #.
     *
     * Similar to Markdown, these headings can have multiple depths
     * for example: # h1, ## h2, ### h3,
     *
     * WARNING: Fountain usually ignores headings in the output,
     *          however we have allowed them to be rendered.
     * WARNING: Fountain checks if there is a Scene Heading before a Heading,
     *          the parser has been modified to allow headings at any time.
     * @param $text
     * @return string
     */
    public function getHeadingDepth($text)
    {
        return sprintf('<scene-heading data-depth="%d">%s</scene-heading>', $this->depth ?? 0, $text);
    }

    public function __toString()
    {
        // Section headings are ignored in the output
        // $heading = $this->getHeadingDepth($this->getText());
        return '';
    }
}
