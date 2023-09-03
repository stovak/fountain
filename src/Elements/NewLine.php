<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;
use Fountain\Events\RenderEvent;

/**
 *
 */
class NewLine extends AbstractElement implements ElementInterface
{
    /**
     *
     */
    public const REGEX = "/^\s*$/";

    /**
     * @param string $line
     * @param ElementInterface|null $previousElement
     * @return bool
     */
    public function match(string $line, ?ElementInterface &$previousElement = null): bool
    {
        if (trim($line) === "") {
            return true;
        }
        return boolval(preg_match(self::REGEX, $line));
    }

    /**
     * @param string $line
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
        $this->eventDispatcher->dispatch(new RenderEvent($this));
        return PHP_EOL;
    }
}
