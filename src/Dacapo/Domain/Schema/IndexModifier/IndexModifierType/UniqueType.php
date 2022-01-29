<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

final class UniqueType implements IndexModifierType
{
    public function __construct()
    {
    }

    public function getUpMethodName(): string
    {
        return 'unique';
    }

    public function getDownMethodName(): string
    {
        return 'dropUnique';
    }
}
