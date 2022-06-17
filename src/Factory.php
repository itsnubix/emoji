<?php

namespace Emoji;

use Emoji\Enums\SkinTone;
use Emoji\Enums\Character;

class Factory
{
    public function __construct(protected Character $character, protected ?SkinTone $skinTone = null)
    {
        //
    }

    /**
     * When collapsing to string, return the appropriate value
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Forward calls onto the set skin tone function
     *
     * @param  string  $method
     * @param  mixed  $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if ($skinTone = SkinTone::fromName($method)) {
            return $this->skinTone($skinTone);
        }
    }

    /**
     * Get/set the skin tone for the given emoji
     *
     * @param  null|string|callable|SkinTone  $skinTone
     * @return mixed
     */
    public function skinTone($skinTone = null)
    {
        if (func_num_args() === 0) {
            return $this->skinTone;
        }

        if (!is_null($skinTone) && $skinTone = SkinTone::tryToResolve($skinTone)) {
            $this->skinTone = $skinTone;
        } else {
            $this->skinTone = null;
        }

        return $this;
    }

    /**
     * Removes the skin tone data from the factory
     *
     * @return self
     */
    public function toneless(): self
    {
        $this->skinTone(null);

        return $this;
    }

    /**
     * Transfer the emoji to a string
     *
     * @return string
     */
    public function toString(): string
    {
        $output = $this->character->value;

        // if the character supports a skin tone...
        if ($this->skinTone && $this->character->supportsSkinTones()) {
            $output .= $this->skinTone->value;
        }

        return $output;
    }
}
