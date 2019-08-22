<?php

namespace UcanLab\LaravelDacapo\Migrations;

use Exception;
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
     * @throws
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

    /**
     * @return array
     * @throws Exception
     */
    private function getSchemas(): array
    {
        $files = $this->getYamlFiles($this->getSchemaPath());
        $schemas = [];
        foreach ($files as $file) {
            $yamlContents = $this->getYamlContents($file->getRealPath());
            if ($intersectKey = $this->getDuplicateKey($schemas, $yamlContents)) {
                throw new Exception(sprintf('%s duplicate table name. [%s]', $file->getFilename(), implode(', ', $intersectKey)));
            }

            $schemas += $yamlContents;
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

    /**
     * @param array $originArray
     * @param array $targetArray
     * @return array
     */
    private function getDuplicateKey(array $originArray, array $targetArray): array
    {
        return array_keys(array_intersect_key($originArray, $targetArray));
    }
}
