<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 * Characters
 * Match CHARACTERS or any line starting with @
 * Allow indents and whitespace in the beginning
 */
class Character extends AbstractElement implements ElementInterface
{
    /**
     * @var bool
     */
    public bool $dual_dialog = false;

    /**
     *
     */
    public const REGEX = "/^((\s*)[A-Z@]((([^a-z`]+)(\s?\(.*\))?))|(@.+))$/";

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
        // (remove @ prefix)
        $line = trim($line, ' @');
        // remove parenthesis, this is added separately in the parser
        // response
        return preg_replace("/\(.*\)/i", "", $line);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            "<character %s>%s</character>",
            ($this->dual_dialog === true) ? 'dual="true"' : '',
            $this->getText()
        );
    }
}
