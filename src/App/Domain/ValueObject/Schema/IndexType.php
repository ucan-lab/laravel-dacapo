<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

interface IndexType
{
    public function createIndexMigrationUpMethod(Index $index): string;
    public function createIndexMigrationDownMethod(Index $index): string;
}
