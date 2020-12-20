<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\Entity;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Column;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ForeignKey;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ForeignKeyList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Index;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\IndexList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\TableName;

class Schema
{
    protected TableName $tableName;
    protected ColumnList $columnList;
    protected IndexList $indexList;
    protected ForeignKeyList $foreignKeyList;

    /**
     * Schema constructor.
     * @param TableName $tableName
     * @param ColumnList $columnList
     * @param IndexList $indexList
     * @param ForeignKeyList $foreignKeyList
     */
    public function __construct (
        TableName $tableName,
        ColumnList $columnList,
        IndexList $indexList,
        ForeignKeyList $foreignKeyList
    ) {
        $this->tableName = $tableName;
        $this->columnList = $columnList;
        $this->indexList = $indexList;
        $this->foreignKeyList = $foreignKeyList;
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

        $foreignKeyList = new ForeignKeyList();
        if (isset($attributes['foreign_keys'])) {
            foreach ($attributes['foreign_keys'] as $foreignKeyAttribute) {
                $foreign = ForeignKey::factoryFromYaml($foreignKeyAttribute);
                $foreignKeyList->add($foreign);
            }
        }

        return new Schema($name, $columnList, $indexList, $foreignKeyList);
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
        return $this->columnList->exists();
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
        return $this->foreignKeyList->exists();
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

    /**
     * @return ForeignKeyList
     */
    public function getForeignKeyList(): ForeignKeyList
    {
        return $this->foreignKeyList;
    }
}
