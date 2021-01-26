<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifierType;

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
