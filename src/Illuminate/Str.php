<?php

namespace Fountain\Illuminate;

/**
 * Extracting method from Illuminate/Support
 * https://github.com/illuminate/support
 */
class Str
{
    /**
     * The cache of snake-cased words.
     *
     * @var array
     */
    protected static array $snakeCache = [];

    /**
     * Convert the given string to lower-case.
     *
     * @param  string  $value
     * @return string
     */
    public static function lower($value): string
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Convert a string to snake case.
     *
     * @param  string  $value
     * @param  string  $delimiter
     * @return string
     */
    public static function snake($value, $delimiter = '_'): string
    {
        $key = $value;

        if (isset(static::$snakeCache[$key][$delimiter])) {
            return static::$snakeCache[$key][$delimiter];
        }

        if (! ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value));
        }

        return static::$snakeCache[$key][$delimiter] = $value;
    }

    /**
     * Convert a string to kebab case.
     *
     * @param  string  $value
     * @return string
     */
    public static function kebab($value): string
    {
        return static::snake($value, '-');
    }

}
