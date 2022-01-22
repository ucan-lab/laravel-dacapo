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

    public function __construct(
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
