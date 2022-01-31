<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Application\Shared\Exception\UseCase\InvalidArgumentException;

final class IndexModifierTypeFactory
{
    private const MAPPING_CLASS = [
        'index' => IndexType::class,
        'primary' => PrimaryType::class,
        'spatialIndex' => SpatialIndexType::class,
        'unique' => UniqueType::class,
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
