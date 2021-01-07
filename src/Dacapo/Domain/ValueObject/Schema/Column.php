<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

use Exception;

class Column
{
    protected ColumnName $name;
    protected ColumnType $type;
    protected ColumnModifierList $modifierList;

    /**
     * Column constructor.
     * @param ColumnName $name
     * @param ColumnType $type
     * @param ColumnModifierList $modifierList
     */
    public function __construct(ColumnName $name, ColumnType $type, ColumnModifierList $modifierList)
    {
        $this->name = $name;
        $this->type = $type;
        $this->modifierList = $modifierList;
    }

    /**
     * @param string $name
     * @param $attributes
     * @return Column
     * @throws Exception
     */
    public static function factoryFromYaml(string $name, $attributes): self
    {
        $columnName = new ColumnName($name);
        $modifierList = new ColumnModifierList();

        if (is_string($attributes)) {
            try {
                $columnType = self::factoryColumnTypeClass($attributes);
            } catch (Exception $exception) {
                throw new Exception(sprintf('columns.%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
            }
        } elseif (is_bool($attributes) || $attributes === null) {
            try {
                $columnName = new ColumnName('');
                $columnType = self::factoryColumnTypeClass($name);
            } catch (Exception $exception) {
                throw new Exception(sprintf('columns.%s', $exception->getMessage()), $exception->getCode(), $exception);
            }
        } elseif (is_array($attributes)) {
            if (isset($attributes['type']) === false) {
                throw new Exception(sprintf('columns.%s.type field is required', $name));
            }

            try {
                $columnType = self::factoryColumnTypeClass($attributes['type'], $attributes['args'] ?? null);
            } catch (Exception $exception) {
                throw new Exception(sprintf('columns.%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
            }

            unset($attributes['type'], $attributes['args']);

            try {
                foreach ($attributes as $modifierName => $modifierValue) {
                    $modifierList->add(self::factoryColumnModifierClass($modifierName, $modifierValue));
                }
            } catch (Exception $exception) {
                throw new Exception(sprintf('columns.%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
            }
        } else {
            throw new Exception(sprintf('columns.%s field is unsupported format', $name));
        }

        return new self($columnName, $columnType, $modifierList);
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
     * @return ColumnModifierList
     */
    public function getColumnModifierList(): ColumnModifierList
    {
        return $this->modifierList;
    }

    /**
     * @param string $name
     * @param $args
     * @return ColumnType
     * @throws Exception
     */
    protected static function factoryColumnTypeClass(string $name, $args = null): ColumnType
    {
        $columnTypeClass = __NAMESPACE__ . '\\ColumnType\\' . ucfirst($name) . 'Type';

        if (class_exists($columnTypeClass)) {
            if ($args !== null) {
                return new $columnTypeClass($args);
            }

            return new $columnTypeClass();
        }

        throw new Exception(sprintf('%s column type does not exist', $name));
    }

    /**
     * @param string $name
     * @param $value
     * @return ColumnModifier
     * @throws Exception
     */
    protected static function factoryColumnModifierClass(string $name, $value): ColumnModifier
    {
        $columnModifierClass = __NAMESPACE__ . '\\ColumnModifier\\' . ucfirst($name) . 'Modifier';

        if (class_exists($columnModifierClass)) {
            return new $columnModifierClass($value);
        }

        throw new Exception(sprintf('%s column modifier does not exist', $name));
    }
}
