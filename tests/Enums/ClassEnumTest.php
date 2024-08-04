<?php

declare(strict_types=1);

use ReturnEarly\Dns\Enums\ClassEnum;

it('can get the class id', function (ClassEnum $enum, int $code) {
    expect($enum->toClassId())->toBe($code);
})->with([
    [ClassEnum::INTERNET, 1],
    [ClassEnum::CSNET, 2],
    [ClassEnum::CHAOS, 3],
    [ClassEnum::HESIOD, 4],
]);
