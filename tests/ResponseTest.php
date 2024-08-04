<?php

declare(strict_types=1);

use Badcow\DNS\Message;
use Badcow\DNS\Question as BadcowQuestion;
use Badcow\DNS\Rdata\A;
use Badcow\DNS\ResourceRecord;
use ReturnEarly\Dns\Enums\ResponseCodeEnum;
use ReturnEarly\Dns\Exceptions\BadResponseCodeException;
use ReturnEarly\Dns\Response;

it('can set the message on a response', function () {
    $message = new Message;
    $message->setId(1);

    $response = new Response;
    $response->setMessage($message);

    expect($response->getMessage())->toBe($message);
});

it('can get the questions from a response', function () {
    $question = new BadcowQuestion;
    $question->setName('example.com.');
    $question->setType('A');

    $message = new Message;
    $message->setId(1);
    $message->addQuestion($question);

    $response = new Response;
    $response->setMessage($message);

    expect($response->getQuestions())->toBeArray();
    expect($response->getQuestions())->toBe([$message->getQuestions()[0]]);
});

it('can get the answers from a response', function () {
    $question = new BadcowQuestion;
    $question->setName('example.com.');
    $question->setType('A');

    $answer = new ResourceRecord;
    $answer->setName('example.com.');
    $rdata = new A;
    $rdata->setAddress('127.0.0.1');
    $answer->setRdata($rdata);

    $message = new Message;
    $message->setId(1);
    $message->addQuestion($question);
    $message->setAnswers([$answer]);

    $response = new Response;
    $response->setMessage($message);

    expect($response->getAnswers())->toBeArray();
    expect($response->getAnswers())->toBe([
        $message->getAnswers()[0],
    ]);
});

it('can check if a request is successful', function () {
    $message = new Message;
    $message->setId(1);
    $message->setRcode(ResponseCodeEnum::NOERROR->value);

    $response = new Response;
    $response->setMessage($message);

    expect($response->isSuccessful())->toBeTrue();
    expect($response->isFailure())->toBeFalse();
});

it('can check if a request is not successful', function () {
    $message = new Message;
    $message->setId(1);
    $message->setRcode(ResponseCodeEnum::NXDOMAIN->value);

    $response = new Response;
    $response->setMessage($message);

    expect($response->isSuccessful())->toBeFalse();
    expect($response->isFailure())->toBeTrue();
});

it('can get the binary data', function () {
    $response = new Response('binary data');

    expect($response->getBinaryData())->toBe('binary data');
});

it('can throw if response code is bad', function () {
    $this->expectException(BadResponseCodeException::class);

    $message = new Message;
    $message->setId(1);
    $message->setRcode(ResponseCodeEnum::NXDOMAIN->value);

    $response = new Response;
    $response->setMessage($message);
    $response->throw();
});

it('wont throw if response code is good', function () {
    $message = new Message;
    $message->setId(1);
    $message->setRcode(ResponseCodeEnum::NOERROR->value);

    $response = new Response;
    $response->setMessage($message);

    expect($response->isSuccessful())->toBeTrue();
    expect($response->throw())->toBe($response);
});
