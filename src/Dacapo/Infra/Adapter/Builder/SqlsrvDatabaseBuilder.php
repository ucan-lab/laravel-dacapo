<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Builder;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Builder\DatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;

final class SqlsrvDatabaseBuilder implements DatabaseBuilder
{
    /**
     * @return bool
     */
    public function hasTableComment(): bool
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
