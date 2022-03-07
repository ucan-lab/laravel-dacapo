<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnList;

final class Table
{
    private function __construct(
        private Connection $connection,
        private TableName $tableName,
        private ColumnList $columnList,
        private TableComment $tableComment,
        private Engine $engine,
        private Charset $charset,
        private Collation $collation,
        private Temporary $temporary,
    ) {
    }

    /**
     * @param TableName $tableName
     * @param ColumnList $columnList
     * @param array<string, mixed> $attributes
     * @return $this
     */
    public static function factory(TableName $tableName, ColumnList $columnList, array $attributes): self
    {
        $connection = new Connection($attributes['connection'] ?? null);
        $tableComment = new TableComment($attributes['comment'] ?? null);
        $engine = new Engine($attributes['engine'] ?? null);
        $charset = new Charset($attributes['charset'] ?? null);
        $collation = new Collation($attributes['collation'] ?? null);
        $temporary = new Temporary($attributes['temporary'] ?? false);

        return new self(
            $connection,
            $tableName,
            $columnList,
            $tableComment,
            $engine,
            $charset,
            $collation,
            $temporary
        );
    }

    /**
     * @return string
     */
    public function makeCreateTableUpMigration(): string
    {
        return trim(
            $this->engine->makeMigration()
            . $this->charset->makeMigration()
            . $this->collation->makeMigration()
            . $this->temporary->makeMigration()
            . $this->columnList->makeMigration()
        );
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName->getName();
    }

    /**
     * @return ColumnList
     */
    public function getColumnList(): ColumnList
    {
        return $this->columnList;
    }

    /**
     * @return TableComment
     */
    public function getTableComment(): TableComment
    {
        return $this->tableComment;
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
