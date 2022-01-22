<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Builder;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Builder\DatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;

final class MysqlDatabaseBuilder implements DatabaseBuilder
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
        $str .= sprintf('DB::statement("ALTER TABLE %s COMMENT \'%s\'");', $schema->getTableName(), $schema->getTableComment());

        return $str;
    }
}
