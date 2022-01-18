<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\MigrationListRepository;

class LocalMigrationListRepository implements MigrationListRepository
{
    protected string $basePath;

    /**
     * LocalMigrationListRepository constructor.
     */
    public function __construct()
    {
        $this->basePath = database_path('migrations');
    }

    /**
     * @param MigrationFileList $fileList
     */
    public function saveFileList(MigrationFileList $fileList): void
    {
        foreach ($fileList as $file) {
            $this->saveFile($file);
        }
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
     * @param string|null $fileName
     * @return string
     */
    protected function getPath(?string $fileName = null): string
    {
        if ($fileName) {
            return $this->basePath . '/' . $fileName;
        }

        return $this->basePath;
    }
}
