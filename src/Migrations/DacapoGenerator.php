<?php

namespace UcanLab\LaravelDacapo\Migrations;

use UcanLab\LaravelDacapo\Storage\Storage;

/**
 * Class DacapoGenerator
 */
class DacapoGenerator
{
    private $schemasStorage;
    private $migrationsStorage;

    /**
     * DacapoGenerator constructor.
     * @param Storage $schemasStorage
     * @param Storage $migrationsStorage
     */
    public function __construct(Storage $schemasStorage, Storage $migrationsStorage)
    {
        $this->schemasStorage = $schemasStorage;
        $this->migrationsStorage = $migrationsStorage;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $tables = (new SchemaLoader($this->schemasStorage))->run();

        foreach ($tables as $table) {
            (new GenerateCreateTableMigration($table, $this->migrationsStorage))->run();
            (new GenerateCreateIndexMigration($table, $this->migrationsStorage))->run();
            (new GenerateConstraintForeignKeyMigration($table, $this->migrationsStorage))->run();
        }
    }
}
