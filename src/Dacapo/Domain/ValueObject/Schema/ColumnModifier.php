<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

interface ColumnModifier
{
    public function createMigrationMethod(): string;
}
