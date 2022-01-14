<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\Dacapo\UseCase\Shared\Stub\MigrationCreateStub;

class LaravelMigrationCreateStub implements MigrationCreateStub
{
    /**
     * @return string
     */
    public function getStub(): string
    {
        $filename = base_path('stubs/dacapo.migration.create.stub');

        if (file_exists($filename)) {
            return file_get_contents($filename);
        }

        return file_get_contents(__DIR__ . '/Stub/dacapo.migration.create.stub');
    }
}
