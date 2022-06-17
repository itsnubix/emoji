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

    public function __toString()
    {
        return $this->toString();
    }

    public function __call($method, $arguments)
    {
        if ($skinTone = SkinTone::fromName($method)) {
            return $this->setSkinTone($skinTone);
        }
    }

    public function toString(): string
    {
        $output = $this->character->value;

        if ($this->character->supportsSkinTones()) {
            $output .= $this->skinTone->value;
        }

        return $output;
    }

    public function setSkinTone(SkinTone $skinTone)
    {
        $this->skinTone = $skinTone;

        return $this;
    }
}