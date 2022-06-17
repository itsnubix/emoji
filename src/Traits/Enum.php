<?php

namespace Emoji\Traits;

use ValueError;

trait Enum
{
    /**
     * Return all the case names that are available for
     * a given enum
     *
     * @return array
     */
    public static function names(): array
    {
        return array_map(fn ($case) => $case->name, static::cases());
    }

    /**
     * Tries to return a case from the given name or
     * returns null if no matches
     *
     * @param string $name
     * @return null|self
     */
    public static function tryFromName(string $name)
    {
        foreach (static::cases() as $case) {
            if ($name === $case->name) {
                return $case;
            }
        }

        return null;
    }

    /**
     * Return a case from the given name or throw a
     * value error if no matches
     *
     * @param  string  $name
     * @return self
     * @throws ValueError
     */
    public static function fromName(string $name)
    {
        if ($case = static::tryFromName($name)) {
            return $case;
        }

        throw new ValueError;
    }
}
