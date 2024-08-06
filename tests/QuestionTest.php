<?php

declare(strict_types=1);

use ReturnEarly\Dns\Enums\TypeEnum;
use ReturnEarly\Dns\Question;

it('can get the name', function () {
    $question = new Question('example.com', TypeEnum::A);

    expect($question->getName())->toBe('example.com');
});

it('can get the fully qualified name', function () {
    $question = new Question('example.com...', TypeEnum::A);

    expect($question->getFullyQualifiedName())->toBe('example.com.');
});

it('can get the type', function () {
    $question = new Question('example.com', TypeEnum::A);

    expect($question->getType())->toBe(TypeEnum::A);
});

it('can convert to a Badcow Question', function () {
    $question = new Question('example.com', TypeEnum::A);

    $badcowQuestion = $question->toBadcowQuestion();

    expect($badcowQuestion->getName())->toBe('example.com.');
    expect($badcowQuestion->getType())->toBe('A');
    expect($badcowQuestion->getClass())->toBe('IN');
});

it('can use subdomains correctly as a question', function () {
    $question = new Question('_sip._tls.example.com', TypeEnum::SRV);

    $badcowQuestion = $question->toBadcowQuestion();

    expect($badcowQuestion->getName())->toBe('_sip._tls.example.com.');
    expect($badcowQuestion->getType())->toBe('SRV');
    expect($badcowQuestion->getClass())->toBe('IN');
});
