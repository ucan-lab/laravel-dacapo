<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Stub\MigrationUpdateStub;

final class LaravelMigrationUpdateStub implements MigrationUpdateStub
{
    /**
     * @return string
     */
    public function getStub(): string
    {
        $filename = app_path('stubs/dacapo.migration.update.stub');

        if (file_exists($filename)) {
            return (string) file_get_contents($filename);
        }

        return (string) file_get_contents(__DIR__ . '/Stub/dacapo.migration.update.stub');
    }
}
