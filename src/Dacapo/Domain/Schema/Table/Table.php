<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnList;

final class Table
{
    private function __construct(
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
     * @param array<string, mixed> $attributes
     * @return $this
     */
    public static function factory(TableName $tableName, ColumnList $columnList, array $attributes): self
    {
        $tableComment = new TableComment($attributes['comment'] ?? null);
        $engine = new Engine($attributes['engine'] ?? null);
        $charset = new Charset($attributes['charset'] ?? null);
        $collation = new Collation($attributes['collation'] ?? null);
        $temporary = new Temporary($attributes['temporary'] ?? false);

        return new self(
            $tableName,
            $columnList,
            $tableComment,
            $engine,
            $charset,
            $collation,
            $temporary
        );
    }

    public function makeMigration(): string
    {
        return trim(
            $this->engine->makeMigration()
            . $this->charset->makeMigration()
            . $this->collation->makeMigration()
            . $this->temporary->makeMigration()
            . $this->columnList->makeMigration()
        );
    }

    public function getTableName(): string
    {
        return $this->tableName->getName();
    }

    public function getColumnList(): ColumnList
    {
        return $this->columnList;
    }

    public function getTableComment(): TableComment
    {
        return $this->tableComment;
    }
}
