<?php

declare(strict_types=1);

namespace ReturnEarly\Dns;

use Badcow\DNS\Message;

class Response
{
    protected Message $message;

    public function __construct(
        private readonly string $binaryData,
    ) {
        $this->parseBinaryResponse();
    }

    public function getBinaryData(): string
    {
        return $this->binaryData;
    }

    private function parseBinaryResponse(): void
    {
        $this->message = Message::fromWire($this->binaryData);
    }

    public function getQuestions(): array
    {
        return $this->message->getQuestions();
    }

    public function getAnswers(): array
    {
        return $this->message->getAnswers();
    }
}
