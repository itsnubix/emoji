<?php

namespace Emoji\Enums;

use Emoji\Traits\Enum;

enum SkinTone: string
{
    use Enum;

    case light = "\u{1F3FB}";
    case mediumLight = "\u{1F3FC}";
    case medium = "\u{1F3FD}";
    case mediumDark = "\u{1F3FE}";
    case dark = "\u{1F3FF}";
}
