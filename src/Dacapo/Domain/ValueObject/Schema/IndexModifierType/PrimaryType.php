<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifierType;

class PrimaryType implements IndexModifierType
{
    public function getUpMethodName(): string
    {
        return 'primary';
    }

    public function getDownMethodName(): string
    {
        return 'dropPrimary';
    }
}
