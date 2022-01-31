<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column;

use UcanLab\LaravelDacapo\Dacapo\Application\Shared\Exception\UseCase\InvalidArgumentException;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierFactory;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\DbFacadeUsing;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\ColumnType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\ColumnTypeFactory;
use function is_string;
use function is_bool;
use function is_array;

final class Column
{
    private ColumnName $name;
    private ColumnType $type;
    private ColumnModifierList $modifierList;

    /**
     * Column constructor.
     * @param ColumnName $name
     * @param ColumnType $type
     * @param ColumnModifierList $modifierList
     */
    public function __construct(
        ColumnName $name,
        ColumnType $type,
        ColumnModifierList $modifierList
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->modifierList = $modifierList;
    }

    /**
     * @param ColumnName $columnName
     * @param $attributes
     * @return static
     */
    public static function factory(ColumnName $columnName, $attributes): self
    {
        $columnModifierList = [];

        if (is_string($attributes)) {
            try {
                $columnType = ColumnTypeFactory::factory($attributes);
            } catch (InvalidArgumentException $exception) {
                throw new InvalidArgumentException(sprintf('columns.%s.%s', $columnName->getName(), $exception->getMessage()), $exception->getCode(), $exception);
            }
        } elseif (is_bool($attributes) || $attributes === null) {
            try {
                $columnType = ColumnTypeFactory::factory($columnName->getName());
                $columnName = new ColumnName('');
            } catch (InvalidArgumentException $exception) {
                throw new InvalidArgumentException(sprintf('columns.%s', $exception->getMessage()), $exception->getCode(), $exception);
            }
        } elseif (is_array($attributes)) {
            if (isset($attributes['type']) === false) {
                throw new InvalidArgumentException(sprintf('columns.%s.type field is required', $columnName->getName()));
            }

            try {
                $columnType = ColumnTypeFactory::factory($attributes['type'], $attributes['args'] ?? null);
            } catch (InvalidArgumentException $exception) {
                throw new InvalidArgumentException(sprintf('columns.%s.%s', $columnName->getName(), $exception->getMessage()), $exception->getCode(), $exception);
            }

            unset($attributes['type'], $attributes['args']);

            try {
                foreach ($attributes as $modifierName => $modifierValue) {
                    $columnModifierList[] = ColumnModifierFactory::factory($modifierName, $modifierValue);
                }
            } catch (InvalidArgumentException $exception) {
                throw new InvalidArgumentException(sprintf('columns.%s.%s', $columnName->getName(), $exception->getMessage()), $exception->getCode(), $exception);
            }
        } else {
            throw new InvalidArgumentException(sprintf('columns.%s field is unsupported format', $columnName->getName()));
        }

        return new self(
            $columnName,
            $columnType,
            new ColumnModifierList($columnModifierList)
        );
    }

    /**
     * @return string
     */
    public function createColumnMigration(): string
    {
        $typeMethod = $this->type->createMigrationMethod($this->name);

        $modifierMethod = '';

        foreach ($this->modifierList as $modifier) {
            $modifierMethod .= $modifier->createMigrationMethod();
        }

        return sprintf('$table%s%s;', $typeMethod, $modifierMethod);
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
