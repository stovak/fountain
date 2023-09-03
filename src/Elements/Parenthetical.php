<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 * Parenthetical
 * These follow a Character or Dialogue element, and are wrapped in ().
 *
 * These are useful to describe what is happening behind the scenes,
 * for example: (Cough.) (Inaudible) (Tape ends.)
 */
class Parenthetical extends AbstractElement implements ElementInterface
{
    /**
     *
     */
    public const REGEX = "/^\s*\(/";

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
        return trim($line, " ()");
    }
}
