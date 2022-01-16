<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Builder;

use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\Schema;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Shared\Builder\DatabaseBuilder;

class PostgresqlDatabaseBuilder implements DatabaseBuilder
{
    /**
     * @return bool
     */
    public function hasTableComment(): bool
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
