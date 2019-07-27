<?php

namespace UcanLab\LaravelDacapo\Migrations;

use UcanLab\LaravelDacapo\Migrations\Schema\SchemaLoader;
use UcanLab\LaravelDacapo\Migrations\Schema\Table;

class GenerateCreateIndexMigration
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
        if ($this->existsIndexModifiers()) {
            $stub = $this->getStub();
            $path = $this->getPath($this->table->getCreateIndexMigrationFileName());
            file_put_contents($path, $stub);
        }
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        $stub = file_get_contents(__DIR__ . '/../Storage/stubs/update.stub');
        $stub = str_replace('DummyClass', $this->table->getCreateIndexMigrationClassName(), $stub);
        $stub = str_replace('DummyTableName', $this->table->getTableName(), $stub);
        $stub = str_replace('DummyTableUpCulumn', $this->table->getUpIndexList(), $stub);
        $stub = str_replace('DummyTableDownCulumn', $this->table->getDownIndexList(), $stub);

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
    protected function existsIndexModifiers(): bool
    {
        return $this->table->existsIndexModifiers();
    }
}
