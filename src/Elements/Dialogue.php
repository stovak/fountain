<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 * Dialogue
 * Dialogue is any text following a Character or Parenthetical element.
 */
class Dialogue extends AbstractElement implements ElementInterface
{
    /**
     * @var bool
     */
    public bool $parseEmphasis = true;

    /**
     * @param string $line
     * @param ElementInterface|null &$previousElement
     * @return bool
     */
    public function match($line, ?ElementInterface &$previousElement = null): bool
    {
        if ($previousElement instanceof Character) {
            // if it's a parenthetical, it's not dialogue
            if (str_starts_with($line, "(")) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @param $line
     * @return string
     */
    public function sanitize($line): string
    {
        // Sometimes, you may really want to start normal dialogue with brackets,
        // you can prefix this with a backslash to override the parenthesis.
        return ltrim($line, '\\');
    }
}
