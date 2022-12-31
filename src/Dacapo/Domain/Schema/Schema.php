<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Driver\DatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Stub\MigrationCreateStub;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Stub\MigrationUpdateStub;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKey;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKeyList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifier;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\Column;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Connection;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Table;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\TableName;

final class Schema
{
    /**
     * Schema constructor.
     */
    private function __construct(
        private Table $table,
        private Connection $connection,
        private IndexModifierList $indexModifierList,
        private ForeignKeyList $foreignKeyList,
    ) {
    }

    /**
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
            Table::factory($tableName, new ColumnList($columnList), $attributes),
            new Connection($attributes['connection'] ?? null),
            new IndexModifierList($indexModifierList),
            new ForeignKeyList($foreignKeyList),
        );
    }

    public function makeCreateTableMigrationFile(
        DatabaseDriver $databaseBuilder,
        MigrationCreateStub $migrationCreateStub
    ): MigrationFile {
        $tableComment = '';
        if ($this->hasTableComment() && $databaseBuilder->isEnabledTableComment()) {
            $tableComment = $databaseBuilder->makeTableComment($this);
        }

        return MigrationFile::factory($this->makeCreateTableMigrationFileName(), $migrationCreateStub->getStub())
            ->replace('{{ namespace }}', $this->makeMigrationCreateNamespace($migrationCreateStub->getNamespaces()))
            ->replace('{{ connection }}', $this->connection->makeMigration())
            ->replace('{{ tableName }}', $this->getTableName())
            ->replace('{{ tableComment }}', $tableComment)
            ->replace('{{ up }}', $this->table->makeMigration());
    }

    public function makeCreateIndexMigrationFile(MigrationUpdateStub $migrationUpdateStub): ?MigrationFile
    {
        if ($this->indexModifierList->exists() === false) {
            return null;
        }

        return MigrationFile::factory($this->makeCreateIndexMigrationFileName(), $migrationUpdateStub->getStub())
            ->replace('{{ namespace }}', $this->makeMigrationUpdateNamespace($migrationUpdateStub->getNamespaces()))
            ->replace('{{ connection }}', $this->connection->makeMigration())
            ->replace('{{ table }}', $this->getTableName())
            ->replace('{{ up }}', $this->indexModifierList->makeUpMigration())
            ->replace('{{ down }}', $this->indexModifierList->makeDownMigration());
    }

    public function makeConstraintForeignKeyMigrationFile(MigrationUpdateStub $migrationUpdateStub): ?MigrationFile
    {
        if ($this->foreignKeyList->exists() === false) {
            return null;
        }

        return MigrationFile::factory($this->makeConstraintForeignKeyMigrationFileName(), $migrationUpdateStub->getStub())
            ->replace('{{ namespace }}', $this->makeMigrationUpdateNamespace($migrationUpdateStub->getNamespaces()))
            ->replace('{{ connection }}', $this->connection->makeMigration())
            ->replace('{{ table }}', $this->getTableName())
            ->replace('{{ up }}', $this->foreignKeyList->makeUpMigration())
            ->replace('{{ down }}', $this->foreignKeyList->makeDownMigration());
    }

    private function makeCreateTableMigrationFileName(): string
    {
        return sprintf('1970_01_01_000001_create_%s_table.php', $this->getTableName());
    }

    private function makeCreateIndexMigrationFileName(): string
    {
        return sprintf('1970_01_01_000002_create_%s_index.php', $this->getTableName());
    }

    private function makeConstraintForeignKeyMigrationFileName(): string
    {
        return sprintf('1970_01_01_000003_constraint_%s_foreign_key.php', $this->getTableName());
    }

    public function getTableName(): string
    {
        return $this->table->getTableName();
    }

    public function getTableComment(): string
    {
        return $this->table->getTableComment()->get();
    }

    public function hasTableComment(): bool
    {
        return $this->table->getTableComment()->exists();
    }

    public function isDbFacadeUsing(): bool
    {
        if ($this->table->getTableComment()->exists()) {
            return true;
        }

        /** @var Column $column */
        foreach ($this->table->getColumnList() as $column) {
            if ($column->isDbFacadeUsing()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<int, string> $namespaces
     */
    private function makeMigrationCreateNamespace(array $namespaces): string
    {
        if ($this->isDbFacadeUsing()) {
            $namespaces[] = 'use Illuminate\Support\Facades\DB;';
        }

        sort($namespaces);

        return implode(PHP_EOL, array_unique($namespaces));
    }

    /**
     * @param array<int, string> $namespaces
     */
    private function makeMigrationUpdateNamespace(array $namespaces): string
    {
        sort($namespaces);

        return implode(PHP_EOL, array_unique($namespaces));
    }
}
