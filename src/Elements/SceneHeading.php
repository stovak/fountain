<?php

/** @noinspection SpellCheckingInspection */

namespace Fountain\Elements;

use Fountain\AbstractElement;
use Fountain\Illuminate\Str;

/**
 * Scene Heading
 * A Scene Heading is any line that has a blank line following it.
 */
class SceneHeading extends AbstractElement
{
    /**
     *
     */
    public const REGEX = '/^(INT|EXT|EST|I\\/??E)[\\.\\-\\s]/i';

    /**
     * @return string
     */
    public function __toString()
    {
        $text = $this->getText();
        $className = Str::kebab($this->getClass());

        // Scene headings can contain options numbers
        // Let's remove these and add them to the HTML element
        if (preg_match('/#.*#/i', $text, $numbering)) {
            $line = preg_replace('/#.*#/i', '', $text);
            $anchor = preg_replace('/#/i', '', $numbering[0]);

            return '<scene-heading class="'.$className.'" id="'.$anchor.'">'.$line.'</scene-heading>';
        }

        return '<scene-heading class="'.$className.'">'.trim($text).'</scene-heading>';
    }

    /**
     * @param $line
     * @return false|int
     */
    public function forcedHeading($line): false|int
    {
        return preg_match('/^\\.[^.]/', $line);
    }

    /**
     * @param $line
     * @return bool
     */
    public function match($line): bool
    {
        $forced_scene_heading = $this->forcedHeading($line);

        // strict headings allow all scene_headings
        // causes a conflict in french where sentences start with "Est-ce que c"
        // to fix this: prefix sentences with an exclamation point `!`
        $scene_heading = preg_match(self::REGEX, $line, $scene_heading_matches);

        return $forced_scene_heading || $scene_heading;
    }

    /**
     * @param $line
     * @return string
     */
    public function sanitize($line): string
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
