<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Driver;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Driver\DatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;

final class SqliteDatabaseDriver implements DatabaseDriver
{
    public function isEnabledTableComment(): bool
    {
        return false;
    }

    public function makeTableComment(Schema $schema): string
    {
        return '';
    }
}
