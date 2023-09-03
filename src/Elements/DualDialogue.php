<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 * DualDialog
 * Check whether this is a dual dialog line,
 * this element is not included in the render list
 */
class DualDialogue extends Character implements ElementInterface
{
    /**
     *
     */
    public const REGEX = "/\^\s*$/";

    /**
     * @param string $line
     * @param ElementInterface|null $previousElement
     * @return bool
     */
    public function match(string $line, ?ElementInterface &$previousElement = null): bool
    {
        return boolval(preg_match(self::REGEX, $line));
    }

    /**
     * @param string $line
     * @return string
     */
    public function sanitize(string $line): string
    {
        // remove dual dialog mark
        $line = (string) preg_replace("/\^/i", "", $line);
        return trim($line);
    }
}
