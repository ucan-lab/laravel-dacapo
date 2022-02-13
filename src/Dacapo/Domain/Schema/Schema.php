<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\Column;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKey;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKeyList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifier;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Charset;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Collation;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Connection;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Engine;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Table;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\TableName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Temporary;

final class Schema
{
    private Table $table;
    private ColumnList $columnList;
    private IndexModifierList $sqlIndexList;
    private ForeignKeyList $foreignKeyList;

    /**
     * Schema constructor.
     * @param Table $table
     * @param ColumnList $columnList
     * @param IndexModifierList $sqlIndexList
     * @param ForeignKeyList $foreignKeyList
     */
    private function __construct(
        Table $table,
        ColumnList $columnList,
        IndexModifierList $sqlIndexList,
        ForeignKeyList $foreignKeyList,
    ) {
        $this->table = $table;
        $this->columnList = $columnList;
        $this->sqlIndexList = $sqlIndexList;
        $this->foreignKeyList = $foreignKeyList;
    }

    /**
     * @param TableName $tableName
     * @param array<string, mixed> $attributes
     * @return $this
     */
    public static function factory(TableName $tableName, array $attributes): self
    {
        $columnList = [];
        foreach ($attributes['columns'] ?? [] as $columnName => $columnAttributes) {
            $columnList[] = Column::factory(new ColumnName($columnName), $columnAttributes);
        }

        $indexModifierList = [];
        foreach ($attributes['indexes'] ?? [] as $indexModifierAttributes) {
            $indexModifierList[] = IndexModifier::factory($indexModifierAttributes);
        }

        $foreignKeyList = [];
        foreach ($attributes['foreign_keys'] ?? [] as $foreignKeyAttributes) {
            $foreignKeyList[] = ForeignKey::factory($foreignKeyAttributes);
        }

        return new self(
            Table::factory($tableName, $attributes),
            new ColumnList($columnList),
            new IndexModifierList($indexModifierList),
            new ForeignKeyList($foreignKeyList),
        );
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table->getTableName()->getName();
    }

    /**
     * @return string
     */
    public function getTableComment(): string
    {
        return $this->table->getTableComment()->get();
    }

    /**
     * @return bool
     */
    public function hasTableComment(): bool
    {
        return $this->table->getTableComment()->exists();
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
    public function hasIndexModifierList(): bool
    {
        return $this->sqlIndexList->exists();
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
     * @return IndexModifierList
     */
    public function getIndexModifierList(): IndexModifierList
    {
        return $this->sqlIndexList;
    }

    /**
     * @return ForeignKeyList
     */
    public function getForeignKeyList(): ForeignKeyList
    {
        return $this->foreignKeyList;
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->table->getConnection();
    }

    /**
     * @return Engine
     */
    public function getEngine(): Engine
    {
        return $this->table->getEngine();
    }

    /**
     * @return Charset
     */
    public function getCharset(): Charset
    {
        return $this->table->getCharset();
    }

    /**
     * @return Collation
     */
    public function getCollation(): Collation
    {
        return $this->table->getCollation();
    }

    /**
     * @return Temporary
     */
    public function getTemporary(): Temporary
    {
        return $this->table->getTemporary();
    }

    /**
     * @return bool
     */
    public function isDbFacadeUsing(): bool
    {
        if ($this->table->getTableComment()->exists()) {
            return true;
        }

        foreach ($this->columnList as $column) {
            if ($column->isDbFacadeUsing()) {
                return true;
            }
        }

        return false;
    }
}
