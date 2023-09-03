<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 * Page Break
 * A standard HTML page break element
 */
class PageBreak extends AbstractElement implements ElementInterface
{
    /**
     *
     */
    public const REGEX = "/^(-{3,})|(={3,})\s*$/";

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
        return $line;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return '<hr />';
    }
}
