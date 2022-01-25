<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Factory;

use UcanLab\LaravelDacapo\Dacapo\Application\Shared\Exception\UseCase\InvalidArgumentException;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

final class IndexModifierTypeFactory
{
    private const MAPPING_CLASS = [
        'index' => IndexModifierType\IndexType::class,
        'primary' => IndexModifierType\PrimaryType::class,
        'spatialIndex' => IndexModifierType\SpatialIndexType::class,
        'unique' => IndexModifierType\UniqueType::class,
    ];

    /**
     * @param string $name
     * @param null $args
     * @return IndexModifierType
     */
    public static function factory(string $name, $args = null): IndexModifierType
    {
        if ($class = self::MAPPING_CLASS[$name] ?? null) {
            return new $class($args);
        }

        throw new InvalidArgumentException(sprintf('%s index modifier type does not exist', $name));
    }
}
