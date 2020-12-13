<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

interface ColumnModifier
{
    public function createMigrationMethod(): string;
}
