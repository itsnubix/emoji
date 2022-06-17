<?php

use Emoji\Emoji;
use Emoji\Factory;
use Emoji\Enums\SkinTone;
use Emoji\Enums\Character;
use function Pest\Faker\faker;

it('can get and set skin tones', function () {
    expect(Emoji::getDefaultSkinTone())->toBeNull();

    foreach (SkinTone::cases() as $skinTone) {
        Emoji::setDefaultSkinTone($skinTone);
        expect(Emoji::getDefaultSkinTone())->toBe($skinTone);
    }
});

it('can get an emoji from a name and return a factory', function () {
    foreach (Character::names() as $name) {
        $emoji = Emoji::get($name);
        expect($emoji)->toBeInstanceOf(Factory::class);
    }
});

it('returns null if an invalid emoji name is provided', function () {
    expect(Emoji::get('invalid-value'))->toBeNull();
});

it('forwards emoji names onto the get function if called statically', function () {
    foreach (Character::names() as $name) {
        $emoji = call_user_func(Emoji::class."::{$name}");
        expect($emoji)->toBeInstanceOf(Factory::class);
    }
});

it('replaces :emoji_names: in a string with their unicode values', function () {
    $string = preg_replace(
        $replacements = ['/\$1/', '/\$2/', '/\$3/', '/\$4/', '/\$5/'],
        $characters = faker()->randomElements(
            array_map(fn ($character) => $character->name, Character::cases()),
            count($replacements)
        ),
        "Lorem :$1: ipsum :$2: dolor :$3: sit :$4: amet",
    );

    expect(Emoji::replace($string))->not->toBe($string);
});

it('does not replace invalid :emoji_names: if there is no valid match', function () {
    $string = 'This string will contain :invalid_emojis: which will not be replaced.';

    expect(Emoji::replace($string))->toBe($string);
});
