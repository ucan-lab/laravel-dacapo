<?php

namespace UcanLab\LaravelDacapo\Migrations;

use UcanLab\LaravelDacapo\Migrations\Schema\Table;
use UcanLab\LaravelDacapo\Storage\Storage;

class GenerateConstraintForeignKeyMigration
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
        if ($this->table->existsForeignKeys()) {
            $stub = $this->getStub();
            $path = $this->migrationsStorage->getPath($this->table->getConstraintForeignKeyMigrationFileName());
            file_put_contents($path, $stub);
        }
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        $stub = file_get_contents(__DIR__ . '/../Storage/stubs/update.stub');
        $stub = str_replace('DummyClass', $this->table->getConstraintForeignKeyMigrationClassName(), $stub);
        $stub = str_replace('DummyTableName', $this->table->getTableName(), $stub);
        $stub = str_replace('DummyTableUpColumn', $this->table->getUpForeignKeyList(), $stub);
        $stub = str_replace('DummyTableDownColumn', $this->table->getDownForeignKeyList(), $stub);

        return $stub;
    }
}
