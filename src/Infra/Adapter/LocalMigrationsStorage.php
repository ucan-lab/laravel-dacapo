<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Infra\Adapter;

use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\App\Port\MigrationsStorage;

class LocalMigrationsStorage implements MigrationsStorage
{
    /**
     * @return array
     */
    public function getFiles(): array
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
     * @param string $contents
     */
    public function saveFile(string $name, string $contents): void
    {
        $path = $this->getPath($name);

        File::put($path, $contents);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delete(string $name): bool
    {
        File::delete($this->getPath($name));

        return true;
    }

    /**
     * @param string|null $fileName
     * @return string
     */
    protected function getPath(?string $fileName = null): string
    {
        if ($fileName) {
            return database_path('migrations') . '/' . $fileName;
        }

        return database_path('migrations');
    }
}
