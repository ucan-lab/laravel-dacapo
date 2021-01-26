<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifierType;

class SpatialIndexType implements IndexModifierType
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
