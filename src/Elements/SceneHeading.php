<?php

/** @noinspection SpellCheckingInspection */

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\ElementInterface;
use Fountain\Illuminate\Str;

/**
 * Scene Heading
 * A Scene Heading is any line that has a blank line following it.
 */
class SceneHeading extends AbstractElement implements ElementInterface
{
    /**
     *
     */
    public const REGEX = '/^(INT|EXT|EST|I\\/??E)[\\.\\-\\s]/i';

    /**
     * @return string
     */
    public function __toString(): string
    {
        $text = $this->getText();
        $className = Str::kebab($this->getClass());

        // Scene headings can contain options numbers
        // Let's remove these and add them to the HTML element
        if (preg_match('/#.*#/i', $text, $numbering)) {
            $line = preg_replace('/#.*#/i', '', $text);
            $anchor = preg_replace('/#/i', '', $numbering[0]);

            return '<scene-heading class="' . $className . '" id="' . $anchor . '">' . $line . '</scene-heading>';
        }

        return '<scene-heading class="' . $className . '">' . trim($text) . '</scene-heading>';
    }

    /**
     * @param string $line
     * @return bool
     */
    public function forcedHeading(string $line): bool
    {
        return boolval(preg_match('/^\\.[^.]/', $line));
    }

    /**
     * @param string $line
     * @param ElementInterface|null &$previousElement
     * @return bool
     */
    public function match(string $line, ?ElementInterface &$previousElement = null): bool
    {

        // strict headings allow all scene_headings
        // causes a conflict in french where sentences start with "Est-ce que c"
        // to fix this: prefix sentences with an exclamation point `!`
        $scene_heading = preg_match(self::REGEX, $line, $scene_heading_matches);

        return $this->forcedHeading($line) || boolval($scene_heading);
    }

    /**
     * @param string $line
     * @return string
     */
    public function sanitize(string $line): string
    {
        // remove the prefix
        if ($this->forcedHeading($line)) {
            $prefix_length = 1;
        } else {
            // you can optionally remove the prefix INT or EXT with:
            // $prefix_length = strlen($scene_heading_matches[0]);
            $prefix_length = 0;
        }

        $line_without_prefix = substr($line, $prefix_length);

        return trim($line_without_prefix);
    }
}
