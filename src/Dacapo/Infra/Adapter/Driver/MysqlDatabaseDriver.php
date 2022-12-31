<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Driver;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Driver\DatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;

final class MysqlDatabaseDriver implements DatabaseDriver
{
    public function isEnabledTableComment(): bool
    {
        return true;
    }

    public function makeTableComment(Schema $schema): string
    {
        $str = PHP_EOL . PHP_EOL . '        ';
        $str .= sprintf('DB::statement("ALTER TABLE %s COMMENT \'%s\'");', $schema->getTableName(), $schema->getTableComment());

        return $str;
    }
}
