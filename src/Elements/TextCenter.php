<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 * Centered Text
 * Allow a single line of text to be centered
 */
class TextCenter extends AbstractElement implements ElementInterface
{
    /**
     * @var bool
     */
    public bool $parseEmphasis = true;

    /**
     *
     */
    public const REGEX = "/^(\s+)?(>.*<)$/";

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
     * @return string
     */
    public function sanitize(string $line): string
    {
        // Find and return the text of the lyrics without > symbols <
        return trim($line, ' <>');

    }
}
