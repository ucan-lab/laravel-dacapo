<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Infra\Adapter;

use Exception;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;
use UcanLab\LaravelDacapo\App\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SchemaFile;
use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;

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
            $yaml = $this->getYamlContent($file);

            try {
                $schemaList->merge(SchemaList::factoryFromYaml($yaml));
            } catch (Exception $e) {
                throw new Exception(sprintf('%s, by %s', $e->getMessage(), $file), 0, $e);
            }
        }

        return $schemaList;
    }

    /**
     * @return bool
     */
    public function makeDirectory(): bool
    {
        $path = $this->getPath();

        if ($this->exists($path) === false) {
            File::makeDirectory($path);
        }

        return true;
    }

    /**
     * @return bool
     */
    public function deleteDirectory(): bool
    {
        $path = $this->getPath();

        if ($this->exists($path)) {
            File::deleteDirectory($path);
        }

        return true;
    }

    /**
     * @param SchemaFile $file
     * @return bool
     */
    public function saveFile(SchemaFile $file): bool
    {
        $path = $this->getPath($file->getName());

        File::put($path, $file->getContents());

        return true;
    }

    /**
     * @param string $version
     * @return string
     */
    public function getLaravelDefaultSchemaFile(string $version): string
    {
        return file_get_contents(__DIR__ . '/../Storage/default-schemas/' . $version . '.yml');
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
     * @param string $name
     * @return string
     */
    protected function getContent(string $name): string
    {
        $path = $this->getPath($name);

        return File::get($path);
    }

    /**
     * @return array
     */
    protected function getFiles(): array
    {
        $files = File::files($this->getPath());

        $fileNames = [];

        foreach ($files as $file) {
            $fileNames[] = $file->getFilename();
        }

        return $fileNames;
    }

    /**
     * @param string $name
     * @return array
     */
    protected function getYamlContent(string $name): array
    {
        $path = $this->getPath($name);

        return Yaml::parseFile($path);
    }
}
