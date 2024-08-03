<?php

declare(strict_types=1);

namespace ReturnEarly\Dns;

use Badcow\DNS\Question as BadcowQuestion;
use ReturnEarly\Dns\Enums\ClassEnum;
use ReturnEarly\Dns\Enums\TypeEnum;

class Question
{
    public function __construct(
        private readonly string $name,
        private readonly TypeEnum $type,
        private readonly ClassEnum $class = ClassEnum::INTERNET,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getFullyQualifiedName(): string
    {
        return rtrim($this->name, '.').'.';
    }

    public function getType(): TypeEnum
    {
        return $this->type;
    }

    public function toBadcowQuestion(): BadcowQuestion
    {
        $question = new BadcowQuestion;
        $question->setName($this->getFullyQualifiedName());
        $question->setTypeCode($this->type->toTypeId());
        $question->setClassId($this->class->toClassId());

        return $question;
    }
}
