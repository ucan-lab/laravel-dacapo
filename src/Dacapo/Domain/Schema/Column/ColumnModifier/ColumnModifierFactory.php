<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

use UcanLab\LaravelDacapo\Dacapo\Application\Shared\Exception\UseCase\InvalidArgumentException;

final class ColumnModifierFactory
{
    private const MAPPING_CLASS = [
        'always' => AlwaysModifier::class,
        'autoIncrement' => AutoIncrementModifier::class,
        'charset' => CharsetModifier::class,
        'collation' => CollationModifier::class,
        'comment' => CommentModifier::class,
        'default' => DefaultModifier::class,
        'defaultRaw' => DefaultRawModifier::class,
        'from' => FromModifier::class,
        'generatedAs' => GeneratedAsModifier::class,
        'index' => IndexModifier::class,
        'nullable' => NullableModifier::class,
        'storedAs' => StoredAsModifier::class,
        'unique' => UniqueModifier::class,
        'unsigned' => UnsignedModifier::class,
        'useCurrent' => UseCurrentModifier::class,
        'useCurrentOnUpdate' => UseCurrentOnUpdateModifier::class,
        'virtualAs' => VirtualAsModifier::class,
    ];

    /**
     * @param string $name
     * @param $value
     * @return ColumnModifier
     */
    public static function factory(string $name, $value): ColumnModifier
    {
        if ($class = self::MAPPING_CLASS[$name] ?? null) {
            return new $class($value);
        }

        throw new InvalidArgumentException(sprintf('%s column modifier does not exist', $name));
    }
}
