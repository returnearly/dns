<?php

declare(strict_types=1);

namespace ReturnEarly\Dns\Exceptions;

use Exception;
use ReturnEarly\Dns\Enums\ResponseCodeEnum;

class BadResponseCodeException extends Exception
{
    public static function fromResponseCode(ResponseCodeEnum $code): self
    {
        return new self(
            "Response code was {$code->name}({$code->value})",
            $code->value
        );
    }
}
