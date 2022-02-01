<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

final class SpatialIndexType implements IndexModifierType
{
    public function __construct()
    {
    }

    public function getUpMethodName(): string
    {
        return 'spatialIndex';
    }

    public function getDownMethodName(): string
    {
        return 'dropSpatialIndex';
    }
}
