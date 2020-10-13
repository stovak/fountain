<?php

namespace App\Fountain\Elements;

use App\Fountain\AbstractElement;

class SectionHeading extends AbstractElement
{
    /**
     * If there aren't any preceding newlines, and there's a "!"
     * Additional action lines will be appended later.
     */
    public const REGEX = "/^(#{1,})\s/";

    public function match($line) {
       return preg_match(self::REGEX, trim($line));
    }

    public function depth($line) {
        // find the number of # (##, ###, etc.) and the text
        preg_match("/^\s*(#+)\s*(.*)/", $line, $matches);
        list ($raw, $depth, $text) = $matches;

        // convert depth to a number and compact into array
        return strlen($depth);
    }

    /**
     * Find and return the text without hashes
     */
    function sanitize($line)
    {
        // find the number of # (##, ###, etc.) and the text
        preg_match("/^\s*(#+)\s*(.*)/", $line, $matches);
        list ($raw, $depth, $text) = $matches;

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
     */
    function getHeadingDepth($text, $depth)
    {
        switch ($depth) {
            case 1:
                return '<h1>'.$text.'</h1>';
            case 2:
                return '<h2>'.$text.'</h2>';
            case 3:
                return '<h3>'.$text.'</h3>';
            case 4:
                return '<h4>'.$text.'</h4>';
            case 5:
                return '<h5>'.$text.'</h5>';
        }
    }

    public function render($line)
    {
        $depth = $this->depth($line);
        $text = $this->sanitize($line);
        $heading = $this->getHeadingDepth($text, $depth);
        // Section headings are ignored in the output
        return;
    }
}