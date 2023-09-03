<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 * Lyrics
 * You create a Lyric by starting with a line with a tilde ~.
 */
class Lyrics extends AbstractElement implements ElementInterface
{
    /**
     *
     */
    public const REGEX = "/^(\s+)?~.*/";

    /**
     * @param $line
     * @param ElementInterface|null $previousElement
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
        // Find and return the text of the lyrics without ~
        preg_match("/^(\s*)?~{1}(.*)/", trim($line), $matches);
        return isset($matches[2]) ? trim($matches[2]) : '';
    }
}
