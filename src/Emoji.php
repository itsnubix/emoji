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
        return call_user_func(static::class.'::get', static::normalizeEmojiName($method), ...$arguments);
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
     * @param  null|string|callable|\Emoji\Enum\SkinTone  $skinTone
     * @return void
     */
    public static function setDefaultSkinTone($skinTone): void
    {
        static::$skinTone = SkinTone::resolve($skinTone);
    }

    /**
     * Get the given symbol and convert it to an Emoji class which can then
     * be used to render as a string. Allow a user to overwrite the global
     * skin tone if required.
     *
     * @param  string  $key
     * @param  null|string|callable|SkinTone  $skinTone
     * @return null|\Emoji\Factory
     */
    public static function get(string $name, $skinTone = null): ?Factory
    {
        // check if emoji exists
        if (! $emoji = Character::tryFromName($name)) {
            return null;
        }

        return new Factory($emoji, SkinTone::tryToResolve($skinTone) ?? static::getDefaultSkinTone());
    }

    /**
     * Replaces with unicode anywhere where it matches emojis in a given string
     * within a format of :emoji_name:. If a match cannot be found it will not
     * replace the value within the colons.
     *
     * @param  string  $haystack
     * @return string
     */
    public static function parse(string $haystack): string
    {
        return preg_replace_callback(
            '/:[\s\S]*?:/i',
            fn ($matches) => static::get(trim($matches[0], ':'))?->toString() ?? $matches[0],
            $haystack
        );
    }

    /**
     * Normalize the name of an emoji into snake_case
     *
     * @param string $name
     * @return string
     */
    protected static function normalizeEmojiName(string $name): string
    {
        if (!\ctype_lower($name)) {
            $name = (string) \preg_replace('/\s+/u', '', \ucwords($name));
            $name = (string) \mb_strtolower(\preg_replace(
                '/(.)(?=[A-Z])/u',
                '$1' . ($delimiter ?? '_'),
                $name
            ));
        }

        return $name;
    }
}
