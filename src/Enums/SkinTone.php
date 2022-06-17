<?php

namespace Emoji\Enums;

use ValueError;
use Emoji\Traits\Enum;

enum SkinTone: string
{
    use Enum;

    /**
     * Available skin tones
     *
     * @see https://unicode.org/emoji/charts/full-emoji-modifiers.html
     */
    case light = "\u{1F3FB}";
    case mediumLight = "\u{1F3FC}";
    case medium = "\u{1F3FD}";
    case mediumDark = "\u{1F3FE}";
    case dark = "\u{1F3FF}";

    /**
     * Attempt to resolve the given value into a defined skin tone
     * and throw if no match found.
     *
     * @param  null|string|callable|SkinTone  $skinTone
     * @return \Emoji\Enums\SkinTone
     * @throws ValueError
     */
    public static function resolve(string | callable | SkinTone $skinTone)
    {
        if ($skinTone = static::tryToResolve($skinTone)) {
            return $skinTone;
        }

        throw new ValueError;
    }

    /**
     * Attempt to resolve the given value into a defined skin tone.
     *
     * @param  string|callable|SkinTone  $skinTone
     * @return null|\Emoji\Enums\SkinTone
     */
    public static function tryToResolve(null | string | callable | SkinTone $skinTone)
    {
        if (is_string($skinTone)) {
            $skinTone = SkinTone::fromName($skinTone);
        }

        if (is_callable($skinTone)) {
            $skinTone = static::resolve($skinTone());
        }

        if ($skinTone instanceof SkinTone) {
            return $skinTone;
        }

        return null;
    }
}
