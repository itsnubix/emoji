<?php

enum TestEnum
{
    use Emoji\Traits\Enum;

    case one;
    case two;
    case three;
    case four;
    case five;
}


it('can get all of its names', function () {
    $cases = TestEnum::cases();
    $names = TestEnum::names();

    foreach ($cases as $case) {
        expect($case->name)->toBeIn($names);
    }
});

it('can create an enum from a given name string', function () {
    $cases = TestEnum::cases();

    foreach ($cases as $case) {
        $actual = TestEnum::fromName($case->name);
        expect($case)->toBe($actual);
    }
});

it('returns null if you try to create an enum from an invalid name', function () {
    expect(TestEnum::tryFromName('invalid-case'))->toBeNull();
});

it('throws if you use an invalid name without the try method', function () {
    TestEnum::fromName('invalid-case');
})->throws(ValueError::class);
