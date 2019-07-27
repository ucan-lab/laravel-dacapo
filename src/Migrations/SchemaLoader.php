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

    /**
     * @return Tables
     */
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

    /**
     * @return string
     */
    private function getSchemaPath(): string
    {
        return database_path('schema.yml');
    }

    /**
     * @param string $path
     * @return array
     */
    private function getYamlContents(string $path): array
    {
        return Yaml::parse(file_get_contents($path));
    }

    /**
     * @param string $name
     * @param array $attributes
     * @return Table
     */
    private function makeTable(string $name, array $attributes): Table
    {
        return new Table($name, $attributes);
    }
}
