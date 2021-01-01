<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Builder;

use UcanLab\LaravelDacapo\App\Domain\Entity\Schema;

interface DatabaseBuilder
{
    public function hasTableComment(): bool;

    public function makeTableComment(Schema $schema): string;
}
