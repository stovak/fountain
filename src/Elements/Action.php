<?php

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;

/**
 * Action
 * An action element that is not dialog: when a character performs an action
 * We only mark-up Actions if they are prefixed with an exclamation point !
 *
 * WARNING: Action was the default type in Fountain, however this
 *          has been replaced with Dialogue for our use case.
 */
class Action extends AbstractElement implements ElementInterface
{
    /**
     * @var bool
     */
    public bool $parseEmphasis = true;

    /**
     *
     */
    public const REGEX = "/^!/";

    /**
     * @param $line
     * @param ElementInterface|null $previousElement
     * @return bool
     */
    public function match($line, ?ElementInterface &$previousElement = null): bool
    {
        return boolval(preg_match(self::REGEX, trim($line)));
    }

    /**
     * @param $line
     * @return string
     */
    public function sanitize($line): string
    {
        // Find and return the text of the action without !
        preg_match("/^\s*!{1}(.*)/", $line, $matches);
        return count($matches) ? trim($matches[1]) : trim($line);
    }
}
