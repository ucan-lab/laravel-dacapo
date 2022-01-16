<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Builder;

use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\Schema;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Shared\Builder\DatabaseBuilder;

class SqliteDatabaseBuilder implements DatabaseBuilder
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
