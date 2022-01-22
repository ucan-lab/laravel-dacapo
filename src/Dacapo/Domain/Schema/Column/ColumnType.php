<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column;

interface ColumnType
{
    public function createMigrationMethod(ColumnName $columnName): string;
}
