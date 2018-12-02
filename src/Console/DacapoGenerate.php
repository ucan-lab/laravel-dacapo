<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

/**
 * Class DacapoGenerate
 */
class DacapoGenerate extends Command
{
    /** @var string */
    protected $name = 'dacapo:generate';

    /** @var string */
    protected $description = 'Generate migration files.';

    private $templateCreateText = '';
    private $templateConstraintText = '';
    private $relations = [];
    private $indexes = [];

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->templateCreateText = file_get_contents(__DIR__ . '/../Storage/template.create.migration.txt');
        $this->templateConstraintText = file_get_contents(__DIR__ . '/../Storage/template.constraint.migration.txt');

        $this->relations = [];
        $this->indexes = [];

        parent::__construct();
    }

    /**
     * @return void
     */
    public function handle()
    {
        $this->removeMigration();
        $this->createMigration();
        $this->indexMigration();
        $this->foreignMigration();
    }

    /**
     * migrations directory remove all files.
     *
     * @return void
     */
    private function removeMigration()
    {
        File::deleteDirectory(database_path('migrations'));
        File::makeDirectory(database_path('migrations'));
    }

    /**
     * create table migration generate.
     *
     * @return void
     */
    private function createMigration()
    {
        $file = base_path('database/schema.yml');
        $yaml = Yaml::parse(file_get_contents($file));

        foreach ($yaml as $tableName => $table) {
            $this->parseSchema($tableName, $table);
        }
    }

    private function parseSchema(string $tableName, array $table)
    {
        $fileName = $this->makeCreateMigrationFileName($tableName);
        $className = $this->makeClassName($fileName);
        $tableComment = array_get($table, 'comment');
        $columns = array_get($table, 'columns');

        $columnsInfo = '';
        $isFirst = true;
        foreach ($columns as $columnName => $columnInfo) {
            $columnsInfo .= $this->parseColumn($columnName, $columnInfo, $isFirst);
            $isFirst = false;
        }

        if (array_get($table, 'rememberToken')) {
            $columnsInfo .= PHP_EOL . '            ' . '$table->rememberToken();';
        }

        if (array_get($table, 'timestamps')) {
            $columnsInfo .= PHP_EOL . '            ' . '$table->timestamps();';
        }

        if (array_get($table, 'relations')) {
            foreach (array_get($table, 'relations') as $relation) {
                $this->relations[$tableName][] = $relation;
            }
        }

        if (array_get($table, 'indexes')) {
            foreach (array_get($table, 'indexes') as $index) {
                $this->indexes[$tableName][] = $index;
            }
        }

        $template = $this->templateCreateText;
        $template = str_replace('_CLASS_NAME_', $className, $template);
        $template = str_replace('_TABLE_NAME_', $tableName, $template);
        $template = str_replace('_TABLE_COMMENT_', $tableComment, $template);
        $template = str_replace('_COLUMNS_INFO_', $columnsInfo, $template);

        $filePath = $this->getPath($fileName);
        $this->writeMigration($filePath, $template);
    }

    private function parseColumn(string $name, $info, $isFirst)
    {
        $line = '';

        if ($info === 'increments') {
            $line = "->increments('id')";
        } else {
            foreach ($info as $key => $value) {
                if ($key === 'type') {
                    preg_match('/\((.*)\)/', $value, $match);
                    $digits = isset($match[1]) ? $match[1] : 0;

                    $columnName = "'$name'";
                    if ($digits) {
                        $columnName = "'$name'" . ', ' . $digits;
                    }

                    $type = substr($value, 0, strcspn($value, '('));
                    $line .= '->' . $type . "($columnName)";
                } elseif ($key === 'unique') {
                    if ($value) {
                        $line .= '->unique()';
                    }
                } elseif ($key === 'nullable') {
                    if ($value) {
                        $line .= '->nullable()';
                    }
                } elseif ($key === 'index') {
                    if ($value) {
                        $line .= '->index()';
                    }
                } elseif ($key === 'unsigned') {
                    if ($value) {
                        $line .= '->unsigned()';
                    }
                } elseif ($key === 'default') {
                    if (is_string($value)) {
                        $line .= "->default('$value')";
                    } else {
                        $line .= "->default($value)";
                    }
                } elseif ($key === 'comment') {
                    $line .= "->comment('$value')";
                }
            }
        }

        $line = '$table' . $line . ';';

        if ($isFirst) {
            return $line;
        }

        return PHP_EOL . '            ' . $line;
    }

    /**
     * foreign constraint migration generate.
     *
     * @return void
     */
    private function foreignMigration()
    {
        $migrationTexts = [];

        foreach ($this->relations as $tableName => $relations) {
            foreach ($relations as $relation) {
                $createForeign = sprintf(
                    '->foreign(\'%s\')->references(\'%s\')->on(\'%s\')',
                    array_get($relation, 'foreign'),
                    array_get($relation, 'references'),
                    array_get($relation, 'on')
                );

                if (array_get($relation, 'onDelete')) {
                    $createForeign .= sprintf("->onDelete('%s')", array_get($relation, 'onDelete'));
                }

                $dropForeign = sprintf(
                    '->dropForeign([\'%s\'])',
                    array_get($relation, 'foreign')
                );

                $migrationTexts[$tableName]['up'][] = '$table' . $createForeign . ';';
                $migrationTexts[$tableName]['down'][] = '$table' . $dropForeign . ';';
            }
        }

        foreach ($migrationTexts as $tableName => $migrationText) {
            $fileName = $this->makeForeignMigrationFileName($tableName);
            $className = $this->makeClassName($fileName);
            $template = $this->templateConstraintText;

            $start = 'Schema::table($this->table, function (Blueprint $table) {';
            $end = PHP_EOL . '        ' . '});';

            $upText = '';
            foreach ($migrationText['up'] as $text) {
                $upText .= PHP_EOL . '            ' . $text;
            }

            $downText = '';
            foreach (array_reverse($migrationText['down']) as $text) {
                $downText .= PHP_EOL . '            ' . $text;
            }

            $upText = $start . $upText . $end;
            $downText = $start . $downText . $end;

            $template = str_replace('_CLASS_NAME_', $className, $template);
            $template = str_replace('_TABLE_NAME_', $tableName, $template);
            $template = str_replace('_UP_', $upText, $template);
            $template = str_replace('_DROP_', $downText, $template);

            $filePath = $this->getPath($fileName, 2);
            $this->writeMigration($filePath, $template);
        }
    }

    /**
     * foreign index migration generate.
     *
     * @return void
     */
    private function indexMigration()
    {
        $migrationTexts = [];

        foreach ($this->indexes as $tableName => $indexes) {
            foreach ($indexes as $index) {
                $fieldsName = $this->makeFieldsName(array_get($index, 'fields'));
                $indexName = $this->makeIndexName($tableName, array_get($index, 'fields'), array_get($index, 'unique'), array_get($index, 'name'));

                $createIndex = sprintf(
                    '->%s(%s, %s)',
                    array_get($index, 'unique') ? 'unique' : 'index',
                    $fieldsName,
                    $indexName
                );

                $indexName = $this->makeIndexName($tableName, array_get($index, 'fields'), array_get($index, 'unique'), array_get($index, 'name'));
                $dropIndex = sprintf(
                    '->%s(%s)',
                    array_get($index, 'unique') ? 'dropUnique' : 'dropIndex',
                    $indexName
                );

                $migrationTexts[$tableName]['up'][] = '$table' . $createIndex . ';';
                $migrationTexts[$tableName]['down'][] = '$table' . $dropIndex . ';';
            }
        }

        foreach ($migrationTexts as $tableName => $migrationText) {
            $fileName = $this->makeIndexMigrationFileName($tableName);
            $className = $this->makeClassName($fileName);
            $template = $this->templateConstraintText;

            $start = 'Schema::table($this->table, function (Blueprint $table) {';
            $end = PHP_EOL . '        ' . '});';

            $upText = '';
            foreach ($migrationText['up'] as $text) {
                $upText .= PHP_EOL . '            ' . $text;
            }

            $downText = '';
            foreach (array_reverse($migrationText['down']) as $text) {
                $downText .= PHP_EOL . '            ' . $text;
            }

            $upText = $start . $upText . $end;
            $downText = $start . $downText . $end;

            $template = str_replace('_CLASS_NAME_', $className, $template);
            $template = str_replace('_TABLE_NAME_', $tableName, $template);
            $template = str_replace('_UP_', $upText, $template);
            $template = str_replace('_DROP_', $downText, $template);

            $filePath = $this->getPath($fileName, 1);
            $this->writeMigration($filePath, $template);
        }
    }

    /**
     * Get the full path to the migration.
     *
     * @param string $name
     * @param string $path
     *
     * @return string
     */
    protected function getPath($name, $unixTime = 0)
    {
        return database_path('migrations') . '/' . $this->getDatePrefix($unixTime) . '_' . $name . '.php';
    }

    /**
     * Get the date prefix for the migration.
     *
     * @return string
     */
    protected function getDatePrefix($unixTime = 0)
    {
        return date('Y_m_d_His', $unixTime);
    }

    protected function makeCreateMigrationFileName($tableName)
    {
        return 'create_' . $tableName . '_table';
    }

    protected function makeForeignMigrationFileName($tableName)
    {
        return 'foreign_' . $tableName . '_table';
    }

    protected function makeIndexMigrationFileName($tableName)
    {
        return 'index_' . $tableName . '_table';
    }

    protected function makeClassName($fileName)
    {
        return ucfirst(camel_case($fileName));
    }

    protected function makeFieldsName(array $fields)
    {
        $name = implode("', '", $fields);

        return "['$name']";
    }

    protected function makeIndexName(string $tableName, array $fields, $unique, $indexName = null)
    {
        $name = '';
        if ($indexName) {
            $name = $indexName;
        } else {
            $type = $unique ? 'unique' : 'index';
            $name = $tableName . '_' . implode('_', $fields) . '_' . $type;
        }

        return "'$name'";
    }

    protected function writeMigration($filePath, $content)
    {
        $outputName = basename($filePath);
        file_put_contents($filePath, $content);

        $this->info("Created Migration: {$outputName}");
    }
}
