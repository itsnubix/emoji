# Emoji

Adds support for inserting and converting emojis into unicode in PHP. Uses enums and so requires PHP8.1 or higher.

## Installation

`composer require itsnubix/emoji`

## Usage

Below you will find some usage examples.

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

// You may also remove tone from a given emoji as well.
$emoji = Emoji::wavingHand(SkinTone::medium);
$emoji->skinTone(); // get the skin tone, returns SkinTone::medium
$emoji->toneless()->skinTone(); // returns null

// Finally, you may replace emojis in a string where they match within
// two colons and align to an allowed emoji character. If invalid characters
// are used it just returns them without converting
Emoji::parse('Hello world :waving_hand: how are you :invalid_character:'); // returns "Hello world 👋" how are you :invalid_character:"

// You can set the skin tone for the parser globally with...
Emoji::setDefaultSkinTone(Emoji::light);
Emoji::parse('Hello world :waving_hand:'); // returns "Hello world 👋🏻"
```

For a full list of supported emojis and those that support adding skin tones view: [Character](/src/Enums/Character.php)

For a full list of skin tones view: [SkinTone](/src/Enums/SkinTone.php)

## Todo

- [x] Allow a user to select emojis
- [x] Allow a user to set skin tones
- [ ] Add support for all emoji skin tones
- [ ] Add support for changing skin tone when replacing a string
