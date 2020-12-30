<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SqlIndexType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SqlIndexType;

class UniqueType implements SqlIndexType
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
