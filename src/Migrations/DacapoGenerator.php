<?php

namespace UcanLab\LaravelDacapo\Migrations;

class DacapoGenerator
{
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
    }
}
