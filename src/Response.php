<?php

declare(strict_types=1);

namespace ReturnEarly\Dns;

use Badcow\DNS\Message;
use ReturnEarly\Dns\Enums\ResponseCodeEnum;
use ReturnEarly\Dns\Exceptions\BadResponseCodeException;

class Response
{
    protected Message $message;

    public function __construct(
        private ?string $binaryData = null,
    ) {}

    public static function fromBinaryBuffer(false|string $responseBuffer)
    {
        $class = new static;
        $class->setBinaryData($responseBuffer);

        return $class;
    }

    public function setBinaryData(string $binaryData): void
    {
        $this->binaryData = $binaryData;

        $this->parseBinaryResponse();
    }

    public function getBinaryData(): string
    {
        return $this->binaryData;
    }

    private function parseBinaryResponse(): void
    {
        $this->setMessage(Message::fromWire($this->binaryData));
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

    public function getQuestions(): array
    {
        return $this->message->getQuestions();
    }

    public function getAnswers(): array
    {
        return $this->message->getAnswers();
    }

    public function getResponseCode(): ResponseCodeEnum
    {
        return ResponseCodeEnum::fromValue($this->message->getRcode());
    }

    public function isSuccessful(): bool
    {
        return $this->getResponseCode()->isSuccessful();
    }

    public function isFailure(): bool
    {
        return $this->getResponseCode()->isFailure();
    }

    public function throw(): self
    {
        if ($this->isSuccessful()) {
            return $this;
        }

        throw BadResponseCodeException::fromResponseCode($this->getResponseCode());
    }
}
