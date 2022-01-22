<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use Illuminate\Filesystem\Filesystem;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseSchemasStorage;

final class LaravelDatabaseSchemasStorage implements DatabaseSchemasStorage
{
    private Filesystem $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @return array
     */
    public function getFilePathList(): array
    {
        $schemasPath = database_path('schemas');
        return array_map(fn ($f) => $f->getRealPath(), $this->filesystem->files($schemasPath));
    }
}
