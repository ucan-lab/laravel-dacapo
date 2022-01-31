<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

final class Table
{
    private Connection $connection;
    private TableName $tableName;
    private TableComment $tableComment;
    private Engine $engine;
    private Charset $charset;
    private Collation $collation;
    private Temporary $temporary;

    private function __construct(
        Connection $connection,
        TableName $tableName,
        TableComment $tableComment,
        Engine $engine,
        Charset $charset,
        Collation $collation,
        Temporary $temporary
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->tableComment = $tableComment;
        $this->engine = $engine;
        $this->charset = $charset;
        $this->collation = $collation;
        $this->temporary = $temporary;
    }

    /**
     * @param TableName $tableName
     * @param array $attributes
     * @return $this
     */
    public static function factory(TableName $tableName, array $attributes): self
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
            $tableComment,
            $engine,
            $charset,
            $collation,
            $temporary
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
     * @return TableName
     */
    public function getTableName(): TableName
    {
        return $this->tableName;
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
