<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

interface SqlIndexType
{
    public function createIndexMigrationUpMethod(SqlIndex $index): string;
    public function createIndexMigrationDownMethod(SqlIndex $index): string;
}
