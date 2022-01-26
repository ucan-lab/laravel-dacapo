<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

interface IndexModifierType
{
    public function getUpMethodName(): string;

    public function getDownMethodName(): string;
}
