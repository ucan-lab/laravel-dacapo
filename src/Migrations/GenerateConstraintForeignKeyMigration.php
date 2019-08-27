<?php

namespace UcanLab\LaravelDacapo\Migrations;

use UcanLab\LaravelDacapo\Migrations\Schema\SchemaLoader;
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
        if ($this->existsForeignKeys()) {
            $stub = $this->getStub();
            $path = $this->getPath($this->table->getConstraintForeignKeyMigrationFileName());
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
        $stub = str_replace('DummyTableUpCulumn', $this->table->getUpForeignKeyList(), $stub);
        $stub = str_replace('DummyTableDownCulumn', $this->table->getDownForeignKeyList(), $stub);

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

    /**
     * @return bool
     */
    protected function existsForeignKeys(): bool
    {
        return $this->table->existsForeignKeys();
    }
}
