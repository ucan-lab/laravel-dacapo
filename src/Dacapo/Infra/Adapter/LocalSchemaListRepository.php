<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use Exception;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SchemaFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SchemaFileList;

class LocalSchemaListRepository implements SchemaListRepository
{
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
     * @param string $path
     * @return bool
     */
    protected function exists(string $path): bool
    {
        return File::exists($path);
    }

    /**
     * @param string|null $fileName
     * @return string
     */
    protected function getPath(?string $fileName = null): string
    {
        if ($fileName) {
            return database_path('schemas') . '/' . $fileName;
        }

        return database_path('schemas');
    }

    /**
     * @return SchemaFileList
     */
    protected function getFiles(): SchemaFileList
    {
        $files = File::files($this->getPath());

        $schemaFileList = new SchemaFileList();

        foreach ($files as $file) {
            $schemaFileList->add(new SchemaFile($file->getFilename(), $file->getContents()));
        }

        return $schemaFileList;
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
