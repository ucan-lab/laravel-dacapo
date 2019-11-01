<?php

namespace UcanLab\LaravelDacapo\Storage;

use Illuminate\Support\Facades\File;

class ModelsStorage implements Storage
{
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
        return $this->exists() ? true : File::makeDirectory($this->getPath());
    }

    /**
     * @return bool
     */
    public function deleteDirectory(): bool
    {
        return $this->exists() ? File::deleteDirectory($this->getPath()) : true;
    }

    /**
     * @param string|null $path
     * @return string
     */
    public function getPath(?string $path = null): string
    {
        return app_path() . ($path ? "/$path" : '');
    }
}
