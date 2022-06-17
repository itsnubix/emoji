<?php

namespace Emoji;

use Emoji\Enums\SkinTone;
use Emoji\Enums\Character;

class Emoji
{
    /**
     * The default skinTone to use for emojis if it is available.
     *
     * @var null|string
     */
    protected static ?SkinTone $skinTone = null;

    /**
     * Forward undefined static calls onto the get method so you
     * can print emojis like: Emoji::wave()
     *
     * @param  string  $method
     * @param  mixed  $arguments
     * @return null|\Emoji\Emoji
     */
    public static function __callStatic($method, $arguments)
    {
        return call_user_func(static::class.'::get', $method, ...$arguments);
    }

    /**
     * Get the global skin tone.
     *
     * @return \Emoji\Enums\SkinTone
     */
    public static function getDefaultSkinTone()
    {
        return static::$skinTone;
    }

    /**
     * Set the global skin tone.
     *
     * @param  \Emoji\Enums\SkinTone  $skinTone
     * @return void
     */
    public static function setDefaultSkinTone(SkinTone $skinTone): void
    {
        static::$skinTone = $skinTone;
    }

    /**
     * Get the given symbol and convert it to an Emoji class which can then
     * be used to render as a string. Allow a user to overwrite the global
     * skin tone if required.
     *
     * @param  string  $key
     * @param  null|SkinTone  $skinTone
     * @return null|\Emoji\Factory
     */
    public static function get(string $name, ?SkinTone $skinTone = null): ?Factory
    {
        // check if emoji exists
        if (! $emoji = Character::tryFromName($name)) {
            return null;
        }

        return new Factory($emoji, $skinTone ?? static::$skinTone);
    }

    /**
     * Replaces with unicode anywhere where it matches emojis in a given string
     * within a format of :emoji_name:. If a match cannot be found it will not
     * replace the value within the colons.
     *
     * @param  string  $haystack
     * @return string
     */
    public static function replace(string $haystack): string
    {
        return preg_replace_callback(
            '/:[\s\S]*?:/i',
            fn ($matches) => static::get(trim($matches[0], ':'))?->toString() ?? $matches[0],
            $haystack
        );
    }
}
