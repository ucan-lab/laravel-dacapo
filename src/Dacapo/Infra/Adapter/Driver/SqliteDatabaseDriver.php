<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Driver;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Driver\DatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;

final class SqliteDatabaseDriver implements DatabaseDriver
{
    /**
     * @return bool
     */
    public function isEnabledTableComment(): bool
    {
        return false;
    }

    /**
     * @param Schema $schema
     * @return string
     */
    public function makeTableComment(Schema $schema): string
    {
        return '';
    }
}
