<?php

namespace Emoji\Enums;

use Emoji\Traits\Enum;

enum Character: string
{
    use Enum;

    /**
     * Faces
     */
    case grinning_face = "\u{1F600}";
    case grinning_face_with_big_eyes = "\u{1F603}";
    case grinning_face_with_smiling_eyes = "\u{1F604}";
    case beaming_face_with_smiling_eyes = "\u{1F601}";
    case wave = "\u{1F44B}";

    public function supportsSkinTones(): bool
    {
        return match ($this) {
            Character::wave => true,
            default => false
        };
    }
}
