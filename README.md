# Emoji

Adds support for inserting and converting emojis into unicode in PHP. Uses enums and so requires PHP8.1 or higher.

## Installation

`composer require itsnubix/emoji`

## Usage

```php
use Emoji\Emoji;
use Emoji\SkinTone;

// Globally set skin tone for all applicable emojis
Emoji::setDefaultSkinTone(SkinTone::medium);

// Various methods for spitting out a unicode emoji
Emoji::get('grinning_face')->toString(); // returns 😀
(string) Emoji::grinning_face(); // returns 😀
echo Emoji::grinningFace(); // returns 😀

// Overwrite the default skin tone on the fly
Emoji::get('waving_hand', SkinTone::light)->toString(); // returns 👋🏻
Emoji::wavingHand()->light()->toString(); // returns 👋🏻
Emoji::wavingHand()->skinTone('light')->toString(); // returns 👋🏻

// Also supports dynamic skin tone selection with a callback
$user = new User(['preferred_skin_tone' => SkinTone::light])
Emoji::wavingHand()
  ->skinTone(fn() => $user->preferred_skin_tone)
  ->toString();

// You may also reset
```
