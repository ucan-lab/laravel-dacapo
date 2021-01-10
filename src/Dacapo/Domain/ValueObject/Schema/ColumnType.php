<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

interface ColumnType
{
    public function createMigrationMethod(ColumnName $columnName): string;
}
