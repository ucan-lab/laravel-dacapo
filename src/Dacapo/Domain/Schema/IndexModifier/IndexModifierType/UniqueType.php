<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

class UniqueType implements IndexModifierType
{
    public function getUpMethodName(): string
    {
        return 'unique';
    }

    public function getDownMethodName(): string
    {
        return 'dropUnique';
    }
}
