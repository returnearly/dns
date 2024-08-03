<?php

declare(strict_types=1);

namespace ReturnEarly\Dns;

use Badcow\DNS\Message;

class Query
{
    public final const int OPCODE_QUERY = 0;

    public function __construct(
        private readonly Question $question,
        private readonly Connection $connection,
        private readonly bool $allowRecursion = true,
        private readonly int $tries = 1,
        private readonly int $triesDelay = 100,
    ) {}

    public function execute(): Response
    {
        return retry($this->tries, function (): Response {
            $this->connection->openSocket();

            $binaryData = $this->makeMessage()->toWire();

            fwrite($this->connection->getSocket(), $binaryData);

            $responseBuffer = fread($this->connection->getSocket(), 4096);

            return new Response($responseBuffer);
        }, sleepMilliseconds: $this->triesDelay);
    }

    private function makeMessage(): Message
    {
        $message = new Message;
        $message->setId($this->generateId());
        $message->setRecursionDesired($this->allowRecursion);
        $message->setOpcode(self::OPCODE_QUERY);
        $message->addQuestion($this->question->toBadcowQuestion());

        return $message;
    }

    private function generateId(): int
    {
        return rand(1, 255) | (rand(0, 255) << 8);
    }
}
