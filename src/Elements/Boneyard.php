<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;
use Fountain\Events\RenderEvent;

/**
 *
 */
class Boneyard extends AbstractElement implements ElementInterface
{
    /**
     *
     */
    public const REGEX = "/(^\/\*)|(\*\/\s*$)/";

    /**
     * @param string $line
     * @return string
     */
    public function sanitize(string $line): string
    {
        return (string) str_replace(array('/*', '*/'), '', $line);
    }

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
     * @return string
     */
    public function __toString(): string
    {
        $this->eventDispatcher->dispatch(new RenderEvent($this));
        // Boneyard is ignored in the output
        return sprintf('<!-- %s -->', $this->text);
    }
}
