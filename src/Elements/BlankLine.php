<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 *
 */
class BlankLine extends AbstractElement implements ElementInterface
{
    /**
     *
     */
    public const REGEX = "/^(\s{2,})$/";

    /**
     * @param string $line
     * @param ElementInterface|null &$previousElement
     * @return bool
     */
    public function match(string $line, ?ElementInterface &$previousElement = null): bool
    {
        return boolval(preg_match(self::REGEX, $line));
    }

    /**
     * @param $line
     * @return string
     */
    public function sanitize(string $line): string
    {
        return PHP_EOL;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return PHP_EOL;
    }
}
