<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\App\Port\MigrationsStorage;

class DacapoClearCommandUseCase
{
    protected MigrationsStorage $storage;

    /**
     * DacapoClearCommandUseCase constructor.
     * @param MigrationsStorage $storage
     */
    public function __construct(MigrationsStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        $deletedFiles = [];

        foreach ($this->storage->getFiles() as $fileName) {
            if ($this->isFileGeneratedByDacapo($fileName)) {
                if ($this->storage->delete($fileName)) {
                    $deletedFiles[] = $fileName;
                }
            }
        }

        return $deletedFiles;
    }

    /**
     * @param string $fileName
     * @return bool
     */
    private function isFileGeneratedByDacapo(string $fileName): bool
    {
        return Str::startsWith($fileName, '1970_01_01');
    }
}
