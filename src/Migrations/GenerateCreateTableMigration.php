<?php

namespace UcanLab\LaravelDacapo\Migrations;

use UcanLab\LaravelDacapo\Migrations\Schema\SchemaLoader;
use UcanLab\LaravelDacapo\Migrations\Schema\Table;

class GenerateCreateTableMigration
{
    private $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $stub = $this->getStub();
        $path = $this->getPath($this->table->getCreateTableMigrationFileName());
        file_put_contents($path, $stub);
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        $stub = file_get_contents(__DIR__ . '/../Storage/stubs/create.stub');
        $stub = str_replace('DummyClass', $this->table->getCreateTableMigrationClassName(), $stub);
        $stub = str_replace('DummyTableName', $this->table->getTableName(), $stub);
        $stub = str_replace('DummyTableComment', $this->table->getTableComment(), $stub);
        $stub = str_replace('DummyColumn', $this->table->getColumnList(), $stub);

        return $stub;
    }

    /**
     * Get the full path to the migration.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        return database_path('migrations') . '/' . $name;
    }
}
