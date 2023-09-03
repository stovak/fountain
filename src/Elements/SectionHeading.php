<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 *
 */
class SectionHeading extends AbstractElement implements ElementInterface
{
    /**
     * @var int
     */
    public $depth = 1;

    /**
     *
     */
    public const REGEX = "/^(#{1,})\s(.*)/";

    /**
     * @param string $line
     * @param ElementInterface|null $previousElement
     * @return bool
     */
    public function match(string $line, ?ElementInterface &$previousElement = null): bool
    {
        return boolval(preg_match(self::REGEX, trim($line)));
    }

    /**
     * @param string $line
     * @return int
     */
    public function depth(string $line): int
    {
        // find the number of # (##, ###, etc.) and the text
        preg_match("/^(#+)\s*(.*)/", $line, $matches);
        list(, $depth, ) = $matches;

        // convert depth to a number and compact into array
        return strlen($depth);
    }

    /**
     * @param string $line
     * @return string
     */
    public function sanitize(string $line): string
    {
        // find the number of # (##, ###, etc.) and the text
        preg_match("/^(#+)\s*(.*)/", trim($line, ' '), $matches);
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
    public function getHeadingWithDepth(string $text): string
    {
        return sprintf('<section-heading data-depth="%d">%s</section-heading>', $this->depth, $text);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        // Section headings are ignored in the output
        // $heading = $this->getHeadingDepth($this->getText());
        return sprintf('<section-heading>%s</section-heading>', $this->getText());
    }
}
