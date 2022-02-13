<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierFactory;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\DbFacadeUsing;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\AliasColumnType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\ArrayArgsColumnType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\BooleanArgsColumnType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\ColumnType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\ColumnTypeFactory;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\NumericArgsColumnType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\StringArgsColumnType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Shared\Exception\Schema\Column\InvalidArgumentException;
use function is_array;
use function is_bool;
use function is_string;

final class Column
{
    /**
     * Column constructor.
     * @param ColumnName $name
     * @param ColumnType $type
     * @param ColumnTypeArgs $typeArgs
     * @param ColumnModifierList $modifierList
     */
    public function __construct(
        private ColumnName $name,
        private ColumnType $type,
        private ColumnTypeArgs $typeArgs,
        private ColumnModifierList $modifierList,
    ) {
    }

    /**
     * @param ColumnName $columnName
     * @param array<string, mixed>|bool|string|null $attributes
     * @return static
     */
    public static function factory(
        ColumnName $columnName,
        array|bool|string|null $attributes,
    ): self {
        if (is_string($attributes)) {
            $columnType = ColumnTypeFactory::factory($attributes);

            return new self(
                $columnName,
                $columnType,
                ColumnTypeArgs::factory(null),
                new ColumnModifierList([])
            );
        } elseif (is_bool($attributes)) {
            $columnType = ColumnTypeFactory::factory($columnName->getName());

            return new self(
                new ColumnName(null),
                $columnType,
                ColumnTypeArgs::factory(null),
                new ColumnModifierList([])
            );
        } elseif (is_array($attributes)) {
            $attributes['type'] ?? throw new InvalidArgumentException(sprintf('columns.%s.type field is required', $columnName->getName()));

            $columnType = ColumnTypeFactory::factory($attributes['type']);

            if ($columnType instanceof BooleanArgsColumnType) {
                if (isset($attributes['args'])) {
                    $args = array_map(fn ($args) => var_export($args, true), $attributes['args'] ?? []);
                    $columnTypeArgs = ColumnTypeArgs::factory($args);
                } else {
                    $columnTypeArgs = ColumnTypeArgs::factory(null);
                }
            } else {
                $columnTypeArgs = ColumnTypeArgs::factory(
                    $attributes['args'] ?? null,
                    $columnType instanceof ArrayArgsColumnType,
                    $columnType instanceof StringArgsColumnType,
                    $columnType instanceof NumericArgsColumnType
                );
            }

            unset($attributes['type'], $attributes['args']);

            $columnModifierList = [];
            foreach ($attributes as $modifierName => $modifierValue) {
                $columnModifierList[] = ColumnModifierFactory::factory($modifierName, $modifierValue);
            }

            if ($columnType instanceof AliasColumnType) {
                return new self(
                    new ColumnName(null),
                    $columnType,
                    $columnTypeArgs,
                    new ColumnModifierList($columnModifierList)
                );
            }

            return new self(
                $columnName,
                $columnType,
                $columnTypeArgs,
                new ColumnModifierList($columnModifierList)
            );
        }

        $columnType = ColumnTypeFactory::factory($columnName->getName());

        return new self(
            new ColumnName(null),
            $columnType,
            ColumnTypeArgs::factory(null),
            new ColumnModifierList([])
        );
    }

    /**
     * @return string
     */
    public function createColumnMigration(): string
    {
        $modifierMethod = '';
        foreach ($this->modifierList as $modifier) {
            if ($modifier->hasColumnModifierArgs()) {
                if ($modifier instanceof DbFacadeUsing) {
                    $modifierMethod .= sprintf('->%s(DB::raw(%s))', $modifier->getName(), $modifier->columnModifierArgs());
                } else {
                    $modifierMethod .= sprintf('->%s(%s)', $modifier->getName(), $modifier->columnModifierArgs());
                }
            } else {
                $modifierMethod .= sprintf('->%s()', $modifier->getName());
            }
        }

        if ($this->name->hasName() && $this->typeArgs->hasArgs()) {
            return '$table->' . sprintf("%s('%s', %s)%s;", $this->type->columnType(), $this->name->getName(), $this->typeArgs->typeArgs(), $modifierMethod);
        } elseif ($this->name->hasName() && ! $this->typeArgs->hasArgs()) {
            return '$table->' . sprintf("%s('%s')%s;", $this->type->columnType(), $this->name->getName(), $modifierMethod);
        } elseif (! $this->name->hasName() && $this->typeArgs->hasArgs()) {
            return '$table->' . sprintf("%s(%s);", $this->type->columnType(), $this->typeArgs->typeArgs());
        }

        return '$table->' . sprintf("%s();", $this->type->columnType());
    }

    /**
     * @return bool
     */
    public function isDbFacadeUsing(): bool
    {
        foreach ($this->modifierList as $modifier) {
            if ($modifier instanceof DbFacadeUsing) {
                return true;
            }
        }

        return false;
    }
}
