<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 *
 */
class Transition extends AbstractElement implements ElementInterface
{
    /**
     *
     */
    public const REGEX = "/^(\s+)?>.*/";

    /**
     * @var array|string[]
     */
    protected array $transitions = [
        'CUT TO:',
        'FADE OUT.',
        'SMASH CUT TO:',
        'CUT TO BLACK.',
        'MATCH CUT TO:',
    ];

    /**
     * @param string $line
     * @param ElementInterface|null $previousElement
     * @return bool
     */
    public function match(string $line, ?ElementInterface &$previousElement = null): bool
    {
        if (in_array(trim($line), $this->transitions)) {
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
        return ltrim($line, '>');
    }
}
