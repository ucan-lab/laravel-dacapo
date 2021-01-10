<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SqlIndexType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SqlIndexType;

class SpatialIndexType implements SqlIndexType
{
    public function getUpMethodName(): string
    {
        return 'spatialIndex';
    }

    public function getDownMethodName(): string
    {
        return 'dropSpatialIndex';
    }
}
