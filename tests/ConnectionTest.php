<?php

declare(strict_types=1);

use ReturnEarly\Dns\Connection;
use ReturnEarly\Dns\Exceptions\ConnectionException;

it('can set the connection details', function () {
    $connection = new Connection(
        host: '1.1.1.1',
        port: 53,
        timeout: 15,
        udp: true,
    );

    expect($connection->getHost())->toBe('1.1.1.1');
    expect($connection->getPort())->toBe(53);
    expect($connection->getTimeout())->toBe(15);
    expect($connection->isUdp())->toBeTrue();
    expect($connection->getUri())->toBe('udp://1.1.1.1');
});

it('can use tcp for the connection', function () {
    $connection = new Connection(
        host: '1.1.1.1',
        udp: false,
    );

    expect($connection->isUdp())->toBeFalse();
    expect($connection->getUri())->toBe('tcp://1.1.1.1');
});

it('can connect to a public dns resolver', function (bool $useUdp) {
    $connection = new Connection(
        host: '1.1.1.1',
        port: 53,
        timeout: 5,
        udp: $useUdp,
    );

    $connection->openSocket();

    expect($connection->getSocket())->toBeResource();
})->with([
    true,
    false,
])->group('external-connection');

it('cannot connect to a nonexistant server and throws', function () {
    $this->expectException(ConnectionException::class);

    $connection = new Connection(
        host: '127.0.0.1',
        port: 9876,
        timeout: 1,
        udp: false,
    );

    $connection->openSocket();

    expect($connection->getSocket())->toBeFalse();
});

it('can reuse an existing socket', function () {
    $connection = new Connection(
        host: '1.1.1.1',
        port: 53,
        timeout: 5,
        udp: true,
    );

    $connection->openSocket();

    $socketId = get_resource_id($connection->getSocket());

    $connection->openSocket();

    expect(get_resource_id($connection->getSocket()))->toBe($socketId);
});
