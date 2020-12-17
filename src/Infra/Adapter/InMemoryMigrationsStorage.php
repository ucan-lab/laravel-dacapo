<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\App\Port\MigrationsStorage;

class InMemoryMigrationsStorage implements MigrationsStorage
{
    private array $files;

    /**
     * InMemoryMigrationsStorage constructor.
     * @param array $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delete(string $name): bool
    {
        $key = array_search($name, $this->files);
        unset($this->files[$key]);

        return true;
    }

    /**
     * @param string|null $fileName
     * @return string
     */
    protected function getPath(?string $fileName = null): string
    {
        if ($fileName) {
            return '/tmp/' . $fileName;
        }

        return '/tmp';
    }

    /**
     * @param string $name
     * @param string $content
     * @return void
     */
    public function saveFile(string $name, string $content): void
    {
    }
}
