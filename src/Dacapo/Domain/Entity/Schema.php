<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Entity;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\Charset;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\Collation;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnModifier\DefaultRawModifier;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\Connection;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\Engine;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ForeignKeyList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifierList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\TableComment;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\TableName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\Temporary;

class Schema
{
    protected Connection $connection;
    protected TableName $tableName;
    protected TableComment $tableComment;
    protected ColumnList $columnList;
    protected IndexModifierList $sqlIndexList;
    protected ForeignKeyList $foreignKeyList;
    protected Engine $engine;
    protected Charset $charset;
    protected Collation $collation;
    protected Temporary $temporary;

    /**
     * Schema constructor.
     * @param Connection $connection
     * @param TableName $tableName
     * @param TableComment $tableComment
     * @param ColumnList $columnList
     * @param IndexModifierList $sqlIndexList
     * @param ForeignKeyList $foreignKeyList
     * @param Engine $engine
     * @param Charset $charset
     * @param Collation $collation
     * @param Temporary $temporary
     */
    public function __construct(
        Connection $connection,
        TableName $tableName,
        TableComment $tableComment,
        ColumnList $columnList,
        IndexModifierList $sqlIndexList,
        ForeignKeyList $foreignKeyList,
        Engine $engine,
        Charset $charset,
        Collation $collation,
        Temporary $temporary
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->tableComment = $tableComment;
        $this->columnList = $columnList;
        $this->sqlIndexList = $sqlIndexList;
        $this->foreignKeyList = $foreignKeyList;
        $this->engine = $engine;
        $this->charset = $charset;
        $this->collation = $collation;
        $this->temporary = $temporary;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName->getName();
    }

    /**
     * @return string
     */
    public function getTableComment(): string
    {
        return $this->tableComment->get();
    }

    /**
     * @return bool
     */
    public function hasTableComment(): bool
    {
        return $this->tableComment->exists();
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
        return $this->connection;
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

    /**
     * @return bool
     */
    public function useDbFacade(): bool
    {
        if ($this->tableComment->exists()) {
            return true;
        }

        foreach ($this->columnList as $column) {
            foreach ($column->getColumnModifierList() as $columnModifier) {
                if ($columnModifier instanceof DefaultRawModifier) {
                    return true;
                }
            }
        }

        return false;
    }
}
