<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use Illuminate\Filesystem\Filesystem;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseSchemasStorage;

final class LaravelDatabaseSchemasStorage implements DatabaseSchemasStorage
{
    /**
     * @param Filesystem $filesystem
     */
    public function __construct(private Filesystem $filesystem)
    {
    }

    /**
     * @return array<int, string>
     */
    public function getFilePathList(): array
    {
        $schemasPath = database_path('schemas');
        return array_map(fn ($f) => (string) $f->getRealPath(), $this->filesystem->files($schemasPath));
    }
}
