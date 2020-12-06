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
     * @param $name
     * @param $type
     * @param $modifierList
     */
    public function __construct($name, $type, $modifierList)
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
        } elseif (is_array($attributes)) {
            if (isset($attributes['type'])) {
                $columnType = self::factoryColumnTypeClass($attributes['type']);
            } else {
                throw new Exception('Column type is unspecified.');
            }
        } elseif (is_bool($attributes)) {
            $columnType = self::factoryColumnTypeClass($name);
        } else {
            throw new Exception('Unsupported format exception.');
        }

        return new Column($columnName, $columnType, $modifierList);
    }

    /**
     * @param string $name
     * @return ColumnType
     * @throws Exception
     */
    protected static function factoryColumnTypeClass(string $name): ColumnType
    {
        $columnTypeClass = __NAMESPACE__ . '\\ColumnType\\' . ucfirst($name) . 'Type';

        if (class_exists($columnTypeClass)) {
            return new $columnTypeClass();
        }

        throw new Exception(sprintf('%s class not found exception.', $columnTypeClass));
    }
}
