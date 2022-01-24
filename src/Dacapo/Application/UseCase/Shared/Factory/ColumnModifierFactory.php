<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Factory;

use UcanLab\LaravelDacapo\Dacapo\Application\Shared\Exception\UseCase\InvalidArgumentException;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

final class ColumnModifierFactory
{
    private const MAPPING_CLASS = [
        'always' => ColumnModifier\AlwaysModifier::class,
        'autoIncrement' => ColumnModifier\AutoIncrementModifier::class,
        'charset' => ColumnModifier\CharsetModifier::class,
        'collation' => ColumnModifier\CollationModifier::class,
        'columnModi' => ColumnModifier\ColumnModifierList::class,
        'comment' => ColumnModifier\CommentModifier::class,
        'default' => ColumnModifier\DefaultModifier::class,
        'defaultRaw' => ColumnModifier\DefaultRawModifier::class,
        'from' => ColumnModifier\FromModifier::class,
        'generatedAs' => ColumnModifier\GeneratedAsModifier::class,
        'index' => ColumnModifier\IndexModifier::class,
        'nullable' => ColumnModifier\NullableModifier::class,
        'storedAs' => ColumnModifier\StoredAsModifier::class,
        'unique' => ColumnModifier\UniqueModifier::class,
        'unsigned' => ColumnModifier\UnsignedModifier::class,
        'useCurrent' => ColumnModifier\UseCurrentModifier::class,
        'useCurrentOnUpdate' => ColumnModifier\UseCurrentOnUpdateModifier::class,
        'virtualAs' => ColumnModifier\VirtualAsModifier::class,
    ];

    /**
     * @param string $name
     * @param $value
     * @return ColumnModifier\ColumnModifier
     */
    public function factory(string $name, $value): ColumnModifier\ColumnModifier
    {
        if ($class = self::MAPPING_CLASS[$name] ?? null) {
            return new $class($value);
        }

        throw new InvalidArgumentException(sprintf('%s column modifier does not exist', $name));
    }
}
