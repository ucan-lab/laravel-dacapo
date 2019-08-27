<?php

namespace UcanLab\LaravelDacapo\Migrations;

use UcanLab\LaravelDacapo\Generator\ModelTemplateGenerator;
use UcanLab\LaravelDacapo\Storage\MigrationsStorage;
use UcanLab\LaravelDacapo\Storage\SchemasStorage;

/**
 * Class DacapoGenerator
 */
class DacapoGenerator
{
    private $schemasStorage;
    private $migrationsStorage;

    /**
     * DacapoGenerator constructor.
     */
    public function __construct()
    {
        $this->schemasStorage = new SchemasStorage();
        $this->migrationsStorage = new MigrationsStorage();
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
