<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Builder;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;

interface DatabaseBuilder
{
    public function hasTableComment(): bool;

    public function makeTableComment(Schema $schema): string;
}
