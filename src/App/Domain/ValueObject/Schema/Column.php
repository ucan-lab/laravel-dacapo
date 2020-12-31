<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

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
            $columnType = self::factoryColumnTypeClass($attributes);
        } elseif (is_bool($attributes)) {
            $columnType = self::factoryColumnTypeClass($name);
        } elseif (is_array($attributes)) {
            if (isset($attributes['type']) === false) {
                throw new Exception('Column type is unspecified.');
            }

            $columnType = self::factoryColumnTypeClass($attributes['type'], $attributes['args'] ?? null);

            unset($attributes['type'], $attributes['args']);

            foreach ($attributes as $modifierName => $modifierValue) {
                $modifierList->add(self::factoryColumnModifierClass($modifierName, $modifierValue));
            }
        } else {
            throw new Exception('Unsupported format exception.');
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
     * @param string $name
     * @param $args
     * @return ColumnType
     * @throws Exception
     */
    protected static function factoryColumnTypeClass(string $name, $args = null): ColumnType
    {
        $columnTypeClass = __NAMESPACE__ . '\\ColumnType\\' . ucfirst($name) . 'Type';

        if (class_exists($columnTypeClass)) {
            if ($args) {
                return new $columnTypeClass($args);
            }

            return new $columnTypeClass();
        }

        throw new Exception(sprintf('%s class not found exception.', $columnTypeClass));
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

        throw new Exception(sprintf('%s class not found exception.', $columnModifierClass));
    }
}
