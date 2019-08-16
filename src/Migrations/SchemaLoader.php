<?php

namespace UcanLab\LaravelDacapo\Migrations;

use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;
use UcanLab\LaravelDacapo\Migrations\Schema\Table;
use UcanLab\LaravelDacapo\Migrations\Schema\Tables;

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
        $schemas = $this->getSchemas();

        foreach ($schemas as $tableName => $tableAttributes) {
            $table = $this->makeTable($tableName, $tableAttributes);
            $this->tables->add($table);
        }

        return $this->tables;
    }

    private function getSchemas(): array
    {
        $files = $this->getYamlFiles($this->getSchemaPath());
        $schemas = [];
        foreach ($files as $file) {
            $schemas += $this->getYamlContents($file->getRealPath());
        }

        return $schemas;
    }

    /**
     * @return string
     */
    private function getSchemaPath(): string
    {
        return database_path('schemas');
    }

    /**
     * @param string $path
     * @return array
     */
    private function getYamlFiles(string $path): array
    {
        $files = [];
        foreach (File::files($path) as $file) {
            if ($file->getExtension() === 'yml') {
                $files[] = $file;
            }
        }

        return $files;
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
