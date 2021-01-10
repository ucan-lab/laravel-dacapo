<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use Exception;
use Symfony\Component\Yaml\Yaml;
use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SchemaFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SchemaFileList;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\SchemaListRepository;

class InMemorySchemaListRepository implements SchemaListRepository
{
    protected SchemaFileList $schemaFileList;

    /**
     * InMemorySchemaListRepository constructor.
     * @param $schemaFileList
     */
    public function __construct($schemaFileList)
    {
        $this->schemaFileList = $schemaFileList;
    }

    /**
     * @return SchemaList
     * @throws Exception
     */
    public function get(): SchemaList
    {
        $schemaList = new SchemaList();

        foreach ($this->getFiles() as $file) {
            $yaml = $this->parseYaml($file);

            try {
                $schemaList->merge(SchemaList::factoryFromYaml($yaml));
            } catch (Exception $e) {
                throw new Exception(sprintf('%s in %s', $e->getMessage(), $file->getName()), $e->getCode(), $e);
            }
        }

        return $schemaList;
    }

    /**
     * @return bool
     */
    public function init(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function clear(): bool
    {
        return true;
    }

    /**
     * @param SchemaFile $file
     * @return bool
     */
    public function saveFile(SchemaFile $file): bool
    {
        return true;
    }

    /**
     * @return SchemaFileList
     */
    protected function getFiles(): SchemaFileList
    {
        return $this->schemaFileList;
    }

    /**
     * @param SchemaFile $file
     * @return array
     */
    protected function parseYaml(SchemaFile $file): array
    {
        return Yaml::parse($file->getContents());
    }
}
