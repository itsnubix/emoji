<?php

use Emoji\Emoji;
use Emoji\Enums\SkinTone;

it('can resolve a skin tone from a string', function () {
    foreach (SkinTone::names() as $name) {
        expect(SkinTone::tryToResolve($name))->not->toBeNull();
    }
});

it('can resolve a skin tone from a callable', function () {
    foreach (SkinTone::names() as $name) {
        expect(SkinTone::tryToResolve(fn () => $name))->not->toBeNull();
    }
});

it('throws if an invalid tone is supplied to the resolve function', function () {
    SkinTone::resolve('invalid-tone');
})->throws(ValueError::class);
