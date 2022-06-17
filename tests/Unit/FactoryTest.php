<?php

use Emoji\Emoji;
use Emoji\Factory;
use Emoji\Enums\SkinTone;

use Emoji\Enums\Character;
use function Pest\Faker\faker;

it('can set a skin tone', function () {
    $emoji = new Factory(faker()->randomElement(
        array_filter(Character::cases(), fn ($character) => $character->supportsSkinTones())
    ));

    foreach (SkinTone::cases() as $skinTone) {
        $emoji->skinTone($skinTone);
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
        $supported->skinTone($skinTone);
        $unsupported->skinTone($skinTone);

        expect($supported->toString())->toContain($skinTone->value);
        expect($unsupported->toString())->not->toContain($skinTone->value);
    }
});

it('can transform itself to a string', function () {
    $emoji = new Factory($element = faker()->randomElement(Character::cases()));

    expect((string) $emoji)->toBe($element->value);
    expect($emoji->toString())->toBe($element->value);
});

it('can support a string to set the skin tone if it matches', function () {
    $emoji = new Factory(faker()->randomElement(
        array_filter(Character::cases(), fn ($character) => $character->supportsSkinTones())
    ));

    foreach (SkinTone::names() as $skinTone) {
        $emoji->skinTone($skinTone);
        expect($emoji->skinTone())->toBe(SkinTone::fromName($skinTone));
    }
});

it('can reset the skin tone', function () {
    $emoji = new Factory(faker()->randomElement(
        array_filter(Character::cases(), fn ($character) => $character->supportsSkinTones())
    ));

    $emoji->light();
    expect($emoji->skinTone())->toBe(SkinTone::light);
    $emoji->skinTone(null);
    expect($emoji->skinTone())->toBe(null);

    $emoji->medium();
    expect($emoji->skinTone())->toBe(SkinTone::medium);
    $emoji->toneless();
    expect($emoji->skinTone())->toBe(null);

    $emoji->dark();
    expect($emoji->skinTone())->toBe(SkinTone::dark);
    $emoji->skinTone(); // using it like this is a getter and shouldn't change it
    expect($emoji->skinTone())->toBe(SkinTone::dark);
});

it('can overwrite the global skin tone with a reset', function () {
    Emoji::setDefaultSkinTone('light');

    $emoji = Emoji::wavingHand();

    expect($emoji->skinTone())->toBe(SkinTone::light);

    $emoji->toneless();
    expect($emoji->skinTone())->toBeNull();
});
