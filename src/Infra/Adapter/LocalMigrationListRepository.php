<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Infra\Adapter;

use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\App\Port\MigrationListRepository;

class LocalMigrationListRepository implements MigrationListRepository
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
     * @param MigrationFile $file
     */
    public function saveFile(MigrationFile $file): void
    {
        $path = $this->getPath($file->getName());

        File::put($path, $file->getContents());
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
