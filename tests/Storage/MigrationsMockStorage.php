<?php

namespace UcanLab\LaravelDacapo\Test\Storage;

use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\Storage\Storage;
use UcanLab\LaravelDacapo\Storage\Files;

class MigrationsMockStorage implements Storage
{
    public function __construct()
    {
        if ($this->exists()) {
            $this->deleteDirectory();
        }

        $this->makeDirectory();
    }

    /**
     * @return Files
     */
    public function getFiles(): Files
    {
        $files = new Files();
        foreach (File::files($this->getPath()) as $file) {
            if ($file->getExtension() === 'php') {
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
        return File::makeDirectory($this->getPath());
    }

    /**
     * @return bool
     */
    public function deleteDirectory(): bool
    {
        return File::deleteDirectory($this->getPath());
    }

    /**
     * @param string|null $path
     * @return string
     */
    public function getPath(?string $path = null): string
    {
        return sys_get_temp_dir() . '/migrations' . ($path ? "/$path" : '');
    }
}
