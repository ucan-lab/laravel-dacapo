<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use UcanLab\LaravelDacapo\Storage\ModelsStorage;
use UcanLab\LaravelDacapo\Storage\SchemasStorage;
use UcanLab\LaravelDacapo\Migrations\SchemaLoader;
use UcanLab\LaravelDacapo\Generator\ModelTemplateGenerator;

/**
 * Class DacapoModelsCommand.
 */
class DacapoReverseEngineerCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:reverse-engineer
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate template models.';

    /**
     * @return void
     */
    public function handle(): void
    {
        $tables = collect(\DB::select('SHOW TABLES'))->map(function (\StdClass $table) : string {
            return collect($table)->values()->first();;
        });
        $schema = [];

        foreach ($tables as $table) {
            $table_schema = [];
            $columns = \Schema::getColumnListing($table);
            foreach ($columns as $column) {
                $column_schema = [];
                $doctrine_column = \DB::connection()->getDoctrineColumn($table, $column);

                $column_schema['type'] = $doctrine_column->getType()->getName();
                if ($length = $doctrine_column->getLength()) {
                    $column_schema['length'] = $length;
                }
                if ($doctrine_column->getAutoincrement()) {
                    $column_schema['autoIncrement'] = true;
                }
                if ($doctrine_column->getUnsigned()) {
                    $column_schema['unsigned'] = true;
                }

                if ($doctrine_column->getNotnull()) {
                    $column_schema['nullable'] = true;
                }

                if ($default = $doctrine_column->getDefault()) {
                    $column_schema['default'] = $default;
                }

                if ($comment = $doctrine_column->getComment()) {
                    $column_schema['comment'] = $comment;
                }
                $table_schema[$column] = $column_schema;
            }
            $schema[$table] = $table_schema;
            dd($schema);
        }
    }
}
