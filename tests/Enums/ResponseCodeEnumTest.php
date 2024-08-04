<?php

declare(strict_types=1);

use ReturnEarly\Dns\Enums\ResponseCodeEnum;

it('can detect determine if a code is successful', function (ResponseCodeEnum $code) {
    expect($code->isSuccessful())->toBe($code->is(ResponseCodeEnum::NOERROR));
})->with(ResponseCodeEnum::collection());

it('can determine if a code is a form of error', function (ResponseCodeEnum $code) {
    expect($code->isFailure())->toBe($code->isNot(ResponseCodeEnum::NOERROR));
})->with(ResponseCodeEnum::collection());

it('can turn a string into an enum', function (string $input, ResponseCodeEnum $enum) {
    expect(ResponseCodeEnum::fromName($input))->toBe($enum);
})->with([
    ['NOERROR', ResponseCodeEnum::NOERROR],
    ['FORMERR', ResponseCodeEnum::FORMERR],
    ['SERVFAIL', ResponseCodeEnum::SERVFAIL],
    ['NXDOMAIN', ResponseCodeEnum::NXDOMAIN],
    ['NOTIMP', ResponseCodeEnum::NOTIMP],
    ['REFUSED', ResponseCodeEnum::REFUSED],
    ['YXDOMAIN', ResponseCodeEnum::YXDOMAIN],
    ['YXRRSET', ResponseCodeEnum::YXRRSET],
    ['NXRRSET', ResponseCodeEnum::NXRRSET],
    ['NOTAUTH', ResponseCodeEnum::NOTAUTH],
    ['NOTZONE', ResponseCodeEnum::NOTZONE],
    ['BADVERS', ResponseCodeEnum::BADVERS],
    ['BADKEY', ResponseCodeEnum::BADKEY],
    ['BADTIME', ResponseCodeEnum::BADTIME],
    ['BADMODE', ResponseCodeEnum::BADMODE],
    ['BADNAME', ResponseCodeEnum::BADNAME],
    ['BADALG', ResponseCodeEnum::BADALG],
    ['BADTRUNC', ResponseCodeEnum::BADTRUNC],
    ['BADCOOKIE', ResponseCodeEnum::BADCOOKIE],
]);

it('will throw an exception if you try to use a name that doesnt exist', function () {
    $this->expectException(ValueError::class);

    ResponseCodeEnum::fromName('INVALID');
});

it('has a description for every case', function (ResponseCodeEnum $enum) {
    expect($enum->getDescription())->not->toBeEmpty();
})->with(ResponseCodeEnum::collection());

it('can turn an rcode into an enum', function (int $code, ResponseCodeEnum $enum) {
    expect(ResponseCodeEnum::fromRCode($code))->toBe($enum);
})->with([
    [0, ResponseCodeEnum::NOERROR],
    [1, ResponseCodeEnum::FORMERR],
    [2, ResponseCodeEnum::SERVFAIL],
    [3, ResponseCodeEnum::NXDOMAIN],
    [4, ResponseCodeEnum::NOTIMP],
    [5, ResponseCodeEnum::REFUSED],
    [6, ResponseCodeEnum::YXDOMAIN],
    [7, ResponseCodeEnum::YXRRSET],
    [8, ResponseCodeEnum::NXRRSET],
    [9, ResponseCodeEnum::NOTAUTH],
    [10, ResponseCodeEnum::NOTZONE],
    [16, ResponseCodeEnum::BADVERS],
    [17, ResponseCodeEnum::BADKEY],
    [18, ResponseCodeEnum::BADTIME],
    [19, ResponseCodeEnum::BADMODE],
    [20, ResponseCodeEnum::BADNAME],
    [21, ResponseCodeEnum::BADALG],
    [22, ResponseCodeEnum::BADTRUNC],
    [23, ResponseCodeEnum::BADCOOKIE],
]);
