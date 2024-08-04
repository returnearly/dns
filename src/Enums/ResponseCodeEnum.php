<?php

declare(strict_types=1);

namespace ReturnEarly\Dns\Enums;

use ReturnEarly\LaravelEnums\EnumHelpers;
use ValueError;

enum ResponseCodeEnum: int
{
    use EnumHelpers;

    case NOERROR = 0;
    case FORMERR = 1;
    case SERVFAIL = 2;
    case NXDOMAIN = 3;
    case NOTIMP = 4;
    case REFUSED = 5;
    case YXDOMAIN = 6;
    case YXRRSET = 7;
    case NXRRSET = 8;
    case NOTAUTH = 9;
    case NOTZONE = 10;
    case BADVERS = 16;
    case BADKEY = 17;
    case BADTIME = 18;
    case BADMODE = 19;
    case BADNAME = 20;
    case BADALG = 21;
    case BADTRUNC = 22;
    case BADCOOKIE = 23;

    public function getDescription(): string
    {
        return match ($this) {
            self::NOERROR => 'No Error',
            self::FORMERR => 'Format Error',
            self::SERVFAIL => 'Server Failure',
            self::NXDOMAIN => 'Non-Existent Domain',
            self::NOTIMP => 'Not Implemented',
            self::REFUSED => 'Query Refused',
            self::YXDOMAIN => 'Name Exists when it should not',
            self::YXRRSET => 'RR Set Exists when it should not',
            self::NXRRSET => 'RR Set that should exist does not',
            self::NOTAUTH => 'Not Authorized',
            self::NOTZONE => 'Name not contained in zone',
            self::BADVERS => 'Bad OPT Version',
            self::BADKEY => 'Key not recognized',
            self::BADTIME => 'Signature out of time window',
            self::BADMODE => 'Bad TKEY Mode',
            self::BADNAME => 'Duplicate key name',
            self::BADALG => 'Algorithm not supported',
            self::BADTRUNC => 'Bad Truncation',
            self::BADCOOKIE => 'Bad/missing Server Cookie',
        };
    }

    public static function fromRCode(int $code): self
    {
        return self::fromValue($code);
    }

    public static function fromName(string $name): self
    {
        foreach (self::cases() as $case) {
            if ($case->name === strtoupper($name)) {
                return $case;
            }
        }

        throw new ValueError("Unknown response code: $name");
    }

    public function isSuccessful(): bool
    {
        return $this->is(self::NOERROR);
    }

    public function isFailure(): bool
    {
        return ! $this->isSuccessful();
    }
}
