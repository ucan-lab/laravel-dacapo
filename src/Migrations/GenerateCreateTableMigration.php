<?php

namespace UcanLab\LaravelDacapo\Migrations;

use UcanLab\LaravelDacapo\Storage\Storage;
use UcanLab\LaravelDacapo\Migrations\Schema\Table;

class GenerateCreateTableMigration
{
    private $table;
    private $migrationsStorage;

    public function __construct(Table $table, Storage $migrationsStorage)
    {
        $this->table = $table;
        $this->migrationsStorage = $migrationsStorage;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $stub = $this->getStub();
        $path = $this->migrationsStorage->getPath($this->table->getCreateTableMigrationFileName());
        file_put_contents($path, $stub);
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        $stub = file_get_contents(__DIR__ . '/../Storage/stubs/create.stub');
        $stub = str_replace('DummyNamespace', $this->table->getCreateTableMigrationNamespace(), $stub);
        $stub = str_replace('DummyClass', $this->table->getCreateTableMigrationClassName(), $stub);
        $stub = str_replace('DummyTableName', $this->table->getTableName(), $stub);
        $stub = str_replace('DummyTableComment', $this->table->getTableComment(), $stub);
        $stub = str_replace('DummyColumn', $this->table->getColumnList(), $stub);
        $stub = str_replace('DummyCreateTableMigration', $this->table->getCreateTableMigration(), $stub);
        $stub = str_replace('DummyDropTableMigration', $this->table->getDropTableMigration(), $stub);

        return $stub;
    }
}
