<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Driver;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;

interface DatabaseDriver
{
    public function isEnabledTableComment(): bool;

    public function makeTableComment(Schema $schema): string;
}
