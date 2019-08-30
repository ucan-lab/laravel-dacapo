<?php

namespace UcanLab\LaravelDacapo\Test\Storage;

use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\Storage\Storage;
use UcanLab\LaravelDacapo\Storage\Files;

class SchemasMockStorage implements Storage
{
    private $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return Files
     */
    public function getFiles(): Files
    {
        $files = new Files();
        foreach (File::files($this->getPath()) as $file) {
            if ($file->getExtension() === 'yml') {
                $files->add($file);
            }
        }

        return $files;
    }

    /**
     * @param string|null $path
     * @return bool
     */
    public function exists(?string $path = null): bool
    {
        return File::exists($this->getPath($path));
    }

    /**
     * @return bool
     */
    public function makeDirectory(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function deleteDirectory(): bool
    {
        return true;
    }

    /**
     * @param string|null $path
     * @return string
     */
    public function getPath(?string $path = null): string
    {
        return __DIR__ . '/' . $this->dir . ($path ? "/$path" : '');
    }
}
