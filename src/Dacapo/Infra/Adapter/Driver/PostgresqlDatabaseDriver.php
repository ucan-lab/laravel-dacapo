<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Driver;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Driver\DatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;

final class PostgresqlDatabaseDriver implements DatabaseDriver
{
    /**
     * @return bool
     */
    public function isEnabledTableComment(): bool
    {
        return true;
    }

    /**
     * @param Schema $schema
     * @return string
     */
    public function makeTableComment(Schema $schema): string
    {
        $str = PHP_EOL . PHP_EOL . '        ';
        $str .= sprintf('DB::statement("COMMENT ON TABLE %s IS \'%s\';");', $schema->getTableName(), $schema->getTableComment());

        return $str;
    }
}
