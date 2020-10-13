<?php

namespace App\Fountain\Elements;

use App\Fountain\AbstractElement;

/**
 * Synopses
 * You create a Synopsis by starting with a line with a equal sign =.
 * These are optional blocks of text to describe a Section or scene.
 *
 * Synopses are used to highlight group questions or overviews of a session.
 * Although this element may appear at any position in the text, we shall
 * mark up this text different if it appears at the beginning of a file.
 */
class Synopsis extends AbstractElement
{
    public $shouldParseMarkdown = true;

    /**
     * If there aren't any preceding newlines, and there's a "!"
     * Additional action lines will be appended later.
     */
    public const REGEX = "/^=\s/";

    public function match($line) {
       return preg_match(self::REGEX, trim($line));
    }

    /**
     * Find and return the text of the synopsis without =
     */
    function sanitize($line)
    {
        preg_match("/^\s*={1}(.*)/", $line, $matches);
        return trim($matches[1]);
    }

    public function render($line)
    {
        $synopsis = '<p class="synopsis">'.$line.'</p>';
        // Synopsis are ignored in the output
        return;
    }
}