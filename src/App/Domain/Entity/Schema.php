<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\Entity;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Column;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Index;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\IndexList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\TableName;

class Schema
{
    protected TableName $tableName;
    protected ColumnList $columnList;
    protected IndexList $indexList;

    /**
     * Schema constructor.
     * @param TableName $tableName
     * @param ColumnList $columnList
     * @param IndexList $indexList
     */
    public function __construct (
        TableName $tableName,
        ColumnList $columnList,
        IndexList $indexList
    ) {
        $this->tableName = $tableName;
        $this->columnList = $columnList;
        $this->indexList = $indexList;
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
        if (isset($attributes['columns'])) {
            foreach ($attributes['columns'] as $columnName => $columnAttributes) {
                $column = Column::factoryFromYaml($columnName, $columnAttributes);
                $columnList->add($column);
            }
        }

        $indexList = new IndexList();
        if (isset($attributes['indexes'])) {
            foreach ($attributes['indexes'] as $indexAttributes) {
                $index = Index::factoryFromYaml($indexAttributes);
                $indexList->add($index);
            }
        }

        return new Schema($name, $columnList, $indexList);
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
        return $this->indexList->exists();
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

    /**
     * @return IndexList
     */
    public function getIndexList(): IndexList
    {
        return $this->indexList;
    }
}
