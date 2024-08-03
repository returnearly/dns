<?php

declare(strict_types=1);

namespace ReturnEarly\Dns\Enums;

use ReturnEarly\LaravelEnums\EnumHelpers;

enum ClassEnum: string
{
    use EnumHelpers;

    case INTERNET = 'IN';
    case CSNET = 'CS';
    case CHAOS = 'CH';
    case HESIOD = 'HS';

    public function toClassId(): int
    {
        return match ($this) {
            self::INTERNET => 1,
            self::CSNET => 2,
            self::CHAOS => 3,
            self::HESIOD => 4,
        };
    }
}
