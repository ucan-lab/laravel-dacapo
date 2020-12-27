<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\Entity;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Charset;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Collation;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Column;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Engine;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ForeignKey;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ForeignKeyList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SqlIndex;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SqlIndexList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\TableName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Temporary;

class Schema
{
    protected TableName $tableName;
    protected ColumnList $columnList;
    protected SqlIndexList $sqlIndexList;
    protected ForeignKeyList $foreignKeyList;
    protected Engine $engine;
    protected Charset $charset;
    protected Collation $collation;
    protected Temporary $temporary;

    /**
     * Schema constructor.
     * @param TableName $tableName
     * @param ColumnList $columnList
     * @param SqlIndexList $sqlIndexList
     * @param ForeignKeyList $foreignKeyList
     * @param Engine $engine
     * @param Charset $charset
     * @param Collation $collation
     * @param Temporary $temporary
     */
    public function __construct (
        TableName $tableName,
        ColumnList $columnList,
        SqlIndexList $sqlIndexList,
        ForeignKeyList $foreignKeyList,
        Engine $engine,
        Charset $charset,
        Collation $collation,
        Temporary $temporary
    ) {
        $this->tableName = $tableName;
        $this->columnList = $columnList;
        $this->sqlIndexList = $sqlIndexList;
        $this->foreignKeyList = $foreignKeyList;
        $this->engine = $engine;
        $this->charset = $charset;
        $this->collation = $collation;
        $this->temporary = $temporary;
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

        $sqlIndexList = new SqlIndexList();
        if (isset($attributes['indexes'])) {
            foreach ($attributes['indexes'] as $indexAttributes) {
                $sqlIndex = SqlIndex::factoryFromYaml($indexAttributes);
                $sqlIndexList->add($sqlIndex);
            }
        }

        $foreignKeyList = new ForeignKeyList();
        if (isset($attributes['foreign_keys'])) {
            foreach ($attributes['foreign_keys'] as $foreignKeyAttribute) {
                $foreign = ForeignKey::factoryFromYaml($foreignKeyAttribute);
                $foreignKeyList->add($foreign);
            }
        }

        $engine = new Engine($attributes['engine'] ?? null);
        $charset = new Charset($attributes['charset'] ?? null);
        $collation = new Collation($attributes['collation'] ?? null);
        $temporary = new Temporary($attributes['temporary'] ?? false);

        return new Schema (
            $name,
            $columnList,
            $sqlIndexList,
            $foreignKeyList,
            $engine,
            $charset,
            $collation,
            $temporary
        );
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
    public function hasSqlIndexList(): bool
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
     * @return SqlIndexList
     */
    public function getSqlIndexList(): SqlIndexList
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
     * @return Engine
     */
    public function getEngine(): Engine
    {
        return $this->engine;
    }

    /**
     * @return Charset
     */
    public function getCharset(): Charset
    {
        return $this->charset;
    }

    /**
     * @return Collation
     */
    public function getCollation(): Collation
    {
        return $this->collation;
    }

    /**
     * @return Temporary
     */
    public function getTemporary(): Temporary
    {
        return $this->temporary;
    }
}
