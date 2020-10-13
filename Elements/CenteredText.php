<?php

namespace App\Fountain\Elements;

use App\Fountain\AbstractElement;

/**
 * Centered
 * Allow a single line of text to be centered
 */
class CenteredText extends AbstractElement
{
    public $shouldParseMarkdown = true;

    public const REGEX = "/^(\s+)?(>.*<)$/";

    public function match($line) {
       return preg_match(self::REGEX, trim($line));
    }

    public function sanitize($line)
    {
        // Find and return the text of the lyrics without > symbols <
        $line = trim($line);
        $text = substr($line, 1);               // (remove >)
        $text = substr($text, 0, -1);   // (remove <)
        return $text;
    }

    public function render($line)
    {
        return '<p class="text-center">'.$line.'</p>';
    }
}
