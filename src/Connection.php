<?php

declare(strict_types=1);

namespace ReturnEarly\Dns;

use ReturnEarly\Dns\Exceptions\ConnectionException;

class Connection
{
    /**
     * @var false|null
     */
    protected $socket = null;

    public function __construct(
        private string $host,
        private int $port = 53,
        private int $timeout = 15,
        private bool $udp = true,
    ) {}

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function isUdp(): bool
    {
        return $this->udp;
    }

    public function getUri(): string
    {
        return ($this->isUdp() ? 'udp' : 'tcp').'://'.$this->getHost();
    }

    /**
     * @return resource
     */
    public function openSocket(): void
    {
        if (is_resource($this->socket)) {
            return;
        }

        set_error_handler(function () {}); // Suppress warnings

        $this->socket = fsockopen(
            $this->getUri(),
            $this->getPort(),
            $errorCode,
            $errorMessage,
            $this->getTimeout(),
        );

        restore_error_handler(); // Restore warnings

        if ($this->socket === false || $errorCode !== 0) {
            throw new ConnectionException($errorMessage, $errorCode);
        }

        stream_set_timeout($this->socket, $this->getTimeout());
    }

    /**
     * @return false|resource
     */
    public function getSocket()
    {
        return $this->socket;
    }

    public function closeSocket(): void
    {
        if (is_resource($this->socket)) {
            fclose($this->socket);
        }
    }

    public function __destruct()
    {
        $this->closeSocket();
    }
}
