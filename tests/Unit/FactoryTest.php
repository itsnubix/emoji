<?php

use Emoji\Factory;
use Emoji\Enums\SkinTone;

use Emoji\Enums\Character;
use function Pest\Faker\faker;

it('can set a skin tone', function () {
    $emoji = new Factory(faker()->randomElement(
        array_filter(Character::cases(), fn ($character) => $character->supportsSkinTones())
    ));

    foreach (SkinTone::cases() as $skinTone) {
        $emoji->setSkinTone($skinTone);
        expect($emoji->toString())->toContain($skinTone->value);
    }
});

it('forwards skin tone calls to on methods to set the skin tone', function () {
    $emoji = new Factory(faker()->randomElement(
        array_filter(Character::cases(), fn ($character) => $character->supportsSkinTones())
    ));

    foreach (SkinTone::cases() as $skinTone) {
        $emoji->{$skinTone->name}();
        expect($emoji->toString())->toContain($skinTone->value);
    }
});

it('adds a skin tone if the character supports it', function () {
    $supported = new Factory(faker()->randomElement(
        array_filter(Character::cases(), fn ($character) => $character->supportsSkinTones())
    ));
    $unsupported = new Factory(faker()->randomElement(
        array_filter(Character::cases(), fn ($character) => ! $character->supportsSkinTones())
    ));

    foreach (SkinTone::cases() as $skinTone) {
        $supported->setSkinTone($skinTone);
        $unsupported->setSkinTone($skinTone);

        expect($supported->toString())->toContain($skinTone->value);
        expect($unsupported->toString())->not->toContain($skinTone->value);
    }
});

it('can transform itself to a string', function () {
    $emoji = new Factory($element = faker()->randomElement(Character::cases()));

    expect((string) $emoji)->toBe($element->value);
    expect($emoji->toString())->toBe($element->value);
});

it('checks each character to ensure a skin tone can be applied', function () {
    $tonedCharacters = array_filter(Character::cases(), fn ($case) => $case->supportsSkinTones());

    foreach ($tonedCharacters as $character) {
        echo (new Factory($character))->dark()->toString() . "\n";
    }
});
