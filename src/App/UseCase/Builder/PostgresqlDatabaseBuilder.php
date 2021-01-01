<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Builder;

use UcanLab\LaravelDacapo\App\Domain\Entity\Schema;

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
