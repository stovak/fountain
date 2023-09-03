<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 * Notes
 * A Note is created by enclosing some text with [[ double brackets ]].
 * Notes can be inserted between lines, or in the middle of a line.
 *
 * These can be used in translations when we need to keep track of changes,
 * or provide suggestions for translations that may not be 100% correct.
 * These will not be show on the website.
 */
class Notes extends AbstractElement implements ElementInterface
{
    /**
     * @var bool
     */
    public bool $parseEmphasis = true;
    /**
     *
     */
    public const REGEX = "/^\s*\[{2}\s*([^\]\n])+\s*\]{2}\s*$/";

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
        return trim((string)str_replace(array('[[', ']]'), '', $line));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return '<notes><em>['.$this->getText().']</em></notes>';
    }
}
