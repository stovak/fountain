<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 * Synopses
 * You create a Synopsis by starting with a line with a equal sign =.
 * These are optional blocks of text to describe a Section or scene.
 *
 * Synopses are used to highlight group questions or overviews of a session.
 * Although this element may appear at any position in the text, we shall
 * mark up this text different if it appears at the beginning of a file.
 */
class Synopsis extends AbstractElement implements ElementInterface
{
    /**
     * @var bool
     */
    public bool $parseEmphasis = true;
    /**
     * @var bool
     */
    public bool $first;

    /**
     *
     */
    public const REGEX = "/^=\s/";

    /**
     * @param string $line
     * @param ElementInterface|null &$previousElement
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
        preg_match("/^\s*={1}(.*)/", $line, $matches);
        return isset($matches[1]) ? trim($matches[1]) : '';
    }

}
