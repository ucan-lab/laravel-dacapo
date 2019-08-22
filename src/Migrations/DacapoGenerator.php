<?php

namespace UcanLab\LaravelDacapo\Migrations;

use UcanLab\LaravelDacapo\Generator\ModelTemplateGenerator;

/**
 * Class DacapoGenerator
 */
class DacapoGenerator
{
    private $enabledMakeModel;

    /**
     * DacapoGenerator constructor.
     * @param bool $enabledMakeModel
     */
    public function __construct(bool $enabledMakeModel)
    {
        $this->enabledMakeModel = $enabledMakeModel;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $tables = (new SchemaLoader())->run();

        foreach ($tables as $table) {
            (new GenerateCreateTableMigration($table))->run();
            (new GenerateCreateIndexMigration($table))->run();
            (new GenerateConstraintForeignKeyMigration($table))->run();
        }

        if ($this->enabledMakeModel) {
            (new ModelTemplateGenerator($tables))->run();
        }
    }
}
