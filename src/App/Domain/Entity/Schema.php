<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\Entity;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Column;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\TableName;

class Schema
{
    protected TableName $tableName;
    protected ColumnList $columnList;

    /**
     * Schema constructor.
     * @param TableName $tableName
     * @param ColumnList $columnList
     */
    public function __construct(
        TableName $tableName,
        ColumnList $columnList
    ) {
        $this->tableName = $tableName;
        $this->columnList = $columnList;
    }

    /**
     * @param string $name
     * @param array $attributes
     * @return Schema
     * @throws
     */
    public static function factoryFromYaml(string $name, array $attributes): self
    {
        $name = new TableName($name);

        $columnList = new ColumnList();
        foreach ($attributes['columns'] as $columnName => $columnAttributes) {
            $column = Column::factoryFromYaml($columnName, $columnAttributes);
            $columnList->add($column);
        }

        return new Schema($name, $columnList);
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName->getName();
    }

    /**
     * @return bool
     */
    public function hasColumnList(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function hasIndexList(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function hasForeignKeyList(): bool
    {
        return false;
    }

    /**
     * @return ColumnList
     */
    public function getColumnList(): ColumnList
    {
        return $this->columnList;
    }
}
