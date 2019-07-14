<?php

namespace UcanLab\LaravelDacapo\Migrations;

/**
 * MigrationCreator class
 */
class DacapoGenerator
{
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
