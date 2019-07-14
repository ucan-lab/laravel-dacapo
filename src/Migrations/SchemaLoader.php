<?php

namespace UcanLab\LaravelDacapo\Migrations;

use Symfony\Component\Yaml\Yaml;
use UcanLab\LaravelDacapo\Migrations\Schema\Tables;
use UcanLab\LaravelDacapo\Migrations\Schema\Table;

class SchemaLoader
{
    private $tables;

    public function __construct()
    {
        $this->tables = new Tables();
    }

    public function run(): Tables
    {
        $path = $this->getSchemaPath();
        $yaml = $this->getYamlContents($path);

        foreach ($yaml as $tableName => $tableAttributes) {
            $table = $this->makeTable($tableName, $tableAttributes);
            $this->tables->add($table);
        }

        return $this->tables;
    }

    private function getSchemaPath(): string
    {
        return database_path('schema.yml');
    }

    private function getYamlContents(string $path): array
    {
        return Yaml::parse(file_get_contents($path));
    }

    private function makeTable(string $name, array $attributes): Table
    {
        return new Table($name, $attributes);
    }
}
