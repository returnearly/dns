<?php

declare(strict_types=1);

use Badcow\DNS\Rdata\A;
use Badcow\DNS\Rdata\AAAA;
use Badcow\DNS\Rdata\CNAME;
use Badcow\DNS\Rdata\MX;
use ReturnEarly\Dns\Connection;
use ReturnEarly\Dns\Enums\TypeEnum;
use ReturnEarly\Dns\Query;
use ReturnEarly\Dns\Question;
use ReturnEarly\Dns\Response;

it('can query for a result', function (string $name, TypeEnum $type, string $expectedResponseClass) {
    $connection = new Connection('1.1.1.1');
    $question = new Question($name, $type);

    $query = new Query($question, $connection, allowRecursion: true);

    $response = $query->execute();

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->getQuestions())->toBeArray();
    expect($response->getAnswers())->toBeArray();
    expect(count($response->getAnswers()))->toBeGreaterThan(0);
    expect($response->getAnswers()[0]->getRdata())->toBeInstanceOf($expectedResponseClass);

})->with([
    ['zonewatcher-test.com', TypeEnum::A, A::class],
    ['zonewatcher-test.com', TypeEnum::AAAA, AAAA::class],
    ['autodiscover.zonewatcher-test.com', TypeEnum::CNAME, CNAME::class],
]);

it('can query for multiple MX records', function () {
    $connection = new Connection('1.1.1.1');
    $question = new Question('zonewatcher-test.com', TypeEnum::MX);

    $query = new Query($question, $connection, allowRecursion: true);

    $response = $query->execute();

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->getQuestions())->toBeArray();
    expect($response->getAnswers())->toBeArray();
    expect(count($response->getAnswers()))->toBe(2);
    foreach ($response->getAnswers() as $key => $answer) {
        expect($answer->getRdata())->toBeInstanceOf(MX::class);
        $num = $key + 1;
        expect($answer->getRdata()->getExchange())->toBe("mx$num.zonewatcher-test.com.");
    }
});
