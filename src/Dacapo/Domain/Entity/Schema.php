<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Entity;

use Exception;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\Charset;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\Collation;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\Column;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnModifier\DefaultRawModifier;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\Connection;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\Engine;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ForeignKey;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ForeignKeyList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifier;
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
     * @param string $name
     * @param array $attributes
     * @return Schema
     * @throws Exception
     */
    public static function factoryFromYaml(string $name, array $attributes): self
    {
        $tableName = new TableName($name);

        try {
            $columnList = new ColumnList();

            if (isset($attributes['columns'])) {
                foreach ($attributes['columns'] as $columnName => $columnAttributes) {
                    $column = Column::factoryFromYaml($columnName, $columnAttributes);
                    $columnList->add($column);
                }
            }

            $sqlIndexList = new IndexModifierList();

            if (isset($attributes['indexes'])) {
                foreach ($attributes['indexes'] as $indexAttributes) {
                    $sqlIndex = IndexModifier::factoryFromYaml($indexAttributes);
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
        } catch (Exception $exception) {
            throw new Exception(sprintf('%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
        }

        $connection = new Connection($attributes['connection'] ?? null);
        $tableComment = new TableComment($attributes['comment'] ?? null);
        $engine = new Engine($attributes['engine'] ?? null);
        $charset = new Charset($attributes['charset'] ?? null);
        $collation = new Collation($attributes['collation'] ?? null);
        $temporary = new Temporary($attributes['temporary'] ?? false);

        return new self(
            $connection,
            $tableName,
            $tableComment,
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
