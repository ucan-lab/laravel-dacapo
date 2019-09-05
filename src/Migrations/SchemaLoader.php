<?php

namespace UcanLab\LaravelDacapo\Migrations;

use Exception;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;
use UcanLab\LaravelDacapo\Storage\Storage;
use UcanLab\LaravelDacapo\Migrations\Schema\Table;
use UcanLab\LaravelDacapo\Migrations\Schema\Tables;

class SchemaLoader
{
    private $tables;
    private $schemasStorage;

    public function __construct(Storage $schemasStorage)
    {
        $this->tables = new Tables();
        $this->schemasStorage = $schemasStorage;
    }

    /**
     * @return Tables
     * @throws
     */
    public function run(): Tables
    {
        $schemas = $this->getSchemas();

        foreach ($schemas as $tableName => $tableAttributes) {
            $this->tables->add(new Table($tableName, $tableAttributes));
        }

        return $this->tables;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getSchemas(): array
    {
        $files = $this->schemasStorage->getFiles();
        $schemas = [];
        foreach ($files as $file) {
            $yamlContents = $this->getYamlContents($file);
            if ($intersectKey = $this->getDuplicateKey($schemas, $yamlContents)) {
                throw new Exception(sprintf('%s duplicate table name. [%s]', $file->getFilename(), implode(', ', $intersectKey)));
            }

            $schemas += $yamlContents;
        }

        return $schemas;
    }

    /**
     * @param SplFileInfo $file
     * @return array
     */
    private function getYamlContents(SplFileInfo $file): array
    {
        return Yaml::parse(file_get_contents($file->getRealPath()));
    }

    /**
     * Compare array key values and return duplicate keys.
     *
     * @param array $originArray
     * @param array $targetArray
     * @return array
     */
    private function getDuplicateKey(array $originArray, array $targetArray): array
    {
        return array_keys(array_intersect_key($originArray, $targetArray));
    }
}
