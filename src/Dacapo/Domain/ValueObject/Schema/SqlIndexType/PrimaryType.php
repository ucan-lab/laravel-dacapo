<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SqlIndexType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SqlIndexType;

class PrimaryType implements SqlIndexType
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
