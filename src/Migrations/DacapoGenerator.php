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
    private $enabledMakeModel;
    private $schemasStorage;
    private $migrationsStorage;

    /**
     * DacapoGenerator constructor.
     * @param bool $enabledMakeModel
     */
    public function __construct(bool $enabledMakeModel)
    {
        $this->enabledMakeModel = $enabledMakeModel;
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

        if ($this->enabledMakeModel) {
            (new ModelTemplateGenerator($tables))->run();
        }
    }
}
