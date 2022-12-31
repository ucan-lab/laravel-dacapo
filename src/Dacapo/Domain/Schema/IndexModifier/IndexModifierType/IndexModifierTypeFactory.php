<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Shared\Exception\Schema\IndexModifier\IndexModifierType\InvalidArgumentException;

final class IndexModifierTypeFactory
{
    private const MAPPING_CLASS = [
        'index' => IndexType::class,
        'primary' => PrimaryType::class,
        'spatialIndex' => SpatialIndexType::class,
        'unique' => UniqueType::class,
        'fullText' => FullTextType::class,
    ];

    public static function factory(string $name): IndexModifierType
    {
        $class = self::MAPPING_CLASS[$name] ?? throw new InvalidArgumentException(sprintf('%s index modifier type does not exist', $name));

        return new $class();
    }
}
