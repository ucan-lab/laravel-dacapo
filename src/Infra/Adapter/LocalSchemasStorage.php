<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Infra\Adapter;

use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\App\Port\SchemasStorage;

class LocalSchemasStorage implements SchemasStorage
{
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
     * @param string $name
     * @param string $content
     * @return bool
     */
    public function saveFile(string $name, string $content): bool
    {
        $path = $this->getPath($name);

        File::put($path, $content);

        return true;
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
}
